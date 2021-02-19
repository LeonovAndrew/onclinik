<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Clinic,
    MWI\Personal,
    MWI\Review;

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

<section class="clinic">
    <div class="container">
        <div class="clinic-container">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
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

            $clinicId = $APPLICATION->IncludeComponent(
                'bitrix:news.detail',
                '',
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
                ),
                $component
            );

            $obClinic = new Clinic($clinicId);
            $obDoctorsList = $obClinic->getDoctors();

            if (!$obDoctorsList->isEmpty()) {
                $GLOBALS['arDoctorsFilter'] = array(
                    'ID' => $obDoctorsList->getIds(),
                );

                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "doctors",
                    array(
                        "IBLOCK_TYPE" => Personal::getIBlockType(),
                        "IBLOCK_ID" => Personal::getIBlockId(),
                        "NEWS_COUNT" => 10,
                        "SORT_BY1" => 'SORT',
                        "SORT_ORDER1" => 'ASC',
                        "FIELD_CODE" => array(
                            'ID',
                            'NAME',
                            'PREVIEW_TEXT',
                            'PREVIEW_PICTURE',
                        ),
                        "PROPERTY_CODE" => array(
                            'POSITION',
                            'CLINICS',
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
                        "FILTER_NAME" => 'arDoctorsFilter',
                        "CLINIC_ID" => $clinicId,
                    ),
                    $component
                );
            }

            $obReviewsList = $obClinic->getReviews();

            if (!$obReviewsList->isEmpty()) {
                $GLOBALS['arReviewsFilter'] = array(
                    'ID' => $obReviewsList->getIds(),
                );

                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "reviews",
                    array(
                        "IBLOCK_TYPE" => Review::getIBlockType(),
                        "IBLOCK_ID" => Review::getIBlockId(),
                        "NEWS_COUNT" => 10,
                        "SORT_BY1" => 'SORT',
                        "SORT_ORDER1" => 'ASC',
                        "FIELD_CODE" => array(
                            'ID',
                            'PATIENT_NAME',
                            'DETAIL_TEXT',
                        ),
                        "PROPERTY_CODE" => array(
                            'DOCTOR',
                            'CLINIC',
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
                        "FILTER_NAME" => 'arReviewsFilter',
                        "CLINIC_ID" => $clinicId,
                    ),
                    $component
                );
            }
            ?>

            <?php $APPLICATION->showViewContent('detail_text');?>

            <?php $APPLICATION->showViewContent('photo');?>

            <?php $APPLICATION->showViewContent('tour');?>

            <?php
            $obAdministrationList = $obClinic->getAdministration();

            if (!$obAdministrationList->isEmpty()) {
                $GLOBALS['arAdministrationFilter'] = array(
                    'ID' => $obAdministrationList->getIds(),
                );

                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "administration",
                    array(
                        "IBLOCK_TYPE" => Personal::getIBlockType(),
                        "IBLOCK_ID" => Personal::getIBlockId(),
                        "NEWS_COUNT" => 10,
                        "SORT_BY1" => 'SORT',
                        "SORT_ORDER1" => 'ASC',
                        "FIELD_CODE" => array(
                            'ID',
                            'NAME',
                            'PREVIEW_TEXT',
                            'PREVIEW_PICTURE',
                        ),
                        "PROPERTY_CODE" => array(
                            'POSITION',
                            'CLINICS',
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
                        "FILTER_NAME" => 'arAdministrationFilter',
                        "CLINIC_ID" => $clinicId,
                    ),
                    $component
                );
            }
            ?>

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