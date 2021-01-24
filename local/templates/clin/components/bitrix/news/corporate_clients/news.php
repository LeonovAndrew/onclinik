<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 */

$this->setFrameMode(true);
?>

<section class="corporate">
    <div class="container">
        <div class="corporate-container">
            <div class="section-wrap1">
                <nav class="section-nav">
                    <h2><?php $APPLICATION->ShowTitle('menu_title');?></h2>
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "left",
                        array(
                            "COMPONENT_TEMPLATE" => "left",
                            "ROOT_MENU_TYPE" => "left",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => "",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "",
                            "USE_EXT" => "N",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                        )
                    )
                    ?>
                </nav>
                <div class="menu-btn"></div>
            </div>
            <div class="corporate-wrap2">
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_RECURSIVE" => "Y",
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "",
                        "PATH" => "/include/tools/breadcrumbs.php"
                    ),
                    false,
                    array(
                        'HIDE_ICONS' => 'Y'
                    )
                );
                ?>

                <h1><?php $APPLICATION->ShowTitle(false);?></h1>
                <?php
                $APPLICATION->IncludeComponent (
                    "mwi:catalog.filter",
                    "",
                    Array(
                        "IBLOCK_TYPE" => "partners",
                        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                        "FILTER_NAME" => $arParams['FILTER_NAME'],
                        "FIELD_CODE" => array(
                            "SECTION_ID"
                        ),
                        "PROPERTY_CODE" => array(

                        ),
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_GROUPS" => "Y",
                        "SAVE_IN_SESSION" => "N",
                    ),
                    $component
                );
                ?>

                <?php
                $APPLICATION->IncludeFile(
                    $APPLICATION->GetCurDir() . "include/content.php",
                    array(),
                    array(
                        "MODE" => "html",
                        "NAME" => "Контент",
                    )
                );
                ?>

                <?php
                $isAjax = $_REQUEST['ajax'] == 'Y';

                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "corporate_clients",
                    array(
                        "IBLOCK_TYPE" => "partners",
                        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                        "NEWS_COUNT" => $arParams['NEWS_COUNT'],
                        "SORT_BY1" => $arParams['SORT_BY1'],
                        "SORT_ORDER1" => $arParams['SORT_ORDER1'],
                        "SORT_BY2" => $arParams['SORT_BY2'],
                        "SORT_ORDER2" => $arParams['SORT_ORDER2'],
                        "FIELD_CODE" => $arParams['LIST_FIELD_CODE'],
                        "PROPERTY_CODE" => $arParams['LIST_PROPERTY_CODE'],
                        "SET_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_STATUS_404" => $arParams['SET_STATUS_404'],
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                        "CACHE_TIME" => $arParams['CACHE_TIME'],
                        "CACHE_FILTER" => $arParams['CACHE_FILTER'],
                        "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                        "DISPLAY_BOTTOM_PAGER" => $arParams['DISPLAY_BOTTOM_PAGER'],
                        "PAGER_TEMPLATE" => $arParams['PAGER_TEMPLATE'],
                        "FILTER_NAME" => $arParams['FILTER_NAME'],
                        "IS_AJAX" => $isAjax,
                    )
                );
                ?>

                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_RECURSIVE" => "Y",
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "",
                        "PATH" => "/include/tools/breadcrumbs_mobile.php"
                    ),
                    false,
                    array(
                        'HIDE_ICONS' => 'Y'
                    )
                );
                ?>
            </div>
        </div>
    </div>
</section>

<?php
$APPLICATION->IncludeFile(
    SITE_DIR . "/include/map.php",
    array(),
    array(
        "MODE" => "html",
        "NAME" => "Карта клиник",
    )
);
?>