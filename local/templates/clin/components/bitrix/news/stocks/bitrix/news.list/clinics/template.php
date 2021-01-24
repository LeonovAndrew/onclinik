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

<?php
if (!empty($arResult['ITEMS'])) {
    ?>
    <div class="action-clinics">
        <h2><?php echo getMessage('in_clinics');?></h2>
        <div class="action-clinics-slider">
            <div class="swiper-container swiper-container20">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($arResult['ITEMS'] as $arItem) {
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <div class="swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                            <div class="clinics-item">
                                <div class="clinics-item-img-wrap">
                                    <?php
                                    if (!empty($arItem['PREVIEW_PICTURE']['SRC'])) {
                                        ?>
                                        <div class="clinics-img">
                                            <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="clinics-item-text-wrap1">
                                        <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="btn4"><?php echo getMessage('clinics_detail');?></a>
                                    </div>
                                </div>
                                <div class="clinics-item-text-wrap2">
                                    <div class="clinics-item-title">
                                        <div class="clinics-item-title-wrap1">
                                            <h3><?php echo $arItem['NAME'];?></h3>
                                            <p><?php echo $arItem['PROPERTIES']['ADDRESS']['VALUE'];?></p>
                                        </div>
                                        <div class="clinics-item-title-wrap2">
                                            <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>"></a>
                                        </div>
                                    </div>
                                    <ul>
                                        <li class="metro"><?php echo $arItem['PROPERTIES']['METRO']['VALUE'];?></li>
                                        <li class="phone">
                                            <a href="tel: <?php echo getNumericalPhone($arItem['PROPERTIES']['PHONE']['VALUE']);?>"><?php echo $arItem['PROPERTIES']['PHONE']['VALUE'];?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="swiper-button-next swiper-button-next20 swiper-button-next-style2"></div>
            <div class="swiper-button-prev swiper-button-prev20 swiper-button-prev-style2"></div>
        </div>
    </div>
    <?php
}
?>