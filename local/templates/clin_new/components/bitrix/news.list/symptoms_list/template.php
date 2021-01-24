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
    <div class="health-problem">
        <h2><?php echo getMessage('PROBLEMS_TITLE');?></h2>

        <ul class="health-problem-list">
            <?php
            foreach ($arResult['ITEMS'] as $arItem) {
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
        <div class="health-link-wrap">
            <a href="<?php echo getMessage('SYMPTOMS_LINK');?>"><?php echo getMessage('ALL_PROBLEMS');?></a>
        </div>
    </div>
    <?php
}
?>
