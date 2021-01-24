<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    MWI\Clinic;

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

<section class="clinics">
    <div class="container">
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

        <div id="clinics-wrap">
            <?php
            if ($isAjaxFilter) {
                $APPLICATION->RestartBuffer();
            }

            $APPLICATION->IncludeComponent(
                'mwi:clinics.filter',
                '',
                array(
                    'FILTER_NAME' => 'arClinicsFilter',
                )
            );

            if ($isAjax) {
                $APPLICATION->RestartBuffer();
            }

            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "clinics",
                array(
                    "IBLOCK_TYPE" => Clinic::getIBlockType(),
                    "IBLOCK_ID" => Clinic::getIBlockId(),
                    "NEWS_COUNT" => 100,
                    "SORT_BY1" => 'SORT',
                    "SORT_ORDER1" => 'ASC',
                    "FIELD_CODE" => array(
                        'ID',
                        'NAME',
                        'PREVIEW_PICTURE',
                    ),
                    "PROPERTY_CODE" => array(
                        'ADDRESS',
                        'METRO',
                        'PHONE',
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
                    "FILTER_NAME" => 'arClinicsFilter',
                ),
                $component
            );

            if ($isAjax || $isAjaxFilter) {
				echo '<script src="'.SITE_TEMPLATE_PATH.'/assets/js/script.js"></script>';
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