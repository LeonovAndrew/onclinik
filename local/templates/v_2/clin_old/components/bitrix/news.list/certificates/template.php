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
$isAjax = !empty($arParams['IS_AJAX']) ? $arParams['IS_AJAX'] : false;
if ($isAjax) {
    $APPLICATION->RestartBuffer();
}
?>

<div class="certificates-list certificates-list1" id="ajax-items-list">
    <?php
    foreach ($arResult['ITEMS'] as $arItem) {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <div class="certificates-item ajax-item">
            <h3><?php echo $arItem['NAME'];?></h3>
            <div class="certificates-item-wrap">
                <a class="certificates-item-img1 fancybox" data-fancybox="galleryLicense_<?php echo $arItem['ID'];?>" href="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>">
                    <img src="<?php echo $arItem['PREVIEW_PICTURE']['PREVIEW']['SRC'];?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['PREVIEW']['ALT'];?>">
                </a>
                <div class="certificates-item-img-wrap">
                    <?php
                    foreach ($arItem['ADDITIONAL_PICTURES']['ITEMS'] as $key => $arPic) {
                        if ($key > 1) {
                            ?>
                            <a class="fancybox" href="<?php echo $arPic['SRC'];?>" data-fancybox="galleryLicense_<?php echo $arItem['ID'];?>"></a>
                            <?php
                        } elseif ($key == 0) {
                            ?>
                            <a href="<?php echo $arPic['SRC'];?>" data-fancybox="galleryLicense_<?php echo $arItem['ID'];?>" class="certificates-item-img fancybox">
                                <img src="<?php echo $arPic['PREVIEW']['SRC'];?>" alt="<?php echo $arPic['PREVIEW']['ALT'];?>">
                            </a>
                            <?php
                        } elseif ($key == 1) {
                            ?>
                            <a class="fancybox" href="<?php echo $arPic['SRC'];?>" data-fancybox="galleryLicense_<?php echo $arItem['ID'];?>">
                                <img src="<?php echo $arPic['PREVIEW']['SRC'];?>" alt="<?php echo $arPic['PREVIEW']['ALT'];?>">
                                <?php
                                if ($arItem['ADDITIONAL_PICTURES']['COUNT']) {
                                    ?>
                                    <div class="certificates-item-btn">
                                        <span class="btn4"><?php echo getMessage('LICENSE_PLUS');?> <?php echo $arItem['ADDITIONAL_PICTURES']['COUNT'];?></span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
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

if ($isAjax) {
    die();
}
?>