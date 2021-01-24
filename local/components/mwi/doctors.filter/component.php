<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    CIBlockElement,
    CPHPCache,
    MWI\DepartmentsTable,
    MWI\Departments,
    MWI\Clinic,
    MWI\ClinicList,
    MWI\Direction,
    MWI\DirectionList,
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

Loader::includeModule('search');

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList();
$departmentId = htmlspecialchars($getParams->getRaw('departmentId'));
$directionId = htmlspecialchars($getParams->getRaw('directionId'));
$clinicId = htmlspecialchars($getParams->getRaw('clinicId'));
$searchQuery = htmlspecialchars($getParams->getRaw('search'));

$arDepartments = Departments::getList();

if (empty($departmentId)) {
    $departmentId = reset($arDepartments)['XML_ID'];
}

$obAllClinicsList = Departments::getClinics($departmentId);
$obAllClinicsList->makeData();
$obAllDirectionsList = new DirectionList();
foreach ($obAllClinicsList->getList() as $obClinic) {
    foreach ($obClinic->directionsId as $dirId) {
        $obDirection = new Direction($dirId);

        $obAllDirectionsList->add($obDirection);
    }
}

if (!$obAllClinicsList->getById($clinicId)) {
    $clinicId = '';
}
if (!$obAllDirectionsList->getById($directionId)) {
    $directionId = '';
}

$obDoctorsList = Personal::getDoctors();
$arDoctorsId = $obDoctorsList->getIds();

if (!empty($searchQuery)) {
    $obSearch = new CSearch();
    $obSearch->Search(
        array(
            'QUERY' => $searchQuery,
            'SITE_ID' => SITE_ID,
            'MODULE_ID' => 'iblock',
            'PARAM1' => Personal::getIBlockType(),
            'PARAM2' => Personal::getIBlockId(),
            'ITEM_ID' => $obDoctorsList->size() == 1 ? reset($arDoctorsId) : $arDoctorsId,
        )
    );
    $obSearch->NavStart();

    $foundDoctorsList = new PersonalList();
    while ($arSearch = $obSearch->Fetch()) {
	
		
        $obDoctor = new Personal($arSearch['ITEM_ID']);
		if ( $searchQuery == $arSearch['TITLE'] ){
			$foundDoctorsList = new PersonalList();	
			$foundDoctorsList->add($obDoctor);
			break;
		}
        $foundDoctorsList->add($obDoctor);
		
		
    }

    //remove doctors which don't match search query
    foreach (array_diff($arDoctorsId, $foundDoctorsList->getIds()) as $doctorId) {
        $obDoctorsList->remove($doctorId);
    }
}

/**
 * cache params
 */
$cacheTtl = 360000;
$obCache = new CPHPCache();
$cacheId = '/MWI/Clinics_' . 'DepartmentId=' . $departmentId . '_DirectionId=' . $directionId . '_SiteId=' . SITE_ID;
$cachePath = '/clinics/';

if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
    /**
     * cache is exist
     */

    /**
     * get data from cache
     */
    $vars = $obCache->GetVars();
    $obClinicsList = $vars['clinics'];
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
    $obTaggedCache->registerTag('iblock_id_' . Clinic::getIBlockId());
    $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
    $obTaggedCache->registerTag('hlblock_table_' . DepartmentsTable::getTableName());
    $obTaggedCache->endTagCache();

    /**
     * get data from database
     */
    $obClinics = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => Clinic::getIBlockId(),
            'ACTIVE' => 'Y',
            'PROPERTY_DEPARTMENTS' => $departmentId,
            'PROPERTY_DIRECTIONS' => $directionId,
        ),
        false,
        array(),
        array(
            'ID',
            'NAME',
            'PROPERTY_DIRECTIONS',
        )
    );
    $obClinicsList = new ClinicList();
    while ($arClinic = $obClinics->fetch()) {
        $obClinic = new Clinic($arClinic['ID']);
        $obClinic->name = $arClinic['NAME'];
        $obClinic->directionsId = $arClinic['PROPERTY_DIRECTIONS_VALUE'];

        $obClinicsList->add($obClinic);
    }

    /**
     * write pre-buffered output to the cache file
     * with additional variables
     */
    $obCache->endDataCache(
        array(
            'clinics' => $obClinicsList,
        )
    );
}

$obDirectionsList = new DirectionList();
if ($clinicId && $obClinicsList->contains($clinicId)) {
    $obClinic = $obClinicsList->getById($clinicId);
    foreach ($obClinic->directionsId as $dirId) {
        $obDirection = new Direction($dirId);

        $obDirectionsList->add($obDirection);
    }
} else {
    foreach ($obClinicsList->getList() as $obClinic) {
        foreach ($obClinic->directionsId as $dirId) {
            $obDirection = new Direction($dirId);

            $obDirectionsList->add($obDirection);
        }
    }
}
$obDirectionsList->makeData();
//remove non-active directions
foreach ($obDirectionsList->getList() as $obDirection) {
    if (!$obDirection->name) {
        $obDirectionsList->remove($obDirection->id);
    }
}

foreach ($arDepartments as &$arDepartment) {
    $arDepartment['SELECTED'] = $departmentId == $arDepartment['XML_ID'];
}

$arClinics = array();
$clinicSelected = false;
foreach ($obClinicsList->getList() as $obClinic) {
    if ($clinicId == $obClinic->id) {
        $clinicSelected = true;
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
        'SELECTED' => !$clinicSelected,
    )
);

$arDirections = array();
$directionSelected = false;
foreach ($obDirectionsList->getList() as $obDirection) {
    if ($directionId == $obDirection->id) {
        $directionSelected = true;
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
        'SELECTED' => !$directionSelected,
    )
);

if (!empty($arParams['FILTER_NAME'])) {
    $GLOBALS[$arParams['FILTER_NAME']] = array(
        'PROPERTY_DEPARTMENT' => $departmentId,
        'PROPERTY_CLINICS' => $clinicId ? $clinicId : ($obClinicsList->isEmpty() ? false : $obClinicsList->getIds()),
        'PROPERTY_DIRECTION' => $directionId ? $directionId : ($obDirectionsList->isEmpty() ? false : $obDirectionsList->getIds()),
        'ID' => $obDoctorsList->isEmpty() ? false : $obDoctorsList->getIds(),
    );
}

/**
 * cache params
 */
$cacheTtl = 360000;
$obCache = new CPHPCache();
$cacheId = '/MWI/Doctors_' . 'ClinicId=' . $clinicId . '_DirectionId=' . $directionId . '_DepartmentId=' . $departmentId  . '_SiteId=' . SITE_ID;
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
    $obTaggedCache->endTagCache();

    /**
     * get data from database
     */
    $arFilter = array(
        'IBLOCK_ID' => Personal::getIBlockId(),
        'ACTIVE' => 'Y',
        'PROPERTY_DOCTOR' => true,
    );
    if ($clinicId != '') {
        $arFilter['PROPERTY_CLINICS'] = $obClinicsList->isEmpty() ? false : $obClinicsList->getIds();
    }
    if ($directionId != '') {
        $arFilter['PROPERTY_DIRECTION'] = $obDirectionsList->isEmpty() ? false : $obDirectionsList->getIds();
    }
    $obDoctors = CIBlockElement::getList(
        array(),
        $arFilter,
        false,
        array(),
        array(
            'ID',
            'NAME',
        )
    );
    $obHintsDoctorsList = new PersonalList();
    while ($arDoctor = $obDoctors->fetch()) {
        $obDoctor = new Personal($arDoctor['ID']);
        $obDoctor->name = $arDoctor['NAME'];

        $obHintsDoctorsList->add($obDoctor);
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
    'departments' => $arDepartments,
    'clinics' => $arClinics,
    'directions' => $arDirections,
    'search_query' => $searchQuery,
    'hints_doctors' => $arHintsDoctors,
    'ajax_path' => $APPLICATION->GetCurPage(),
    'ajax_mode' => $getParams->getRaw('ajax_filter') == 'Y',
);

$this->IncludeComponentTemplate();
