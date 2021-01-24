<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Stock,
    MWI\Clinic,
    MWI\Program;

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

<section class="action">
    <div class="container">
        <div class="action-container">
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

            $stockId = $APPLICATION->IncludeComponent(
                'bitrix:news.detail',
                'stock',
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
                    'OTHER_NEWS_COUNT' => $arParams['OTHER_NEWS_COUNT'],
                    'ACTIVE_DATE_FORMAT' => $arParams['DETAIL_ACTIVE_DATE_FORMAT'],
                ),
                $component
            );

            $obStock = new Stock($stockId);

            $obClinics = $obStock->getClinics();
            if (!$obClinics->isEmpty()) {
                $GLOBALS['arClinicsFilter'] = array(
                    'ID' => $obClinics->getIds(),
                );
                $APPLICATION->IncludeComponent(
                    'bitrix:news.list',
                    'clinics',
                    array(
                        'IBLOCK_TYPE' => Clinic::getIBlockType(),
                        'IBLOCK_ID' => Clinic::getIBlockId(),
                        "NEWS_COUNT" => 100,
                        "SORT_BY1" => 'SORT',
                        "SORT_ORDER1" => 'ASC',
                        "FIELD_CODE" => array(
                            'ID',
                            'NAME',
                            'DETAIL_PAGE_URL',
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
                        "PAGER_TEMPLATE" => '',
                        "PAGER_BOTTOM_TEMPLATE" => '',
                    ),
                    $component
                );
            }

            $obPrograms = $obStock->getPrograms();
            if (!$obPrograms->isEmpty()) {
                $GLOBALS['arProgramsFilter'] = array(
                    'ID' => $obPrograms->getIds(),
                );

                $isAjax = !empty($arParams['IS_AJAX']) ? $arParams['IS_AJAX'] : false;

                if ($isAjax) {
                    $APPLICATION->RestartBuffer();
                }

                $APPLICATION->IncludeComponent(
                    'bitrix:news.list',
                    'programs',
                    array(
                        'IBLOCK_TYPE' => Program::getIBlockType(),
                        'IBLOCK_ID' => Program::getIBlockId(),
                        "NEWS_COUNT" => 100,
                        "SORT_BY1" => 'SORT',
                        "SORT_ORDER1" => 'ASC',
                        "FIELD_CODE" => array(
                            'ID',
                            'NAME',
                            'DETAIL_PAGE_URL',
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
                        "FILTER_NAME" => 'arProgramsFilter',
                        "PAGER_TEMPLATE" => 'show_more',
                    ),
                    $component
                );

                if ($isAjax) {
                    die();
                }
            }
            ?>
            <?php
            //TODO: form
            ?>
            <div class="service1-feedback">
                <div class="service1-feedback-wrap">
                    <h2>Запишитесь на консультацию к специалистам Он&nbsp;Клиник!</h2>
                    <p>Запись ведется по телефону <a href="tel:+74952668571">+7 495 266-85-71</a>. <br> Или заполните форму онлайн записи</p>
                    <?php
									$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										array(
											"AREA_FILE_RECURSIVE" => "Y",
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"PATH" => "/include/order_direction.php"
										),
										false,
										array(
											'HIDE_ICONS' => 'Y'
										)
									);
									?>
                </div>
            </div>
            <?php
            $GLOBALS['arStocksFilter'] = array(
                '!ID' => $stockId,
            );
            $APPLICATION->IncludeComponent(
                'bitrix:news.list',
                'other_stocks',
                array(
                    'IBLOCK_TYPE' => Stock::getIBlockType(),
                    'IBLOCK_ID' => Stock::getIBlockId(),
                    "NEWS_COUNT" => 9,
                    "SORT_BY1" => 'RAND',
                    "SORT_ORDER1" => 'ASC',
                    "FIELD_CODE" => array(
                        'ID',
                        'NAME',
                        'DETAIL_PAGE_URL',
                        'PREVIEW_PICTURE',
                        'DATE_ACTIVE_TO',
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
                    "FILTER_NAME" => 'arStocksFilter',
                ),
                $component
            );
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