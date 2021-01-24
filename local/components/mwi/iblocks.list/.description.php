<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = array(
	"NAME" => getMessage("MWI_IBLOCK_LIST_NAME"),
	"DESCRIPTION" => getMessage("MWI_IBLOCK_LIST_DESC"),
	"ICON" => "",
	"SORT" => 10,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "MWI_content",
	),
);
