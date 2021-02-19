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
    if (!empty($arItem['PROPERTIES']['image']['VALUE'])) {
        $arItem['image'] = array(
            'src' => CFile::GetPath($arItem['PROPERTIES']['image']['VALUE']),
        );
    }
}