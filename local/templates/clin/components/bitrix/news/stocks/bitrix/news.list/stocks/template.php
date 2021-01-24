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

<div class="stock-list" id="ajax-items-list">
    <?php
    foreach ($arResult['ITEMS'] as $arItem) {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="stock-item ajax-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <?php
            if (!empty($arItem['DATE_ACTIVE_TO'])) {
                ?>
                <div class="stock-timer-wrap">
                        <i><?php echo getMessage('PROMOTION_ENDS');?></i>
                        <div class="stock-timer">
                            <span class="service1-action-timer clock"><?php echo getMessage('TO');?> <?php echo $arItem['expire_date'];?></span>
							<!--<span class="service1-action-timer clock<?php echo $arItem['ID'];?>" data-date="<?php echo $arItem['DATE_ACTIVE_TO'];?>" data-id="<?php echo $arItem['ID'];?>"></span>-->
                        </div>
                    
                </div>
                <?php
            }
            ?>
            <div class="stock-img-wrap">
                <i><?php echo $arItem['PROPERTIES']['AMOUNT']['VALUE'];?><?php echo $arItem['PROPERTIES']['PERCENTAGE']['VALUE'] ? ' %' : ' р';?></i>
                <div class="stock-img">
                    <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
                </div>
                <div class="stock-btn">
                    <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="btn4"><?php echo getMessage('LEARN_MORE');?></a>
                </div>
            </div>
            <div class="stock-text">
                <h3><?php echo $arItem['NAME'];?></h3>
                <?php
                if (isset($arItem['expire_date'])) {
                    ?>
                    <!--<b><?php echo getMessage('TO');?> <?php echo $arItem['expire_date'];?></b>-->
                    <?php
                }
                ?>
				<p><?=$arItem['~PREVIEW_TEXT']?></p>
				<?/*
                <p>
					<?if ( count( $arItem['DISPLAY_PROPERTIES']['CLIENTS_TYPE']['DISPLAY_VALUE']) > 1 ):?>
						<strong><?=implode('/', $arItem['DISPLAY_PROPERTIES']['CLIENTS_TYPE']['DISPLAY_VALUE'])?></strong>
					<?else:?>
						<strong><?=$arItem['DISPLAY_PROPERTIES']['CLIENTS_TYPE']['DISPLAY_VALUE']?></strong>
					<?endif;?>
					<br>
					<?foreach ( $arItem['DISPLAY_PROPERTIES']['CLINICS']['DISPLAY_VALUE'] as $clinicName):?>
						<?=$clinicName?><br>
					<?endforeach;?>
				</p>
				*/?>
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

<?php
if ($isAjax) {
    die();
}
?>