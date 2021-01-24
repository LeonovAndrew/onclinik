<?php
if ((isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y') ||
    (isset ($_REQUEST['ajax_filter']) && $_REQUEST['ajax_filter'] == 'Y')) {
    require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->SetPageProperty("description", "ММЦ ОН КЛИНИК: годовые программы медицинского обслуживания для физических лиц в Москве. Консультации с врачом.");
$APPLICATION->SetPageProperty("title", "Годовые программы медицинского обслуживания для физических лиц в Москве: доступные цены.");
$APPLICATION->SetTitle("Программы годового медицинского обслуживания для физических лиц");
} else {
    define('BODY_CLASS', 'programs-body');
    require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
}

use MWI\Program;
?>

<?php
$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"programs", 
	array(
		"IBLOCK_TYPE" => Program::getIBlockType(),
		"IBLOCK_ID" => Program::getIBlockId(),
		"COMPONENT_TEMPLATE" => "programs",
		"CACHE_TYPE" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"STRICT_SECTION_CHECK" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_TITLE" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "Y",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/en/",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
		),
		"PROPERTY_CODE" => array(
			0 => "TYPE",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "TYPE",
			2 => "",
		),
		"NEWS_COUNT" => "12",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TEMPLATE" => "show_more",
		"PAGER_SHOW_ALWAYS" => "N",
		"DISPLAY_TOP_PAGER" => "Y",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"USE_SEARCH" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CHECK_DATES" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"USE_PERMISSIONS" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"FILE_404" => "",
		"SEF_URL_TEMPLATES" => array(
			"news" => "programs/",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
		)
	),
	false
);
?>

<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>