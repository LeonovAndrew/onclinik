<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    CIBlockElement,
    CPHPCache,
    MWI\Review,
    MWI\Direction,
    MWI\DirectionList,
    MWI\Clinic,
    MWI\ClinicList,
    MWI\Personal,
    MWI\PersonalList;

/**
 * @var CBitrixComponent $this
 * @var array $arParams
 * @var array $arResult
 * @var string $componentPath
 * @var string $componentName
 * @var string $componentTemplate
 * @global CDatabase $DB
 * @global CUser $USER
 * @global CMain $APPLICATION
 */
global $DB;
global $USER;
global $APPLICATION;

Loader::includeModule('iblock');
Loader::includeModule('search');

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList();
$directionId = htmlspecialchars($getParams->getRaw('directionId'));
$clinicId = htmlspecialchars($getParams->getRaw('clinicId'));
$searchQuery = htmlspecialchars($getParams->getRaw('search'));
$displayed = htmlspecialchars($getParams->getRaw('displayed'));

$reviewsDirectionsList = Review::getAllDirections();
$reviewsClinicsList = Review::getAllClinics();
$reviewsDoctorsList = Review::getAllDoctors();

$arReviewsDirectionsId = $reviewsDirectionsList->getIds();
$arReviewsClinicsId = $reviewsClinicsList->getIds();
$arReviewsDoctorsId = $reviewsDoctorsList->getIds();

if (!empty($searchQuery)) {
    $obSearch = new CSearch();
    $obSearch->Search(
        array(
            'QUERY' => $searchQuery,
            'SITE_ID' => SITE_ID,
            'MODULE_ID' => 'iblock',
            'PARAM1' => Personal::getIBlockType(),
            'PARAM2' => Personal::getIBlockId(),
            'ITEM_ID' => count($arReviewsDoctorsId) == 1 ? reset($arReviewsDoctorsId) : $arReviewsDoctorsId,
        )
    );
    $obSearch->NavStart();

    $foundDoctorsList = new PersonalList();
    while ($arSearch = $obSearch->Fetch()) {
        $obDoctor = new Personal($arSearch['ITEM_ID']);

        $foundDoctorsList->add($obDoctor);
    }

    //remove doctors which don't match search query
    foreach (array_diff($arReviewsDoctorsId, $foundDoctorsList->getIds()) as $doctorId) {
        $reviewsDoctorsList->remove($doctorId);
    }
} else {
    //get doctors for reviews
    $obReviews = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => Review::getIBlockId(),
            'ACTIVE' => 'Y',
        ),
        array(
            'PROPERTY_DOCTOR',
        ),
        array(),
        array()
    );
    $reviewsDoctorsList = new PersonalList();
    while ($arReviewGroup = $obReviews->fetch()) {
        if (!empty($arReviewGroup['PROPERTY_DOCTOR_VALUE'])) {
            $obDoctor = new Personal($arReviewGroup['PROPERTY_DOCTOR_VALUE']);

            $reviewsDoctorsList->add($obDoctor);
        }
    }
}

/**
 * cache params
 */
$cacheTtl = 360000;
$obCache = new CPHPCache();
$cacheId = '/MWI/Reviews_Filter_' . 'DId=' . $directionId . '_CId=' . $clinicId . '_SiteId=' . SITE_ID;
$cachePath = '/reviews_filter/';

if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
    /**
     * cache is exist
     */

    /**
     * get data from cache
     */
    $vars = $obCache->GetVars();
    $directionsList = $vars['directions'];
    $clinicsList = $vars['clinics'];
} else {
    /**
     * start buffering the output
     */
    $obCache->startDataCache();

    /**
     * add tags for cache
     */
    $obTaggedCache = Application::getInstance()->getTaggedCache();
    $obTaggedCache->startTagCache($cachePath);
    $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
    $obTaggedCache->registerTag('iblock_id_' . Clinic::getIBlockId());
    $obTaggedCache->registerTag('iblock_id_' . Review::getIBlockId());
    $obTaggedCache->endTagCache();

    /**
     * get data from database
     */

    //get clinics
    $obClinics = CIBlockElement::getList(
        array(
            'SORT' => 'ASC',
        ),
        array(
            'IBLOCK_ID' => Clinic::getIBlockId(),
            'ACTIVE' => 'Y',
            'PROPERTY_DIRECTIONS' => $directionId ? $directionId : $arReviewsDirectionsId,
        ),
        false,
        array(),
        array(
            'ID',
            'NAME',
            'PROPERTY_DIRECTIONS',
        )
    );
    $clinicsList = new ClinicList();
    if ($clinicId) {
        $clinicDirectionsList = new DirectionList();
    }
    while ($arClinic = $obClinics->fetch()) {
        $obClinic = new Clinic($arClinic['ID']);
        $obClinic->name = $arClinic['NAME'];

        $clinicsList->add($obClinic);

        if ($clinicId == $arClinic['ID']) {
            //collect directions for current clinic
            foreach ($arClinic['PROPERTY_DIRECTIONS_VALUE'] as $clinicDirectionId) {
                $obDirection = new Direction($clinicDirectionId);

                $clinicDirectionsList->add($obDirection);
            }
        }
    }

    $arClinicsId = $clinicsList->getIds();

    $arClinicsId = $directionId ? array_intersect($arReviewsClinicsId, $clinicsList->getIds()) : $arReviewsClinicsId;
    if (!empty($arClinicsId)) {
        //remove extra clinics
        foreach (array_diff($arReviewsClinicsId, $arClinicsId) as $clinId) {
            $reviewsClinicsList->remove($clinId);
        }
    } else {
        $arClinicsId = false;
    }

    $arDirectionsId = $clinicId ? array_intersect($arReviewsDirectionsId, $clinicDirectionsList->getIds()) : $arReviewsDirectionsId;
    if (!empty($arDirectionsId)) {
        //remove extra directions
        foreach (array_diff($arReviewsDirectionsId, $arDirectionsId) as $dirId) {
            $reviewsDirectionsList->remove($dirId);
        }
    } else {
        $arDirectionsId = false;
    }

    //get directions for filter
    $obDirections = CIBlockElement::getList(
        array(
            'SORT' => 'ASC',
        ),
        array(
            'IBLOCK_ID' => Direction::getIBlockId(),
            'ACTIVE' => 'Y',
            'ID' => $arDirectionsId,
        ),
        false,
        array(),
        array(
            'ID',
            'NAME',
        )
    );
    $directionsList = new DirectionList();
    while ($arDirection = $obDirections->fetch()) {
        $obDirection = new Direction($arDirection['ID']);
        $obDirection->name = $arDirection['NAME'];

        $directionsList->add($obDirection);
    }

    //get clinics for filter
    $obClinics = CIBlockElement::getList(
        array(
            'SORT' => 'ASC',
        ),
        array(
            'IBLOCK_ID' => Clinic::getIBlockId(),
            'ACTIVE' => 'Y',
            'ID' => $arClinicsId,
        ),
        false,
        array(),
        array(
            'ID',
            'NAME',
        )
    );
    $clinicsList = new ClinicList();
    while ($arClinic = $obClinics->fetch()) {
        $obClinic = new Clinic($arClinic['ID']);
        $obClinic->name = $arClinic['NAME'];

        $clinicsList->add($obClinic);
    }

    /**
     * write pre-buffered output to the cache file
     * with additional variables
     */
    $obCache->endDataCache(
        array(
            'directions' => $directionsList,
            'clinics' => $clinicsList,
        )
    );
}

//get directions for reviews
$reviewsDirectionsList = new DirectionList();
if ($directionId) {
    $obDirection = new Direction($directionId);

    $reviewsDirectionsList->add($obDirection);
} else {
    $reviewsDirectionsList = $directionsList;
}

//get clinics for reviews
$reviewsClinicsList = new ClinicList();
if ($clinicId) {
    $obClinic = new Clinic($clinicId);

    $reviewsClinicsList->add($obClinic);
} else {
    $reviewsClinicsList = $clinicsList;
}

if (!empty($arParams['FILTER_NAME'])) {
    $GLOBALS[$arParams['FILTER_NAME']] = array(
        'PROPERTY_DIRECTION' => $reviewsDirectionsList->isEmpty() ? false : $reviewsDirectionsList->getIds(),
        'PROPERTY_CLINIC' => $reviewsClinicsList->isEmpty() ? false : $reviewsClinicsList->getIds(),
    );
    if (!empty($searchQuery)) {
        $GLOBALS[$arParams['FILTER_NAME']]['PROPERTY_DOCTOR'] = $reviewsDoctorsList->isEmpty() ? false : $reviewsDoctorsList->getIds();
    } else {
        $GLOBALS[$arParams['FILTER_NAME']]['PROPERTY_DOCTOR'] = $reviewsDoctorsList->isEmpty() ? '' : $reviewsDoctorsList->getIds();
    }
}

$arDirections = array();
$directionNotSelected = true;

foreach ($directionsList->getList() as $obDirection) {
    if ($directionId == $obDirection->id) {
        $directionNotSelected = false;
    }
    $arDirections[] = array(
        'ID' => $obDirection->id,
        'NAME' => $obDirection->name,
        'SELECTED' => $directionId == $obDirection->id ? true : false,
    );
}
array_unshift(
    $arDirections,
    array(
        'ID' => '',
        'NAME' => getMessage('ALL_DIRECTIONS'),
        'SELECTED' => $directionNotSelected
    )
);

$arClinics = array();
$clinicNotSelected = true;
foreach ($clinicsList->getList() as $obClinic) {
    if ($clinicId == $obClinic->id) {
        $clinicNotSelected = false;
    }
    $arClinics[] = array(
        'ID' => $obClinic->id,
        'NAME' => $obClinic->name,
        'SELECTED' => $clinicId == $obClinic->id ? true : false,
    );
}
array_unshift(
    $arClinics,
    array(
        'ID' => '',
        'NAME' => getMessage('ALL_CLINICS'),
        'SELECTED' => $clinicNotSelected
    )
);

/**
 * cache params
 */
$cacheTtl = 360000;
$obCache = new CPHPCache();
$cacheId = '/MWI/Reviews_Doctors_' . 'ClinicId=' . $clinicId . '_DirectionId=' . $directionId . '_SiteId=' . SITE_ID;
$cachePath = '/doctors/';
if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
    /**
     * cache is exist
     */

    /**
     * get data from cache
     */
    $vars = $obCache->GetVars();
    $obHintsDoctorsList = $vars['doctors'];
} else {
    /**
     * start buffering the output
     */
    $obCache->startDataCache();

    /**
     * add tags for cache
     */
    $obTaggedCache = Application::getInstance()->getTaggedCache();
    $obTaggedCache->startTagCache($cachePath);
    $obTaggedCache->registerTag('iblock_id_' . Personal::getIBlockId());
    $obTaggedCache->registerTag('iblock_id_' . Review::getIBlockId());
    $obTaggedCache->endTagCache();

    /**
     * get data from database
     */
    $obReviews = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => Review::getIBlockId(),
            'ACTIVE' => 'Y',
            'PROPERTY_DIRECTION' => $reviewsDirectionsList->isEmpty() ? false : $reviewsDirectionsList->getIds(),
            'PROPERTY_CLINIC' => $reviewsClinicsList->isEmpty() ? false : $reviewsClinicsList->getIds(),
        ),
        false,
        array(),
        array(
            'ID',
            'PROPERTY_DOCTOR.ID',
            'PROPERTY_DOCTOR.NAME',
        )
    );
    $obHintsDoctorsList = new PersonalList();

    while ($arReview = $obReviews->fetch()) {
        if (!empty($arReview['PROPERTY_DOCTOR_NAME']) && !$obHintsDoctorsList->contains($arReview['PROPERTY_DOCTOR_ID'])) {
            $obDoctor = new Personal($arReview['PROPERTY_DOCTOR_ID']);
            $obDoctor->name = $arReview['PROPERTY_DOCTOR_NAME'];

            $obHintsDoctorsList->add($obDoctor);
        }
    }

    /**
     * write pre-buffered output to the cache file
     * with additional variables
     */
    $obCache->endDataCache(
        array(
            'doctors' => $obHintsDoctorsList,
        )
    );
}

$arHintsDoctors = array();
foreach ($obHintsDoctorsList->getList() as $obDoctor) {
    $arHintsDoctors[] = $obDoctor->name;
}

$arResult = array(
    'directions' => $arDirections,
    'clinics' => $arClinics,
    'hints_doctors' => $arHintsDoctors,
    'ajax_path' => $APPLICATION->GetCurPage(),
    'ajax_mode' => $getParams->getRaw('ajax_filter') == 'Y',
    'search_query' => $searchQuery,
);

$this->IncludeComponentTemplate();

$arDisplayed = !empty($displayed) ? Review::updateDisplayed($displayed) : $arDisplayed = Review::getDisplayed();

return array(
    'displayed' => $arDisplayed,
);