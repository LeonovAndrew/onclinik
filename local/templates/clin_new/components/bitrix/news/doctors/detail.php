<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Review,
    MWI\Personal;

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

<section class="doctor">
    <div class="container">
        <div class="doctor-container">
            <div class="doctor-med-wrap2">
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
                $doctorId = $APPLICATION->IncludeComponent(
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
                        'INCLUDE_IBLOCK_INTO_CHAIN' => "N",
                        'ADD_SECTIONS_CHAIN' => $arParams['ADD_SECTIONS_CHAIN'],
                        'ADD_ELEMENT_CHAIN' => $arParams['ADD_ELEMENT_CHAIN'],
                        'OTHER_NEWS_COUNT' => $arParams['OTHER_NEWS_COUNT'],
                    ),
                    $component
                );
                ?>

               

                <?php
                $obDoctor = new Personal($doctorId);
                $obReviews = $obDoctor->getReviews(20);
                if (!$obReviews->isEmpty()) {
                    $GLOBALS['reviewsFilter']['ID'] = $obReviews->getIds();

                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "reviews",
                        array(
                            'IBLOCK_TYPE' => Review::getIBlockType(),
                            'IBLOCK_ID' => Review::getIBlockId(),
                            'NEWS_COUNT' => 9,
                            "SORT_BY1" => 'DATE_ACTIVE_FROM',
                            "SORT_ORDER1" => 'DESC',
                            "FIELD_CODE" => array(
                                'ID',
                                'DATE_ACTIVE_FROM',
                                'DETAIL_TEXT',
                            ),
                            "PROPERTY_CODE" => array(
                                'PATIENT_NAME',
                                'CLINIC',
                            ),
                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
                            "SET_TITLE" => "N",
                            "SET_KEYWORDS" => "N",
                            "SET_DESCRIPTION" => "N",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "360000",
                            "FILTER_NAME" => "reviewsFilter",
                            "DOCTOR_ID" => $doctorId,
                        ),
                        $component
                    );
                }

                $APPLICATION->showViewContent('specialization');

                $APPLICATION->showViewContent('offers');

                $APPLICATION->showViewContent('regalia');

                $APPLICATION->showViewContent('certificates');

                $APPLICATION->showViewContent('practical_activity');

                $APPLICATION->showViewContent('video');

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


                <div class="doctor_slider">
                    <?

                    $arSelectDir = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
                    $arFilterDir = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ID"=>$doctorId, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                    $resDir = CIBlockElement::GetList(Array(), $arFilterDir, false, Array("nPageSize"=>50), $arSelectDir);
                    while($obDir = $resDir->GetNextElement()){
                        $arPropsDir = $obDir->GetProperties();
                        $DIRECTION=$arPropsDir["DIRECTION"]["VALUE"];
                    }
                    if(count($DIRECTION)>0){
                        $slidArr=array();
                        $slidItem=array();
                        $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
                        $arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "!ID"=>$doctorId, "PROPERTY_DIRECTION"=>$DIRECTION, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
                        while($ob = $res->GetNextElement()){

                            $arFields = $ob->GetFields();
                            $arProps = $ob->GetProperties();

                            $slidItem["NAME"]=$arFields["NAME"];
                            $slidItem["IMG"]=CFile::GetPath($arFields["PREVIEW_PICTURE"]);
                            $slidItem["URL"]=$arFields["DETAIL_PAGE_URL"];
                            $slidArr[]=$slidItem;
                        }
                    }
                    ?>
                    <?if(count($slidArr)>0):?>
                        <div class="slider_doctors_wrap">
                            <?foreach ($slidArr as $slidItem):?>
                            <div class="doctors_items_wrap">
                                <a class="a_href_wrap" href="<?=$slidItem["URL"]?>">
                                    <div class="href_wrap_item">
                                        <div class="doctors_img_wrap">
                                            <img src="<?=$slidItem["IMG"]?>" alt="<?=$slidItem["NAME"]?>">
                                        </div>
                                        <div class="doctors_name_wrap">
                                            <?=$slidItem["NAME"]?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?endforeach;?>
                        </div>

                    <?endif;?>
                </div>
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