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

<div class="doctor-reviews">
    <h2><?php echo getMessage('NL_REVIEWS_TITLE');?></h2>
    <div class="doctor-reviews-slider">
        <div class="swiper-container swiper-container22">
            <div class="swiper-wrapper">
                <?php
                foreach ($arResult['ITEMS'] as $arItem) {
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>

                    <div class="swiper-slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="reviews-item readmore">
                            
                            <div class="reviews-item-text2">
                                <p><?php echo $arItem['DETAIL_TEXT'];?></p>
                                <ul class="reviews-list2">
                                    <li class="reviews-item2 reviews-item22"><?php echo $arItem['CLINIC']['NAME'];?></li>
                                </ul>
                            </div>
							<div class="reviews-item-text1">
                                <span><?php echo $arItem['PROPERTIES']['PATIENT_NAME']['VALUE'];?></span>
                                <b><?php echo $arItem['DISPLAY_ACTIVE_FROM'];?></b>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="swiper-button-next swiper-button-next22 swiper-button-next-style2"></div>
        <div class="swiper-button-prev swiper-button-prev22 swiper-button-prev-style2"></div>
    </div>
    <div class="doctor-reviews-btn-wrap">
        <a href="<?php echo getMessage('LEAVE_FEEDBACK_LINK') . '?nameDoctor=' . $arResult['doctor']->name . '#feedback';?>" class="btn3"><?php echo getMessage('LEAVE_FEEDBACK');?></a>
        <?php
        if (!empty($arResult['doctor'])) {
            ?>
            <a href="<?php echo getMessage('ALL_REVIEWS_LINK') . '?search=' . $arResult['doctor']->name;?>" class="doctor-reviews-link"><?php echo getMessage('SEE_ALL_REVIEWS');?></a>
            <?php
        }
        ?>
    </div>
</div>
