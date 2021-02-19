<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    MWI\Symptom;

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

<section class="directory">
    <div class="container">
        <div class="directory-container">
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
            $request = Application::getInstance()->getContext()->getRequest();
            $getParams = $request->getQueryList();
            $isAjax = $getParams->getRaw('ajax') == 'Y';
            $isAjaxFilter = $getParams->getRaw('ajax_filter') == 'Y';
            ?>

            <div id="directory-wrap">
                <?php
                if ($isAjaxFilter) {
                    $APPLICATION->RestartBuffer();
                }

                $APPLICATION->IncludeComponent(
                    'mwi:symptoms.filter',
                    '',
                    array(
                        'FILTER_NAME' => 'arSymptomFilter',
                    )
                );

                if ($isAjax) {
                    $APPLICATION->RestartBuffer();
                }

                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "directory",
                    array(
                        "IBLOCK_TYPE" => Symptom::getIBlockType(),
                        "IBLOCK_ID" => Symptom::getIBlockId(),
                        "NEWS_COUNT" => 200,
                        "SORT_BY1" => 'SORT',
                        "SORT_ORDER1" => 'ASC',
                        "FIELD_CODE" => array(
                            'ID',
                            'NAME',
                        ),
                        "PROPERTY_CODE" => array(
                            'DIRECTIONS',
                            'LETTER',
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
                        "FILTER_NAME" => 'arSymptomFilter',
                    ),
                    $component
                );

                if ($isAjax || $isAjaxFilter) {
                    die();
                }
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