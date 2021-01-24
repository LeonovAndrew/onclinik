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

foreach ($arResult['ITEMS'] as &$arItem) {
    $obProgram = new Program($arItem['ID']);
    $obProgram->price = $arItem['PROPERTIES']['PRICE']['VALUE'];
    $obProgram->makeDiscountPrice();
    $arItem['DISCOUNT_PRICE'] = $obProgram->discountPrice;
}