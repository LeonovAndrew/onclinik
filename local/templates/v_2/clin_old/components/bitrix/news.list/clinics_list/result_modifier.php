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

array_unshift(
    $arResult['ITEMS'],
    array(
        'ID' => '',
        'NAME' => getMessage('all_clinics'),
    )
);

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['SELECTED'] = $arItem['ID'] == $arParams['CURRENT_ID'];
}