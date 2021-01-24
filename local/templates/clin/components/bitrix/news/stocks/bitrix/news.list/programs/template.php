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
    <div class="action-programs">
        <h2><?php echo getMessage('PROGRAMS_TITLE');?></h2>
        <ul class="action-programs-list" id="ajax-items-list">
            <?php
            foreach ($arResult['ITEMS'] as $arItem) {
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <li class="ajax-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <div class="action-programs-item-wrap">
                        <p><a href="<?=$arItem['DETAIL_PAGE_URL'];?>"><?php echo $arItem['NAME'];?></a></p>
                        <?php
                        if (!empty($arItem['DISCOUNT_PRICE']) && ($arItem['DISCOUNT_PRICE'] != $arItem['PROPERTIES']['PRICE']['VALUE'])) {
                            ?>
                            <b><?php echo getMessage('program_price_from');?> <?php echo priceFormat($arItem['DISCOUNT_PRICE']);?> ₽</b>
                            <span><?php echo getMessage('program_price_from');?> <?php echo priceFormat($arItem['PROPERTIES']['PRICE']['VALUE']);?> ₽</span>
                            <?php
                        } else {
                            ?>
                            <b><?php echo getMessage('program_price_from');?> <?php echo priceFormat($arItem['PROPERTIES']['PRICE']['VALUE']);?> ₽</b>
                            <?php
                        }
                        ?>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
        echo $arResult['NAV_STRING'];
        ?>
    </div>
    <?php
}
?>