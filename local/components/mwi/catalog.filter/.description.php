<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => getMessage("IBLOCK_FILTER_TEMPLATE_NAME"),
	"DESCRIPTION" => getMessage("IBLOCK_FILTER_TEMPLATE_DESCRIPTION"),
	"ICON" => "/images/iblock_filter.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 1000,
	"PATH" => array(
		"ID" => "mwi",
		"CHILD" => array(
			"ID" => "catalog",
			"NAME" => getMessage("T_IBLOCK_DESC_CATALOG"),
			"SORT" => 10,
		),
	),
);
?>