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

<div class="clinic-reviews">
    <h2><?php echo getMessage('REVIEWS_TITLE');?></h2>
    <div class="clinic-reviews-slider">
        <div class="swiper-container swiper-container15">
            <div class="swiper-wrapper">
                <?php
                foreach ($arResult['ITEMS'] as $arItem) {
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="swiper-slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="reviews-item reviews-item-1 readmore">
                            <div class="reviews-item-text1">
                                <span><?php echo $arItem['PROPERTIES']['PATIENT_NAME']['VALUE'];?></span>
                                <b><?php echo $arItem['DISPLAY_ACTIVE_FROM'];?></b>
                            </div>
                            <div class="reviews-item-text2">
                                <p><?php echo $arItem['DETAIL_TEXT'];?></p>
                                <ul class="reviews-list2">
                                    <?php
                                    if (!empty($arItem['doctor']['name'])) {
                                        ?>
                                        <li class="reviews-item2 reviews-item21"><?php echo $arItem['doctor']['name'];?></li>
                                        <?php
                                    }

                                    if (!empty($arItem['clinic']['name'])) {
                                        ?>
                                        <li class="reviews-item2 reviews-item22"><?php echo $arItem['clinic']['name'];?></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="swiper-button-next swiper-button-next15 swiper-button-next-style2"></div>
        <div class="swiper-button-prev swiper-button-prev15 swiper-button-prev-style2"></div>
    </div>
    <div class="clinic-reviews-btn-wrap">
        <a href="<?php echo getMessage('REVIEWS_LINK');?>?reviewClinicId=<?php echo $arParams['CLINIC_ID'];?>#feedback" class="btn3"><?php echo getMessage('GIVE_FEEDBACK');?></a>
        <a href="<?php echo getMessage('REVIEWS_LINK');?>?clinicId=<?php echo $arParams['CLINIC_ID'];?>" class="reviews-btn"><?php echo getMessage('ALL_CLINIC_REVIEWS');?></a>
    </div>
</div>