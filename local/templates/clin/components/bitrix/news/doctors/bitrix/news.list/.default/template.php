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
    foreach ($arResult['ITEMS'] as $arItem) {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <div class="doctors-item ajax-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="doctors-item-img-wrap">
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
            <div class="doctors-item-text2">
                <h3><?php echo $arItem['NAME'];?></h3>
                <span><?php echo $arItem['PROPERTIES']['POSITION']['VALUE']['TEXT'];?></span>
                <?php
                foreach ($arItem['CLINICS'] as $arClinic) {
                    ?>
                    <b><?php echo $arClinic['NAME'];?></b>
                    <?php
                }
                ?>
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