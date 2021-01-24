<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

/** @global CIntranetToolbar $INTRANET_TOOLBAR */
global $INTRANET_TOOLBAR;

use Bitrix\Main\Context,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Iblock;

if (!isset($arParams["CACHE_TIME"])) {
    $arParams["CACHE_TIME"] = 36000000;
}

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
$arParams["SORT_BY1"] = trim($arParams["SORT_BY1"]);
if (strlen($arParams["SORT_BY1"]) <= 0) {
    $arParams["SORT_BY1"] = "ACTIVE_FROM";
}
if (!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER1"])) {
    $arParams["SORT_ORDER1"] = "DESC";
}

if (strlen($arParams["SORT_BY2"]) <= 0) {
	if (strtoupper($arParams["SORT_BY1"]) == 'SORT') {
		$arParams["SORT_BY2"] = "ID";
		$arParams["SORT_ORDER2"] = "DESC";
	} else {
		$arParams["SORT_BY2"] = "SORT";
	}
}
if (!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER2"])) {
    $arParams["SORT_ORDER2"] = "ASC";
}

if ($this->startResultCache(
        false,
        array(
            $arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups(),
        )
    )
) {
    if (!Loader::includeModule("iblock")) {
        $this->abortResultCache();
        ShowError(getMessage("IBLOCK_MODULE_NOT_INSTALLED"));

        return;
    }

    $arResult = array(
        'ITEMS' => array(),
    );

    $obIblocks = CIBlock::getList(
        array(
            $arParams["SORT_BY1"] => $arParams["SORT_ORDER1"],
            $arParams["SORT_BY2"] => $arParams["SORT_ORDER2"],
        ),
        array(
            'TYPE' => $arParams['IBLOCK_TYPE'],
            'SITE_ID' => SITE_ID,
            'ACTIVE' => 'Y',
        ),
        false
    );

    while ($arIblock = $obIblocks->getNext()) {
        $arIblock['LIST_PAGE_URL'] = str_replace('#SITE_DIR#/', SITE_DIR, $arIblock['LIST_PAGE_URL']);
        $arIblock['~LIST_PAGE_URL'] = str_replace('#SITE_DIR#/', SITE_DIR, $arIblock['~LIST_PAGE_URL']);

        $arResult['ITEMS'][] = $arIblock;
    }
    if (empty($arResult['ITEMS'])) {
        $this->abortResultCache();

        return;
    }

    $this->setResultCacheKeys(
        array(
            "ITEMS",
        )
    );

    $this->includeComponentTemplate();
}
