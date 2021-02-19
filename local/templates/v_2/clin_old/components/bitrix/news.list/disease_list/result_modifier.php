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

$cnt = 0;
$arList = array();
foreach ($arResult['ITEMS'] as $key => $arItem) {
    $index = ++$cnt / $arParams['LIST_CNT'];
    $arList[$index][] = $arItem;
}

$arResult['LIST'] = $arList;