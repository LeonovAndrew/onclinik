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

<div class="banner-slider">
    <div class="swiper-container swiper-container3">
        <div class="swiper-wrapper">
            <?php
            foreach ($arResult['ITEMS'] as $arItem) {
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="swiper-slide" id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
                    <div class="banner-item">
                        <i style="background:url(<?php echo $arItem['PICTURE'];?>) right center no-repeat; background-size: cover;"></i>
                        <div class="banner-info">
                            <h2><?php echo $arItem['NAME'];?></h2>
                            <?php
                            if (!empty($arItem['price'])) {
                                ?>
                                <div class="banner-price-wrap">
                                    <?php
                                    if ($arItem['discount'] != $arItem['base']) {
                                        ?>
                                        <b class="banner-price banner-price-new"><?php echo priceFormat($arItem['price']['discount']);?> ₽</b>
                                        <b class="banner-price banner-price-old"><?php echo priceFormat($arItem['price']['base']);?> ₽</b>
                                        <?php
                                    } else {
                                        ?>
                                        <b class="banner-price banner-price-new"><?php echo priceFormat($arItem['price']['base']);?> ₽</b>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }

                            echo $arItem['~PREVIEW_TEXT'];
                            ?>
                            <a href="<?php echo $arItem['link'];?>" class="btn1"><?php echo getMessage('details');?></a>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="swiper-pagination swiper-pagination3 swiper-pagination-style1"></div>
</div>
