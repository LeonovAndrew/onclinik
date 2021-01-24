<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arCurrentValues */

if (!CModule::IncludeModule("iblock")) {
    return;
}

$arTypesEx = CIBlockParameters::GetIBlockTypes(
    array(
        "-" => " "
    )
);

$arSorts = array(
    "ASC"=>getMessage("MWI_IBLOCK_DESC_ASC"),
    "DESC"=>getMessage("MWI_IBLOCK_DESC_DESC")
);

$arSortFields = array(
    "ID" => getMessage("MWI_IBLOCK_DESC_SID"),
    "NAME" => getMessage("MWI_IBLOCK_DESC_SNAME"),
    "ACTIVE_FROM" => getMessage("MWI_IBLOCK_DESC_SACT"),
    "SORT" => getMessage("MWI_IBLOCK_DESC_SSORT"),
    "TIMESTAMP_X" => getMessage("MWI_IBLOCK_DESC_STSTAMP")
);

$arComponentParameters = array(
	"GROUPS" => array(),
	"PARAMETERS" => array(
		"AJAX_MODE" => array(),
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => getMessage("MWI_IBLOCK_DESC_LIST_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"SORT_BY1" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => getMessage("MWI_IBLOCK_DESC_SBY1"),
			"TYPE" => "LIST",
			"DEFAULT" => "ACTIVE_FROM",
			"VALUES" => $arSortFields,
			"ADDITIONAL_VALUES" => "Y",
		),
		"SORT_ORDER1" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => getMessage("MWI_IBLOCK_DESC_SORDER1"),
			"TYPE" => "LIST",
			"DEFAULT" => "DESC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),
		"SORT_BY2" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => getMessage("MWI_IBLOCK_DESC_SBY2"),
			"TYPE" => "LIST",
			"DEFAULT" => "SORT",
			"VALUES" => $arSortFields,
			"ADDITIONAL_VALUES" => "Y",
		),
		"SORT_ORDER2" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => getMessage("MWI_IBLOCK_DESC_SORDER2"),
			"TYPE" => "LIST",
			"DEFAULT" => "ASC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),
		"CACHE_TIME" => array(
		    "DEFAULT" => 36000000
        ),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => getMessage("MWI_IBLOCK_DESC_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
	),
);
