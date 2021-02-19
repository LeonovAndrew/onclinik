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

<h1><?php echo getMessage('advantages_title');?></h1>
<div class="services1-list">
    <?php
    foreach ($arResult['ITEMS'] as $arItem) {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="services1-item" id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
            <i style="background:url(<?php echo $arItem['image']['src'];?>) center no-repeat;"></i>
            <h3><?php echo $arItem['NAME'];?></h3>
            <p><?php echo $arItem['~PREVIEW_TEXT'];?></p>
        </div>
        <?php
    }
    ?>
</div>
<div class="services1-slider">
    <div class="swiper-container4">
        <div class="swiper-wrapper">
            <?php
            foreach ($arResult['ITEMS'] as $arItem) {
                ?>
                <div class="swiper-slide">
                    <div class="services1-item services1-item-1">
                        <i style="background: url(<?php echo $arItem['image']['src'];?>) center no-repeat;"></i>
                        <h3><?php echo $arItem['NAME'];?></h3>
                        <p><?php echo $arItem['~PREVIEW_TEXT'];?></p>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="swiper-button-next swiper-button-next4 swiper-button-next-style1"></div>
    <div class="swiper-button-prev swiper-button-prev4 swiper-button-prev-style1"></div>
</div>
