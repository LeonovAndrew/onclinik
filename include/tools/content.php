<?php
/**
 * @var $arParams
 */

$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    'content-page',
    array(
        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "ELEMENT_ID" => $arParams['ELEMENT_ID'],
        "FIELD_CODE" => array(
            "NAME",
            "PREVIEW_TEXT",
            "PREVIEW_PICTURE",
            "DETAIL_TEXT",
            "DETAIL_PICTURE",
        ),
        "PROPERTY_CODE" => array(
            "DOCUMENTS",
            "PICTURES",
            "VIDEO",
            "VIDEO_PREVIEW",
        ),
        "SET_TITLE" => "Y",
        "SET_BROWSER_TITLE" => "Y",
        "SET_CANONICAL_URL" => "N",
        "SET_META_KEYWORDS" => "Y",
        "SET_META_DESCRIPTION" => "Y",
        "SET_STATUS_404" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "ADD_ELEMENT_CHAIN" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_GROUPS" => "Y",
    )
);
