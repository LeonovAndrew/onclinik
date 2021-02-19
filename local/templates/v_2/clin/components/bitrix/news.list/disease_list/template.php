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
    <h2 class="health-subtitle"><?php echo getMessage('DISEASE_LIST_TITLE');?></h2>
    <div class="health-list-wrap">
        <?php
        foreach ($arResult['LIST'] as $arList) {
            ?>
            <ul class="health-list">
                <?php
                foreach ($arList as $arItem) {
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <li id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
                        <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>"><?php echo $arItem['NAME'];?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
        ?>
    </div>
    <div class="health-btn-wrap">
        <?php
        if (count($arResult['LIST'] > 1)) {
            ?>
            <span class="btn2 health-btn"><?php echo getMessage('SHOW_MORE_BTN');?></span>
            <?php
        }
        ?>
        <div class="health-link-wrap">
            <a href="/diseases/"><?php echo getMessage('ALL_DISEASES');?></a>
        </div>
    </div>
    <?php
}
?>