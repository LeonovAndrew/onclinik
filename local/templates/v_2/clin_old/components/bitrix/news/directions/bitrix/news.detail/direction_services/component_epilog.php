<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->AddChainItem($arResult['NAME'], $arResult['DETAIL_PAGE_URL']);
$APPLICATION->AddChainItem(getMessage('ALL_SERVICES'), $arResult['DETAIL_PAGE_URL'] . 'price/');

$APPLICATION->SetPageProperty('title', $arResult['SEO']['TITLE']);
$APPLICATION->SetPageProperty('description', $arResult['SEO']['DESCRIPTION']);
//$APPLICATION->SetPageProperty('keywords', $arResult['SEO']['KEYWORDS']);