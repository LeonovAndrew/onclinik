<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Вакансии");
?>

<?php
$APPLICATION->IncludeComponent(
    "bitrix:news",
    "jobs",
    array(
        "IBLOCK_TYPE" => "jobs",
        "IBLOCK_ID" => "24",
        "COMPONENT_TEMPLATE" => "jobs",
        "CACHE_TYPE" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "STRICT_SECTION_CHECK" => "Y",
        "SET_LAST_MODIFIED" => "N",
        "SET_TITLE" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "ADD_ELEMENT_CHAIN" => "Y",
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "/about/jobs/",
        "SEF_URL_TEMPLATES" => array(
            "news" => "",
            "detail" => "#ELEMENT_CODE#/",
        ),
        "LIST_FIELD_CODE" => array(
            "ID",
            "NAME",
        ),
        "LIST_PROPERTY_CODE" => array(

        ),
        "FIELD_CODE" => array(
            "ID",
            "NAME",
        ),
        "PROPERTY_CODE" => array(
            "DUTIES",
            "REQUIREMENTS",
            "CONDITIONS",
            "FULL_NAME",
            "PHONE",
            "PHONE_ADDITIONAL",
            "EMAIL",
        ),
        "NEWS_COUNT" => 100,
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