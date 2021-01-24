<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Direction,
    MWI\Stock,
    MWI\ServiceOffer,
    MWI\Service,
    MWI\ServiceList,
    MWI\Program,
    MWI\ProgramList,
    MWI\ProgramsTypesTable;

/**
 * @var $arParams
 * @var $arResult
 */

$program = new Program($arResult['ID']);
$programList = new ProgramList();
$programList->add($program);

/**
 * get stocks
 */
$stockList = $programList->getStocks();
$arResult['STOCKS'] = $stockList->getList();

$obPrograms = CIBlockElement::getList(
    array(
        'SORT' => 'ASC',
    ),
    array(
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        '!ID' => $arResult['ID'],
        'PROPERTY_TYPE' => $arResult['PROPERTIES']['TYPE']['VALUE'],
    ),
    false,
    array(),
    array(
        'ID',
        'NAME',
        'PREVIEW_TEXT',
        'DETAIL_PAGE_URL',
        'PROPERTY_TYPE',
    )
);
$arPrograms = array();
while ($arProgram = $obPrograms->getNext()) {
    $arPrograms[] = $arProgram;
}

$arTypes = array();
foreach ($arPrograms as $arProgram) {
    $arTypes[$arProgram['PROPERTY_TYPE_VALUE']] = $arProgram['PROPERTY_TYPE_VALUE'];
}

$obProgramsTypes = ProgramsTypesTable::getList(
    array(
        "select" => array(
            'ID',
            'UF_NAME',
            'UF_XML_ID',
        ),
        "order" => array(
            'UF_SORT' => 'ASC',
        ),
        "filter" => array(
            'UF_XML_ID' => $arTypes,
        ),
    )
);
$arProgramsTypes = array();
while ($arProgramType = $obProgramsTypes->fetch()) {
    $arProgramsTypes[$arProgramType['UF_XML_ID']] = $arProgramType['UF_NAME'];
}

$arResult['OTHER_PROGRAMS'] = array();
foreach ($arPrograms as $arProgram) {
    $arResult['OTHER_PROGRAMS'][] = array(
        'NAME' => $arProgram['NAME'],
        'PREVIEW_TEXT' => $arProgram['~PREVIEW_TEXT'],
        'TYPE' => $arProgramsTypes[$arProgram['PROPERTY_TYPE_VALUE']],
        'URL' => $arProgram['DETAIL_PAGE_URL'],
    );
}

/**
 * discount
 */
$program->price = $arResult['PROPERTIES']['PRICE']['VALUE'];
$program->makeDiscountPrice();
$arResult['price'] = array(
    'base' => $program->price,
    'discount' => $program->discountPrice,
);