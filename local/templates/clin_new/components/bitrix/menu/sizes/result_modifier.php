<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var $arParams
 * @var $arResult
 */

foreach ($arResult as &$arItem) {
    $arItem['SELECTED'] = $arItem['PARAMS']['value'] == $arParams['CUR_SIZE'];
}
