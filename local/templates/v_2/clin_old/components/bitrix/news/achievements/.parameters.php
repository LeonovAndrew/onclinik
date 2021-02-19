<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "PAGER_TEMPLATE_TOP" => array(
        "PARENT" => "DETAIL_PAGER_SETTINGS",
        "NAME" => 'Шаблон верхней постраничной навигации',
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),
    "OTHER_NEWS_COUNT" => array(
        "PARENT" => "DETAIL_SETTINGS",
        "NAME" => 'Количество других достижений',
        "TYPE" => "STRING",
        "DEFAULT" => "9",
    ),
);