<?php

use MWI\Disease,
    MWI\Question,
    MWI\Symptom,
    MWI\UsefulInformation;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Всё о здоровье");
?>

<section class="health">
    <div class="container">
        <div class="health-container">
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
            <h1><?php echo $APPLICATION->showTitle();?></h1>

            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "disease_list",
                array(
                    "IBLOCK_TYPE" => Disease::getIBlockType(),
                    "IBLOCK_ID" => Disease::getIBlockId(),
                    "NEWS_COUNT" => 30,
                    "SORT_BY1" => 'SORT',
                    "SORT_ORDER1" => 'ASC',
                    "FIELD_CODE" => array(
                        'ID',
                        'NAME',
                    ),
                    "PROPERTY_CODE" => array(

                    ),
                    "SET_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_STATUS_404" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600000",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "FILTER_NAME" => '',
                    "LIST_CNT" => 17,
                ),
                false
            );
            ?>

            <div class="health-wrap1">
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "questions_list",
                    array(
                        "IBLOCK_TYPE" => Question::getIBlockType(),
                        "IBLOCK_ID" => Question::getIBlockId(),
                        "NEWS_COUNT" => 2,
                        "SORT_BY1" => 'SORT',
                        "SORT_ORDER1" => 'ASC',
                        "FIELD_CODE" => array(
                            'ID',
                            'NAME',
                            'PREVIEW_TEXT',
                            'DETAIL_TEXT',
                        ),
                        "PROPERTY_CODE" => array(
                            'PATIENT_NAME',
                            'QUESTION',
                            'ANSWER',
                        ),
                        "SET_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_STATUS_404" => "N",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600000",
                        "CACHE_FILTER" => "Y",
                        "CACHE_GROUPS" => "Y",
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "FILTER_NAME" => '',
                    ),
                    false
                );

                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "symptoms_list",
                    array(
                        "IBLOCK_TYPE" => Symptom::getIBlockType(),
                        "IBLOCK_ID" => Symptom::getIBlockId(),
                        "NEWS_COUNT" => 30,
                        "SORT_BY1" => 'SORT',
                        "SORT_ORDER1" => 'ASC',
                        "FIELD_CODE" => array(
                            'ID',
                            'NAME',
                        ),
                        "PROPERTY_CODE" => array(

                        ),
                        "SET_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_STATUS_404" => "N",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600000",
                        "CACHE_FILTER" => "Y",
                        "CACHE_GROUPS" => "Y",
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "FILTER_NAME" => '',
                    ),
                    false
                );
                ?>
            </div>
            <div class="health-informations">
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "useful_info_list",
                    array(
                        "IBLOCK_TYPE" => UsefulInformation::getIBlockType(),
                        "IBLOCK_ID" => UsefulInformation::getIBlockId(),
                        "NEWS_COUNT" => 6,
                        "SORT_BY1" => 'SORT',
                        "SORT_ORDER1" => 'ASC',
                        "FIELD_CODE" => array(
                            'ID',
                            'NAME',
                            'PREVIEW_TEXT',
                            'PREVIEW_PICTURE',
                        ),
                        "PROPERTY_CODE" => array(

                        ),
                        "SET_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_STATUS_404" => "N",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600000",
                        "CACHE_FILTER" => "Y",
                        "CACHE_GROUPS" => "Y",
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "FILTER_NAME" => '',
                    ),
                    false
                );
                ?>
            </div>
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