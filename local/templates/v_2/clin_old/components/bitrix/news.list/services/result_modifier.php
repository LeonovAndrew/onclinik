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

$k = 0;
foreach ($arResult['ITEMS'] as $arItem) {
    $arResult['TABLE'][$k]['ITEMS'][] = $arItem;
    if ($k != 2) {
        $k++;
    } else {
        $k = 0;
    }
}