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
    MWI\Program,
    MWI\ProgramList,
    MWI\Disease,
    MWI\DiseaseList,
    MWI\Symptom,
    MWI\SymptomList,
    MWI\Stock,
    MWI\StockList,
    MWI\ServiceOffer,
    MWI\ServiceOfferList;

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

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList();
$departmentId = htmlspecialchars($getParams->getRaw('departmentId'));
$directionId = htmlspecialchars($getParams->getRaw('directionId'));
$clinicId = htmlspecialchars($getParams->getRaw('clinicId'));

$arDepartments = Departments::getList();


if (empty($departmentId)) {
    $departmentId = reset($arDepartments)['XML_ID'];
}

$obClinicsList = Stock::getAllClinics();

$obStocksDirectionsList = Stock::getAllDirections();


$obAllClinicsList = Departments::getClinics($departmentId);
foreach ($obClinicsList->getList() as $obClinic) {
    if (!$obAllClinicsList->contains($obClinic->id)) {
        $obClinicsList->remove($obClinic->id);
    }
}
$obClinicsList->makeData();
$obAllDirectionsList = new DirectionList();
foreach ($obClinicsList->getList() as $obClinic) {
    foreach ($obClinic->directionsId as $dirId) {
        $obDirection = new Direction($dirId);

        $obAllDirectionsList->add($obDirection);
    }
}
foreach ($obStocksDirectionsList->getList() as $obDirection) {
    if (!$obAllDirectionsList->contains($obDirection->id)) {
        $obStocksDirectionsList->remove($obDirection->id);
    }
}

if (!$obAllClinicsList->contains($clinicId)) {
    $clinicId = '';
}
if (!$obAllDirectionsList->contains($directionId)) {
    $directionId = '';
}

$obDirectionsList = new DirectionList();
if ($clinicId && $obClinicsList->contains($clinicId)) {
    $obClinic = $obClinicsList->getById($clinicId);
    foreach ($obClinic->directionsId as $dirId) {
        if ($obStocksDirectionsList->contains($dirId)) {
            $obDirection = new Direction($dirId);

            $obDirectionsList->add($obDirection);
        }
    }
} else {
    foreach ($obClinicsList->getList() as $obClinic) {
        foreach ($obClinic->directionsId as $dirId) {
            if ($obStocksDirectionsList->contains($dirId)) {
                $obDirection = new Direction($dirId);

                $obDirectionsList->add($obDirection);
            }
        }
    }
}
$obDirectionsList->makeData();

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

$arResult = array(
    'departments' => $arDepartments,
    'clinics' => $arClinics,
    'directions' => $arDirections,
    'ajax_path' => $APPLICATION->GetCurPage(),
    'ajax_mode' => $getParams->getRaw('ajax_filter') == 'Y',
);

$obSelectedDirectionsList = new DirectionList();
if ($directionId) {
    $obDirection = new Direction($directionId);
    $obSelectedDirectionsList->add($obDirection);
} else {
    $obSelectedDirectionsList = $obDirectionsList;
}

$arSelectedDirectionsId = $obSelectedDirectionsList->isEmpty() ? false : $obSelectedDirectionsList->getIds();

/*
 * programs
 */
/**
 * cache params
 */
$cacheTtl = 360000;
$obCache = new CPHPCache();
$cacheId = '/MWI/Programs_' . 'DId=' . $directionId;
$cachePath = '/programs/';

if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
    /**
     * cache is exist
     */

    /**
     * get data from cache
     */
    $vars = $obCache->GetVars();
    $obProgramsList = $vars['programs'];
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
    $obTaggedCache->registerTag('iblock_id_' . Program::getIBlockId());
    $obTaggedCache->endTagCache();

    $obProgramsList = new ProgramList();
    /**
     * get data from database
     */
    $obPrograms = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => Program::getIBlockId(),
            'ACTIVE' => 'Y',
            array(
                'PROPERTY_DIRECTIONS' => $arSelectedDirectionsId,
            ),
        ),
        false,
        array(),
        array(
            'ID',
        )
    );
    while ($arProgram = $obPrograms->fetch()) {
        $obProgram = new Program($arProgram['ID']);

        $obProgramsList->add($obProgram);
    }

    $obCache->endDataCache(
        array(
            'programs' => $obProgramsList,
        )
    );
}

/*
 * diseases
 */
/**
 * cache params
 */
$cacheTtl = 360000;
$obCache = new CPHPCache();
$cacheId = '/MWI/Diseases_' . 'DId=' . $directionId;
$cachePath = '/diseases/';

if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
    /**
     * cache is exist
     */

    /**
     * get data from cache
     */
    $vars = $obCache->GetVars();
    $obDiseasesList = $vars['diseases'];
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
    $obTaggedCache->registerTag('iblock_id_' . Disease::getIBlockId());
    $obTaggedCache->endTagCache();

    $obDiseasesList = new DiseaseList();
    /**
     * get data from database
     */
    $obDiseases = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => Disease::getIBlockId(),
            'ACTIVE' => 'Y',
            array(
                'PROPERTY_DIRECTIONS' => $arSelectedDirectionsId,
            ),
        ),
        false,
        array(),
        array(
            'ID',
        )
    );
    while ($arDisease = $obDiseases->fetch()) {
        $obDisease = new Disease($arDisease['ID']);

        $obDiseasesList->add($obDisease);
    }

    $obCache->endDataCache(
        array(
            'diseases' => $obDiseasesList,
        )
    );
}

/*
 * symptoms
 */
/**
 * cache params
 */
$cacheTtl = 360000;
$obCache = new CPHPCache();
$cacheId = '/MWI/Symptoms_' . 'DId=' . $directionId;
$cachePath = '/symptoms/';

if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
    /**
     * cache is exist
     */

    /**
     * get data from cache
     */
    $vars = $obCache->GetVars();
    $obSymptomsList = $vars['symptoms'];
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
    $obTaggedCache->registerTag('iblock_id_' . Symptom::getIBlockId());
    $obTaggedCache->endTagCache();

    $obSymptomsList = new SymptomList();
    /**
     * get data from database
     */
    $obSymptoms = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => Symptom::getIBlockId(),
            'ACTIVE' => 'Y',
            array(
                'PROPERTY_DIRECTIONS' => $arSelectedDirectionsId,
            ),
        ),
        false,
        array(),
        array(
            'ID',
        )
    );
    while ($arSymptom = $obSymptoms->fetch()) {
        $obSymptom = new Symptom($arSymptom['ID']);

        $obSymptomsList->add($obSymptom);
    }

    $obCache->endDataCache(
        array(
            'symptoms' => $obSymptomsList,
        )
    );
}

$obStocksList = $obSelectedDirectionsList->getStocks();

$obProgramsStocksList = $obProgramsList->getStocks();
foreach ($obProgramsStocksList->getIds() as $stockId) {
    if (!$obStocksList->contains($stockId)) {
        $obStock = new Stock($stockId);

        $obStocksList->add($obStock);
    }
}

$obDiseasesStocksList = $obDiseasesList->getStocks();
foreach ($obDiseasesStocksList->getIds() as $stockId) {
    if (!$obStocksList->contains($stockId)) {
        $obStock = new Stock($stockId);

        $obStocksList->add($obStock);
    }
}

$obSymptomsStocksList = $obSymptomsList->getStocks();
foreach ($obSymptomsStocksList->getIds() as $stockId) {
    if (!$obStocksList->contains($stockId)) {
        $obStock = new Stock($stockId);

        $obStocksList->add($obStock);
    }
}

if (!empty($arParams['FILTER_NAME'])) {
    $GLOBALS[$arParams['FILTER_NAME']] = array(
		'PROPERTY_CLIENTS_TYPE' => $departmentId,
        'PROPERTY_CLINICS' => $clinicId ? $clinicId : ($obClinicsList->isEmpty() ? false : $obClinicsList->getIds()),
        'ID' => $obStocksList->isEmpty() ? false : $obStocksList->getIds(),
    );
	//echo "<pre>";
	//print_r( $GLOBALS[$arParams['FILTER_NAME']] );
	//echo "</pre>";
}

$this->IncludeComponentTemplate();
