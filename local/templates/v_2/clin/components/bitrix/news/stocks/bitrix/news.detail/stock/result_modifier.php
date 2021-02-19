<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Stock;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

/**
 * stock counter params
 */
$obStock = new Stock($arResult['ID']);
$obStock->makeData();
$arResult['expire_date'] = $obStock->expireDateCounter;
