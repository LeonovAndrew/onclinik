<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var $arParams
 * @var $arResult
 */

$arSections = array();
foreach ($arResult as $key => $arItem) {
    $secIndex = $key / 5;
    $arSections[$secIndex]['items'][] = $arItem;
}

$arResult['sections'] = $arSections;