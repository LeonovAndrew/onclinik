<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

foreach ($arResult['ITEMS'] as &$arItem) {
    if (!empty($arItem['PICTURE'])) {
        $pic = new MWI\File($arItem['PICTURE']);
        $arItem['PICTURE'] = array(
            'SRC' => $pic->getSrc(),
            'ALT' => $arItem['NAME'],
        );
    }
}