<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    CIBlockElement,
    CPHPCache,
    MWI\Clinic,
    MWI\Cities,
    MWI\ClinicsTypesTable,
    MWI\CitiesTable;

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
$cityId = htmlspecialchars($getParams->getRaw('cityId'));
$typeId = htmlspecialchars($getParams->getRaw('typeId'));

$getTypeId = $typeId;

$arCities = Cities::getList();

if (empty($cityId)) {
    $cityId = reset($arCities)['XML_ID'];
}

/**
 * cache params
 */
$cacheTtl = 360000;
$obCache = new CPHPCache();
$cacheId = '/MWI/ClinicsTypes_' . 'CityId=' . $cityId;
$cachePath = '/clinics_types/';

if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
    /**
     * cache is exist
     */

    /**
     * get data from cache
     */
    $vars = $obCache->GetVars();
    $arClinicsTypes = $vars['clinics_types'];
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
    $obTaggedCache->registerTag('hlblock_table_' . CitiesTable::getTableName());
    $obTaggedCache->registerTag('hlblock_table_' . ClinicsTypesTable::getTableName());
    $obTaggedCache->endTagCache();

    /**
     * get data from database
     */
    //get clinics types list for current city
    $obClinics = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => Clinic::getIBlockId(),
            'ACTIVE' => 'Y',
            'PROPERTY_CITY' => $cityId,
        ),
        array(
            'PROPERTY_TYPE'
        ),
        array(),
        array()
    );
    $arClinicsTypesId = array();
    while ($arClinicsGroup = $obClinics->fetch()) {
        $arClinicsTypesId[$arClinicsGroup['PROPERTY_TYPE_VALUE']] = $arClinicsGroup['PROPERTY_TYPE_VALUE'];
    }

    $arClinicsTypes = ClinicsTypesTable::getList(
        array(
            "select" => array(
                'ID',
                'NAME' => 'UF_NAME',
                'XML_ID' => 'UF_XML_ID',
            ),
            "order" => array(
                'UF_SORT' => 'ASC',
            ),
            "filter" => array(
                'UF_XML_ID' => $arClinicsTypesId,
            ),
        )
    )->fetchAll();

    /**
     * write pre-buffered output to the cache file
     * with additional variables
     */
    $obCache->endDataCache(
        array(
            'clinics_types' => $arClinicsTypes,
        )
    );
}

foreach ($arCities as &$arCity) {
    $arCity['SELECTED'] = $cityId == $arCity['XML_ID'];
}



$clinicsTypeSelected = false;
//if (count($arClinicsTypes) == 1) {
//    $arClinicsType = reset($arClinicsTypes);
 //   $arClinicsType['SELECTED'] = true;
//    $typeId = $arClinicsType['XML_ID'];
//} else {
    foreach ($arClinicsTypes as &$arClinicsType) {
        if ($arClinicsType['XML_ID'] == $typeId) {
            $arClinicsType['SELECTED'] = true;
            $clinicsTypeSelected = true;
        } else {
            $arClinicsType['SELECTED'] = false;
        }
    }

    $arAllClinicsTypes = array(
        'NAME' => getMessage('ALL_CLINICS_TYPES'),
        'XML_ID' => '',
        'SELECTED' => !$clinicsTypeSelected,
    );
    array_unshift(
        $arClinicsTypes,
        $arAllClinicsTypes
    );

    if (!$clinicsTypeSelected) {
        $typeId = '';
    }
//}

$arResult = array(
    'cities' => $arCities,
    'clinics_types' => $arClinicsTypes,
    'ajax_path' => $APPLICATION->GetCurPage(),
    'ajax_mode' => $getParams->getRaw('ajax_filter') == 'Y',
    'search_query' => $searchQuery,
);

if (!empty($arParams['FILTER_NAME'])) {
    $GLOBALS[$arParams['FILTER_NAME']] = array(
        'PROPERTY_CITY' => $cityId,
        'PROPERTY_TYPE' => $typeId,
    );
}

$this->IncludeComponentTemplate();
