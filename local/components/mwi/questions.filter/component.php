<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    CIBlockElement,
    CPHPCache,
    MWI\Direction,
    MWI\DirectionList,
    MWI\Question,
    MWI\QuestionList;

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

Loader::includeModule('search');

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList();
$directionId = htmlspecialchars($getParams->getRaw('directionId'));
$searchQuery = htmlspecialchars($getParams->getRaw('search'));
$displayed = htmlspecialchars($getParams->getRaw('displayed'));

$obDirectionsList = Direction::getAll();
$obDirectionsList->makeData();

if ($directionId == 'about') {
    $directionId = false;
} else if (!$obDirectionsList->getById($directionId)) {
    $directionId = '';
}

$obQuestionsList = Question::getAll();
$arQuestionsId = $obQuestionsList->getIds();


if (!empty($searchQuery)) {
    $obSearch = new CSearch();
    $obSearch->Search(
        array(
            'QUERY' => $searchQuery,
            'SITE_ID' => SITE_ID,
            'MODULE_ID' => 'iblock',
            'PARAM1' => Question::getIBlockType(),
            'PARAM2' => Question::getIBlockId(),
            'ITEM_ID' => $obQuestionsList->size() == 1 ? reset($arQuestionsId) : $arQuestionsId,
        )
    );
    if (!$obSearch->selectedRowsCount()) {
        $obSearch->Search(
            array(
                'QUERY' => $searchQuery,
                'SITE_ID' => SITE_ID,
                'MODULE_ID' => 'iblock',
                'PARAM1' => Question::getIBlockType(),
                'PARAM2' => Question::getIBlockId(),
                'ITEM_ID' => $obQuestionsList->size() == 1 ? reset($arQuestionsId) : $arQuestionsId,
            ),
            array(),
            array(
                'STEMMING' => false
            )
        );
    }
    $obSearch->NavStart();

    $foundQuestionsList = new QuestionList();
    while ($arSearch = $obSearch->Fetch()) {
        $obQuestion = new Question($arSearch['ITEM_ID']);

        $foundQuestionsList->add($obQuestion);
    }

    //remove questions which don't match search query
    /*foreach (array_diff($arQuestionsId, $foundQuestionsList->getIds()) as $questionId) {
        $obQuestionsList->remove($questionId);
    }*/
    $obQuestionsList = $foundQuestionsList;
}

$arDirections = array();
$directionSelected = false;

foreach ($obDirectionsList->getList() as $obDirection) {
    if ($directionId == $obDirection->id) {
        $directionSelected = true;
    }
    $arDirections[] = array(
        'ID' => $obDirection->id,
        'NAME' => $obDirection->name,
        'SELECTED' => $directionId == $obDirection->id ? true : false,
    );
}
array_unshift(
    $arDirections,
    array(
        'ID' => 'about',
        'NAME' => getMessage('ABOUT_CENTER'),
        'SELECTED' => $directionId === false,
    )
);
array_unshift(
    $arDirections,
    array(
        'ID' => '',
        'NAME' => getMessage('ALL_DIRECTIONS'),
        'SELECTED' => $directionId !== false && !$directionSelected,
    )
);

$arResult = array(
    'directions' => $arDirections,
    'search_query' => $searchQuery,
    'ajax_path' => $APPLICATION->GetCurPage(),
    'ajax_mode' => $getParams->getRaw('ajax_filter') == 'Y',
);

if (!empty($arParams['FILTER_NAME'])) {
    $GLOBALS[$arParams['FILTER_NAME']] = array(
        'PROPERTY_DIRECTIONS' => $directionId,
        'ID' => $obQuestionsList->isEmpty() ? false : $obQuestionsList->getIds(),
    );
}

$this->IncludeComponentTemplate();

$arDisplayed = !empty($displayed) ? Question::updateDisplayed($displayed) : $arDisplayed = Question::getDisplayed();

return array(
    'displayed' => $arDisplayed,
);