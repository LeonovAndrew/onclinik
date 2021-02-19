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
    <h2><?php echo getMessage('USEFUL_INFO_TITLE');?></h2>
    <div class="health-informations-list">
        <?php
        foreach ($arResult['ITEMS'] as $arItem) {
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="publications-item" id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
                <div class="publications-item-img">
                    <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
                </div>
                <div class="publications-item-text">
                    <h3><?php echo $arItem['NAME'];?></h3>
                    <p><?php echo $arItem['~PREVIEW_TEXT'];?></p>
                    <div class="publications-item-text-info">
                        <?php
                        if (!empty($arItem['DISPLAY_ACTIVE_FROM'])) {
                            ?>
                            <span><?php echo getMessage('PUBLISHED');?>:</span>
                            <b><?php echo $arItem['DISPLAY_ACTIVE_FROM'];?></b>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </a>
            <?php
        }
        ?>
    </div>
    <div class="health-link-wrap">
        <a href="<?php echo getMessage('USEFUL_INFO_LINK');?>"><?php echo getMessage('ALL_ARTICLES');?></a>
    </div>
    <?php
}
?>

