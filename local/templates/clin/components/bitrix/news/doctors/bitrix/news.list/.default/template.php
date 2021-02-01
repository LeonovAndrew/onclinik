<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>

<div class="doctors-list" id="ajax-items-list">
    <?php
    mb_internal_encoding("UTF-8");
    foreach ($arResult['ITEMS'] as $arItem) {
        preg_match_all("/src=([^\\s]+)/", $arItem["PROPERTIES"]["FORM"]["~VALUE"]["TEXT"], $frameSrc);
        //$strSRC = str_replace('"', '', $frameSrc[1][0]);
        //$bodytag = substr($frameSrc[1][0],0,-1);
        $bodytag = str_replace('"', "", $frameSrc[1][0]);
        //$strSRC=preg_replace("/\/\/.*?\n/", "\n", $frameSrc[1][0]);

        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <div class="doctors-item ajax-item " id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="doctors-item-img-wrap ">
                <div class="doctors-item-img">
<?if(empty($arItem['PREVIEW_PICTURE']['SRC'])){?>
                    <img src="/no-photo.jpg" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
<?}else{?>
                    <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
<?}?>
                </div>
                <div class="doctors-item-text1">
                    <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="btn4"><?php echo getMessage('NL_ADM_DETAIL_BTN');?></a>
                </div>
            </div>
            <div class="doctors-item-text2 wrap_with_btn">
                <h3><?php echo $arItem['NAME'];?></h3>
                <span><?php echo $arItem['PROPERTIES']['POSITION']['VALUE']['TEXT'];?></span>
                <?php
                foreach ($arItem['CLINICS'] as $arClinic) {
                    ?>
                    <b><?php echo $arClinic['NAME'];?></b>
                    <?php
                }
                ?>
                <a class="btn_doctor_zap" data-fancybox data-type="iframe" data-src="<?=$bodytag?>" href="javascript:;">
                    Записаться
                </a>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<?php
if ($arParams["DISPLAY_BOTTOM_PAGER"]) {
    echo $arResult['NAV_STRING'];
}
?>
<style>
    .fancybox-slide--iframe .fancybox-content {
        width  : 800px;
        max-width  : 80%;
        max-height : 80%;
        margin: 0;
    }
    .btn_doctor_zap{
        display: block;
        width: 100%;
    }
    .btn_doctor_zap {
        display: block;
        width: 100%;
        padding: 14px;
        background: #0a9beb;
        color: #fff;
        position: absolute;
        bottom: 0;
    }
    .wrap_with_btn {
        position: relative;
        padding-bottom: 60px;
        left: 0;
        right: 0;
    }
</style>
