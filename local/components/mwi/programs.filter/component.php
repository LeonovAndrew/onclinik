<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    CIBlockElement,
    CPHPCache,
    MWI\PatientsTypes,
    MWI\Program,
    MWI\ProgramsTypesTable;

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

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList();
$patientsTypeId = htmlspecialchars($getParams->getRaw('patientsTypeId'));
$programsTypeId = htmlspecialchars($getParams->getRaw('programsTypeId'));

$arPatientsTypes = PatientsTypes::getList();
$patientsTypeId = $patientsTypeId ? $patientsTypeId : reset($arPatientsTypes)['XML_ID'];

/**
 * cache params
 */
$cacheTtl = 360000;
$obCache = new CPHPCache();
$cacheId = '/MWI/ProgramsTypes_PatientsTypeId=' . $patientsTypeId;
$cachePath = '/programs_types/';

if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
    /**
     * cache is exist
     */

    /**
     * get data from cache
     */
    $vars = $obCache->GetVars();
    $arProgramsTypes = $vars['programs_types'];
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
    $obTaggedCache->registerTag('hlblock_table_' . ProgramsTypesTable::getTableName());
    $obTaggedCache->endTagCache();

    /**
     * get data from database
     */
    $obPrograms = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => Program::getIBlockId(),
            'ACTIVE' => 'Y',
            'PROPERTY_PATIENTS_TYPE' => $patientsTypeId,
        ),
        array(
            'PROPERTY_TYPE',
        ),
        false,
        array()
    );
    $arProgramsTypesId = array();
    while ($arProgramsGroup = $obPrograms->fetch()) {
        $arProgramsTypesId[$arProgramsGroup['PROPERTY_TYPE_VALUE']] = $arProgramsGroup['PROPERTY_TYPE_VALUE'];
    }

    $arProgramsTypes = ProgramsTypesTable::getList(
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
                'UF_XML_ID' => $arProgramsTypesId,
            ),
        )
    )->fetchAll();

    /**
     * write pre-buffered output to the cache file
     * with additional variables
     */
    $obCache->endDataCache(
        array(
            'programs_types' => $arProgramsTypes,
        )
    );
}
foreach ($arPatientsTypes as &$arPatientsType) {
    $arPatientsType['SELECTED'] = $arPatientsType['XML_ID'] == $patientsTypeId;
}

$programsTypeSelected = false;
if (count($arProgramsTypes) == 1) {
    $arProgramsType = reset($arProgramsTypes);
    $arProgramsType['SELECTED'] = true;
    $programsTypeId = $arProgramsType['XML_ID'];
} else {
    foreach ($arProgramsTypes as &$arProgramsType) {
        if ($arProgramsType['XML_ID'] == $programsTypeId) {
            $arProgramsType['SELECTED'] = true;
            $programsTypeSelected = true;
        } else {
            $arProgramsType['SELECTED'] = false;
        }
    }

    $arAllProgramsTypes = array(
        'NAME' => getMessage('ALL_PROGRAMS_TYPES'),
        'XML_ID' => '',
        'SELECTED' => !$programsTypeSelected,
    );
    array_unshift(
        $arProgramsTypes,
        $arAllProgramsTypes
    );

    if (!$programsTypeSelected) {
        $programsTypeId = '';
    }
}

if (!empty($arParams['FILTER_NAME'])) {
    $GLOBALS[$arParams['FILTER_NAME']] = array(
        'PROPERTY_PATIENTS_TYPE' => $patientsTypeId,
        'PROPERTY_TYPE' => $programsTypeId,
    );
}

$arResult = array(
    'patients_types' => $arPatientsTypes,
    'programs_types' => $arProgramsTypes,
    'ajax_path' => $APPLICATION->GetCurPage(),
    'ajax_mode' => $getParams->getRaw('ajax_filter') == 'Y',
);

$this->IncludeComponentTemplate();