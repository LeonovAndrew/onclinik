<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use MWI\Symptom;

$APPLICATION->SetTitle("Проблемы и решения");
?>

<?php
$APPLICATION->IncludeComponent(
    "bitrix:news",
    "symptoms",
    array(
        "IBLOCK_TYPE" => Symptom::getIBlockType(),
        "IBLOCK_ID" => Symptom::getIBlockId(),
        "COMPONENT_TEMPLATE" => "symptoms",
        "CACHE_TYPE" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "STRICT_SECTION_CHECK" => "Y",
        "SET_LAST_MODIFIED" => "N",
        "SET_TITLE" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "ADD_ELEMENT_CHAIN" => "Y",
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "/",
        "LIST_FIELD_CODE" => array(

        ),
        "LIST_PROPERTY_CODE" => array(

        ),
        "FIELD_CODE" => "",
        "PROPERTY_CODE" => array(
            'DISEASES',
            'SERVICES',
        ),
        "NEWS_COUNT" => "1",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TEMPLATE" => "show_more",
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "USE_FILTER" => "Y",
        "USE_SEARCH" => "N",
        "USE_RSS" => "N",
        "USE_RATING" => "N",
        "USE_CATEGORIES" => "N",
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
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "DISPLAY_NAME" => "Y",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "DETAIL_SET_CANONICAL_URL" => "N",
        "DETAIL_FIELD_CODE" => array(

        ),
        "DETAIL_PROPERTY_CODE" => array(

        ),
        "OTHER_NEWS_COUNT" => "",
        "DETAIL_DISPLAY_TOP_PAGER" => "N",
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
        "DETAIL_PAGER_TITLE" => "Страница",
        "DETAIL_PAGER_TEMPLATE" => "",
        "DETAIL_PAGER_SHOW_ALL" => "Y",
        "PAGER_TEMPLATE_TOP" => "",
        "DISPLAY_TOP_PAGER" => "N",
        "PAGER_TITLE" => "Новости",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "MESSAGE_404" => "",
        "SEF_URL_TEMPLATES" => array(
            "news" => "symptoms/",
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