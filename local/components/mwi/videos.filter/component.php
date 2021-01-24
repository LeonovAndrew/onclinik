<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    CIBlockElement,
    CPHPCache,
    MWI\VideoTypesTable,
    MWI\VideoTypes,
    MWI\Clinic,
    MWI\ClinicList,
    MWI\Direction,
    MWI\DirectionList,
    MWI\Personal,
    MWI\PersonalList;
use MWI\Video;

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
$typeId = htmlspecialchars($getParams->getRaw('typeId'));
$directionId = htmlspecialchars($getParams->getRaw('directionId'));
$clinicId = htmlspecialchars($getParams->getRaw('clinicId'));

$arTypes = VideoTypes::getList();
$typeSelected = false;
foreach ($arTypes as &$arType) {
    if ($typeId == $arType['XML_ID']) {
        $typeSelected = true;
    }
    $arType['SELECTED'] = $typeId == $arType['XML_ID'] ? true : false;
}
array_unshift(
    $arTypes,
    array(
        'XML_ID' => '',
        'NAME' => getMessage('ALL_TYPES'),
        'SELECTED' => !$typeSelected,
    )
);
if (!$typeSelected) {
    $typeId = '';
}

//get directions list
/**
 * cache params
 */
$cacheTtl = 360000;
$obCache = new CPHPCache();
$cacheId = '/MWI/Videos_Directions_Clinics_' . 'TypeId=' . $typeId;
$cachePath = '/videos/';

if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
    /**
     * cache is exist
     */

    /**
     * get data from cache
     */
    $vars = $obCache->GetVars();
    $obDirectionsList = $vars['directions'];
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
    $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
    $obTaggedCache->registerTag('iblock_id_' . Clinic::getIBlockId());
    $obTaggedCache->registerTag('hlblock_table_' . VideoTypesTable::getTableName());
    $obTaggedCache->endTagCache();

    /**
     * get data from database
     */
    $obAllDirectionsList = Video::getAllDirections();
    $arFilter = $typeId ? array('XML_ID' => $typeId) : array();
    $obTypes = VideoTypesTable::getList(
        array(
            "select" => array(
                'ID',
                'XML_ID' => 'UF_XML_ID',
            ),
            "filter" => $arFilter,
        )
    );
    $arTypesId = array();
    while ($arType = $obTypes->fetch()) {
        $arTypesId[$arType['XML_ID']] = $arType['XML_ID'];
    }

    $obVideo = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => Video::getIBlockId(),
            'ACTIVE' => 'Y',
            'PROPERTY_TYPE' => $arTypesId,
        ),
        false,
        array(),
        array(
            'ID',
            'PROPERTY_DIRECTION',
        )
    );
    $obDirectionsList = new DirectionList();
    while ($arVideo = $obVideo->fetch()) {
		if ( $arVideo['PROPERTY_DIRECTION_VALUE'] ){
			$obDirection = new Direction($arVideo['PROPERTY_DIRECTION_VALUE']);
			$obDirectionsList->add($obDirection);
		}
    }
    $obDirectionsList->makeData();

    $obVideo = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => Video::getIBlockId(),
            'ACTIVE' => 'Y',
            'PROPERTY_TYPE' => $arTypesId,
            'PROPERTY_DIRECTION' => $directionId,
            '!PROPERTY_CLINIC' => false,
        ),
        false,
        array(),
        array(
            'ID',
            'PROPERTY_CLINIC',
        )
    );
    $obClinicsList = new ClinicList();
    while ($arVideo = $obVideo->fetch()) {
        $obClinic = new Clinic($arVideo['PROPERTY_CLINIC_VALUE']);

        $obClinicsList->add($obClinic);
    }
    $obClinicsList->makeData();

    /**
     * write pre-buffered output to the cache file
     * with additional variables
     */
    $obCache->endDataCache(
        array(
            'directions' => $obDirectionsList,
            'clinics' => $obClinicsList,
        )
    );
}

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
if (!$directionSelected) {
    $directionId = '';
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
if (!$clinicSelected) {
    $clinicId = '';
}

$arResult = array(
    'types' => $arTypes,
    'clinics' => $arClinics,
    'directions' => $arDirections,
    'ajax_path' => $APPLICATION->GetCurPage(),
    'ajax_mode' => $getParams->getRaw('ajax_filter') == 'Y',
);

if (!empty($arParams['FILTER_NAME'])) {
    $GLOBALS[$arParams['FILTER_NAME']] = array(
        'PROPERTY_TYPE' => $typeId,
        'PROPERTY_DIRECTION' => $directionId,
        'PROPERTY_CLINIC' => $clinicId,
    );
}

$this->IncludeComponentTemplate();
