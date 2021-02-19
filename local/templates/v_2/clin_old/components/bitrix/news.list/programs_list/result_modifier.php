<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\ProgramsTypesTable,
    MWI\ServicesTypesTable,
    MWI\Program;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

foreach ($arResult['ITEMS'] as $key => $arItem) {
    $program = new Program($arItem['ID']);
    $program->price = $arItem['PROPERTIES']['PRICE']['VALUE'];
    $program->makeDiscountPrice();
    $arResult['ITEMS'][$key]['price'] = array(
        'base' => $program->price,
        'discount' => $program->discountPrice,
    );
}

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
$arTags = array(
    'hlblock_table_' . ServicesTypesTable::getTableName(),
);
addTagsToComponentCache($this->__component, $arTags);