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

<div class="clinics-list" id="clinics">
    <?php
    foreach ($arResult['ITEMS'] as $arItem) {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="clinics-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="clinics-item-img-wrap">
                <div class="clinics-img">
                    <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
                </div>
                <div class="clinics-item-text-wrap1">
                    <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="btn4"><?php echo getMessage('details');?></a>
                </div>
            </div>
            <div class="clinics-item-text-wrap2">
                <div class="clinics-item-title">
                    <div class="clinics-item-title-wrap1">
                        <h3><?php echo $arItem['NAME'];?></h3>
                        <p><?php echo $arItem['PROPERTIES']['ADDRESS']['VALUE'];?></p>
                    </div>
                    <div class="clinics-item-title-wrap2">
                        <a href="<?php echo $arItem['DETAIL_PAGE_URL'] . '?route=Y';?>"></a>
                    </div>
                </div>
                <ul>
                    <?php
                    if (!empty($arItem['PROPERTIES']['METRO']['VALUE'])) {
                        ?>
                        <li class="metro"><?php echo $arItem['PROPERTIES']['METRO']['VALUE'];?></li>
                        <?php
                    }

                    if (!empty($arItem['PROPERTIES']['PHONE']['VALUE'])) {
                        ?>
                        <li class="phone">
                            <a href="tel: <?php echo getNumericalPhone($arItem['PROPERTIES']['PHONE']['VALUE']);?>" onclick="gtag('event', 'form_submit', { 'event_category': 'form', 'event_action': 'Tel-Clinics', }); ym('2120464', 'reachGoal', 'Tel-Clinics'); return true;"><?php echo $arItem['PROPERTIES']['PHONE']['VALUE'];?></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
                //TODO: form
                ?>
                <div class="clinics-item-btn-wrap">
                    <a href="#" class="js-appointment-btn btn1"><?php echo getMessage('make_appointment');?></a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>