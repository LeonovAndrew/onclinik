<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Loader,
    MWI\Service;
?>

<section class="service1 service1-service">
    <div class="container">
        <div class="service1-container">
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
                    "bitrix:news.detail",
                    "service",
                    array(
                        'IBLOCK_TYPE' => Service::getIBlockType(),
                        'IBLOCK_ID' => Service::getIBlockId(),
                        'SET_CANONICAL_URL' => 'Y',
                        "CACHE_TYPE" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        'SET_TITLE' => "Y",
                        'SET_BROWSER_TITLE' => "Y",
                        'SET_META_KEYWORDS' => "Y",
                        'SET_META_DESCRIPTION' => "Y",
                        'SET_LAST_MODIFIED' => "Y",
                        'SET_STATUS_404' => "Y",
                        'SHOW_404' => "Y",
                        'ELEMENT_CODE' => $_REQUEST['CODE'],
                        'INCLUDE_IBLOCK_INTO_CHAIN' => "N",
                        'ADD_SECTIONS_CHAIN' => "N",
                        'ADD_ELEMENT_CHAIN' => "Y",
                        "FIELD_CODE" => array(
                            'ID',
                            'NAME',
                            'DETAIL_TEXT',
                            'DETAIL_PICTURE',
                        ),
                        "PROPERTY_CODE" => array(
                            'RESULTS',
                        ),
                    ),
                    false
                );
                ?>
                <?php
                //TODO: form
                ?>
                <div class="service1-feedback">
                    <div class="service1-feedback-wrap">
                        <h2>Запишитесь на консультацию к специалистам Он Клиник!</h2>
                        <p>Запись ведется по телефону <a href="tel:+74952668571">+7 495 266-85-71</a>. <br> Или заполните форму онлайн записи</p>
                        <a href="#" class="js-appointment-btn btn1">Записаться на приём</a>
                    </div>
                </div>
            </div>
            <div class="service1-wrap2">
                <?php $APPLICATION->showViewContent('stocks_desktop');?>
                <div class="service1-info">
                    <h3><?php $APPLICATION->ShowTitle('patient_info_menu_title');?></h3>
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "right",
                        array(
                            "COMPONENT_TEMPLATE" => "left",
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
                <?php $APPLICATION->showViewContent('doctors_list');?>
                <div class="service1-nav">
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "right-anchor",
                        array(
                            "COMPONENT_TEMPLATE" => "right-anchor",
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
            </div>
            <div class="service1-wrap3">
                <?php $APPLICATION->showViewContent('other_services');?>

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

<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>