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

<div class="contact1-title2">
    <h2><?php echo $arResult['NAME'];?></h2>
</div>

<?php
$isAjax = !empty($arParams['IS_AJAX']) ? $arParams['IS_AJAX'] : false;
if ($isAjax) {
    $APPLICATION->RestartBuffer();
}
?>

<div class="contact1-list3" id="ajax-items-list">
    <?php
    foreach ($arResult['ITEMS'] as $arItem) {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <div class="contact1-item3 ajax-item">
            <div class="contact1-item-text-wrap">
                <h3><?php echo $arItem['NAME'];?></h3>
                <b><?php echo $arItem['PROPERTIES']['FULL_NAME']['~VALUE'];?></b>
                <p><?php echo $arItem['PROPERTIES']['POST']['~VALUE'];?></p>
            </div>
            <ul class="contact1-list4">
                <?php
                if (!empty($arItem['PROPERTIES']['PHONE']['VALUE'])) {
                    ?>
                    <li>
                        <b><?php echo getMessage('phone');?></b>
                        <a href="tel:<?php echo getNumericalPhone($arItem['PROPERTIES']['PHONE']['VALUE']);?>">
                            <?php echo $arItem['PROPERTIES']['PHONE']['VALUE'];?><?php if (!empty($arItem['PROPERTIES']['PHONE_ADDITIONAL']['VALUE'])) {?> (доб. <?php echo $arItem['PROPERTIES']['PHONE_ADDITIONAL']['VALUE'];?>)<?php }?>
                        </a>
                    </li>
                    <?php
                }

                if (!empty($arItem['PROPERTIES']['EMAIL']['VALUE'])) {
                    ?>
                    <li>
                        <b><?php echo getMessage('email');?></b>
                        <a href="mailto:<?php echo $arItem['PROPERTIES']['EMAIL']['VALUE'];?>"><?php echo $arItem['PROPERTIES']['EMAIL']['VALUE'];?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
    }
    ?>
</div>

<?php
if ($arParams["DISPLAY_BOTTOM_PAGER"]) {
    echo $arResult['NAV_STRING'];
}

if ($isAjax) {
    die();
}
?>