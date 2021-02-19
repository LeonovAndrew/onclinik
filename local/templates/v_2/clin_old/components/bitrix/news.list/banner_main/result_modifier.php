<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Program;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

$arProgramsId = array();
foreach ($arResult['ITEMS'] as $arItem) {
    if (!empty($arItem['PROPERTIES']['PROGRAM']['VALUE'])) {
        $arProgramsId[$arItem['PROPERTIES']['PROGRAM']['VALUE']] = $arItem['PROPERTIES']['PROGRAM']['VALUE'];
    }
}

$arPrograms = array();
if (!empty($arProgramsId)) {
    $obPrograms = CIBlockElement::GetList(
        array(),
        array(
            'IBLOCK_ID' => Program::getIBlockId(),
            'ID' => $arProgramsId,
            'ACTIVE' => 'Y',
        ),
        false,
        array(),
        array(
            'DETAIL_PAGE_URL',
            'PROPERTY_PRICE',
        )
    );

    while ($arProgram = $obPrograms->getNext()) {
        $arPrograms[$arProgram['ID']] = $arProgram;
    }
}

foreach ($arResult['ITEMS'] as &$arItem) {
    if (!empty($arItem['PROPERTIES']['PROGRAM']['VALUE'])) {
        $programId = $arItem['PROPERTIES']['PROGRAM']['VALUE'];
        $program = new Program($programId);
        $program->price = $arPrograms[$programId]['PROPERTY_PRICE_VALUE'];
        $program->makeDiscountPrice();
        $arItem['price'] = array(
            'base' => $program->price,
            'discount' => $program->discountPrice,
        );
    }
    $arItem['link'] = ($arItem['PROPERTIES']['LINK']['VALUE'] != '') ? $arItem['PROPERTIES']['LINK']['VALUE'] : $arPrograms[$arItem['PROPERTIES']['PROGRAM']['VALUE']]['DETAIL_PAGE_URL'];
	//$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>715, 'height'=>410), BX_RESIZE_IMAGE_PROPORTIONAL, true);                
    //$arItem['PICTURE'] = $file['src']; 
	$arItem['PICTURE'] = $arItem['PREVIEW_PICTURE']['SRC']; 
	
}
