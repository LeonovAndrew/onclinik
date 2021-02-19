<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
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

<section class="service1">
    <div class="container">
        <div class="service1-container news_directions_newsPhp">
            <div class="service1-wrap1">
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

                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:news.detail',
                    'direction',
                    array(
                        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                        'SET_CANONICAL_URL' => $arParams['DETAIL_SET_CANONICAL_URL'],
                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                        'CACHE_TIME' => $arParams['CACHE_TIME'],
                        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                        'SET_TITLE' => $arParams['SET_TITLE'],
                        'SET_BROWSER_TITLE' => $arParams['SET_BROWSER_TITLE'],
                        'SET_META_KEYWORDS' => $arParams['SET_META_KEYWORDS'],
                        'SET_META_DESCRIPTION' => $arParams['SET_META_DESCRIPTION'],
                        'SET_LAST_MODIFIED' => $arParams['SET_LAST_MODIFIED'],
                        'MESSAGE_404' => $arParams['~MESSAGE_404'],
                        'SET_STATUS_404' => $arParams['SET_STATUS_404'],
                        'SHOW_404' => $arParams['SHOW_404'],
                        'FILE_404' => $arParams['FILE_404'],
                        'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
                        'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
                        'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
                        'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
                        'PROPERTY_CODE' => $arParams['PROPERTY_CODE'],
                        'INCLUDE_IBLOCK_INTO_CHAIN' => $arParams['INCLUDE_IBLOCK_INTO_CHAIN'],
                        'ADD_SECTIONS_CHAIN' => $arParams['ADD_SECTIONS_CHAIN'],
                        'ADD_ELEMENT_CHAIN' => $arParams['ADD_ELEMENT_CHAIN'],
                        "LANG" => CUR_LANG,
                    ),
                    $component
                );
                ?>
            </div>
            <div class="service1-wrap2">
                <?php $APPLICATION->showViewContent('stocks_desktop');?>
				<?php $APPLICATION->showViewContent('doctors_list');?>
                <div class="service1-info">
                    <h3><?php $APPLICATION->ShowTitle('patient_info_menu_title');?></h3>
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "right",
                        array(
                            "COMPONENT_TEMPLATE" => "right",
                            "ROOT_MENU_TYPE" => "patient_info",
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
                </div>
                
                <div class="service1-nav">
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "right-anchor",
                        array(
                            "COMPONENT_TEMPLATE" => "",
                            "ROOT_MENU_TYPE" => "anchor",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => "",
                            "MAX_LEVEL" => "2",
                            "CHILD_MENU_TYPE" => "",
                            "USE_EXT" => "N",
                            "DELAY" => "Y",
                            "ALLOW_MULTI_SELECT" => "N",
                        )
                    )
                    ?>
                </div>
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
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
            <div class="service1-wrap3"></div>
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