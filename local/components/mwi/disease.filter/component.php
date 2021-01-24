<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    CIBlockElement,
    CPHPCache,
    MWI\Disease,
    MWI\DiseaseList;

/**
 * @var CBitrixComponent $this
 * @var array $arParams
 * @var array $arResult
 * @var string $componentPath
 * @var string $componentName
 * @var string $componentTemplate
 * @global CDatabase $DB
 * @global CUser $USER
 * @global CMain $APPLICATION
 */
global $DB;
global $USER;
global $APPLICATION;

Loader::includeModule('iblock');
Loader::includeModule('search');

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList();
$searchQuery = htmlspecialchars($getParams->getRaw('search'));

$arHintsDiseases = array();
$obDiseaseList = Disease::getList();
foreach ($obDiseaseList->getList() as $obDisease) {
    $arHintsDiseases[] = $obDisease->name;
}

if (!empty($searchQuery)) {
    $obSearch = new CSearch();
    $obSearch->Search(
        array(
            'QUERY' => $searchQuery,
            'SITE_ID' => SITE_ID,
            'MODULE_ID' => 'iblock',
            'PARAM1' => Disease::getIBlockType(),
            'PARAM2' => Disease::getIBlockId(),
        )
    );
    $obSearch->NavStart();

    $foundDiseaseList = new DiseaseList();
    while ($arSearch = $obSearch->Fetch()) {
        $obDisease = new Disease($arSearch['ITEM_ID']);

        $foundDiseaseList->add($obDisease);
    }

    if (!empty($arParams['FILTER_NAME'])) {
        $GLOBALS[$arParams['FILTER_NAME']] = array(
            'ID' => $foundDiseaseList->isEmpty() ? false : $foundDiseaseList->getIds(),
        );
    }
}

$arResult = array(
    'hints_diseases' => $arHintsDiseases,
    'ajax_path' => $APPLICATION->GetCurPage(),
    'ajax_mode' => $getParams->getRaw('ajax_filter') == 'Y',
    'search_query' => $searchQuery,
);

$this->IncludeComponentTemplate();
