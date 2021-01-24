<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    CIBlockElement,
    CPHPCache,
    MWI\Symptom,
    MWI\SymptomList;

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

$arHintsSymptoms = array();
$obSymptomList = Symptom::getList();
foreach ($obSymptomList->getList() as $obSymptom) {
    $arHintsSymptoms[] = $obSymptom->name;
}

if (!empty($searchQuery)) {
    $obSearch = new CSearch();
    $obSearch->Search(
        array(
            'QUERY' => $searchQuery,
            'SITE_ID' => SITE_ID,
            'MODULE_ID' => 'iblock',
            'PARAM1' => Symptom::getIBlockType(),
            'PARAM2' => Symptom::getIBlockId(),
        )
    );
    $obSearch->NavStart();

    $foundSymptomList = new SymptomList();
    while ($arSearch = $obSearch->Fetch()) {
        $obSymptom = new Symptom($arSearch['ITEM_ID']);

        $foundSymptomList->add($obSymptom);
    }

    if (!empty($arParams['FILTER_NAME'])) {
        $GLOBALS[$arParams['FILTER_NAME']] = array(
            'ID' => $foundSymptomList->isEmpty() ? false : $foundSymptomList->getIds(),
        );
    }
}

$arResult = array(
    'hints_symptoms' => $arHintsSymptoms,
    'ajax_path' => $APPLICATION->GetCurPage(),
    'ajax_mode' => $getParams->getRaw('ajax_filter') == 'Y',
    'search_query' => $searchQuery,
);

$this->IncludeComponentTemplate();
