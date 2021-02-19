<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\ProgramsTypesTable;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

/**
 * get types list
 */
$arProgramsTypes = array();
foreach ($arResult['ITEMS'] as $arItem) {
    if (!empty($arItem['PROPERTIES']['TYPE']['VALUE'])) {
        $arProgramsTypes[$arItem['PROPERTIES']['TYPE']['VALUE']] = $arItem['PROPERTIES']['TYPE']['VALUE'];
    }
}

$obProgramsTypes = ProgramsTypesTable::getList(
    array(
        "select" => array(
            'ID',
            'UF_NAME',
            'UF_XML_ID',
        ),
        "order" => array(),
        "filter" => array(
            'UF_XML_ID' => $arProgramsTypes,
        ),
    )
);
while ($arProgramType = $obProgramsTypes->fetch()) {
    $arProgramsTypes[$arProgramType['UF_XML_ID']] = $arProgramType['UF_NAME'];
}

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['PROGRAM_TYPE'] = $arProgramsTypes[$arItem['PROPERTIES']['TYPE']['VALUE']];
}


/**
 * add tags to cache
 */
if (defined('BX_COMP_MANAGED_CACHE') && is_object($GLOBALS['CACHE_MANAGER'])) {
    $cp =& $this->__component;
    if (strlen($cp->getCachePath())) {
        $GLOBALS['CACHE_MANAGER']->RegisterTag('hlblock_table_' . ProgramsTypesTable::getTableName());
    }
}