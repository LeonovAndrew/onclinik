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

if (count($arResult['rows']) != 1) {
    array_unshift(
        $arResult['rows'],
        array(
            'XML_ID' => '',
            'UF_NAME' => 'Все программы',
        )
    );
} else {
    current($arResult['rows'])['SELECTED'] = true;
}

foreach ($arResult['rows'] as &$arItem) {
    $arItem['SELECTED'] = $arItem['UF_XML_ID'] == $arParams['CURRENT_XML_ID'];
}