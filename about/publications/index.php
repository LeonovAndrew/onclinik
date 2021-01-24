<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Публикации");
?>

<?php
$APPLICATION->IncludeComponent(
    "bitrix:news",
    "publications",
    array(
        "IBLOCK_TYPE" => "content",
        "IBLOCK_ID" => "6",
        "COMPONENT_TEMPLATE" => "publications",
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
        "SEF_FOLDER" => "/about/publications/",
        "SEF_URL_TEMPLATES" => array(
            "news" => "",
            "detail" => "#ELEMENT_CODE#/",
        ),
        "LIST_FIELD_CODE" => array(
            "ID",
            "NAME",
            "PREVIEW_TEXT",
            "PREVIEW_PICTURE",
            "DATE_ACTIVE_FROM",
        ),
        "LIST_PROPERTY_CODE" => array(

        ),
        "FIELD_CODE" => array(
            "ID",
            "NAME",
            "DETAIL_TEXT",
        ),
        "PROPERTY_CODE" => array(
            "PICTURES",
            "DOCUMENTS",
            "VIDEO",
            "VIDEO_PREVIEW",
        ),
        "NEWS_COUNT" => 6,
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TEMPLATE" => 'bottom',
        "DISPLAY_TOP_PAGER" => "Y",
        "PAGER_TEMPLATE_TOP" => 'arrows',
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "SET_STATUS_404" => "Y",
        "SHOW_404" => "Y",
    ),
    false
);
?>

<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>