<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
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
	<?if ( $arResult['PROPERTIES']['H1']['~VALUE'] ):?>
		<h1><?php echo $arResult['PROPERTIES']['H1']['~VALUE'];?></h1>
	<?endif;?>

<div class="action-info">
    <div class="action-info-wrap clearfix readmore">
       <!--<?php
        if (!empty($arResult['expire_date'])) {
            ?>
            <div class="action-info-time action-info-time1">
                <div class="promo-ends">
                    <b><?php echo getMessage('PROMOTION_ENDS');?></b>
                    <div class="stock-timer">
					    
                        <span class="service1-action-timer clock<?php echo $arResult['ID'];?>" data-date="<?php echo $arResult['expire_date'];?>" data-id="<?php echo $arResult['ID'];?>"></span>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>-->
        <div class="action-info-img" style="">
            <img src="<?php echo $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?php echo $arResult['DETAIL_PICTURE']['ALT'];?>">
            <p>
                <span><?php echo getMessage('DISCOUNT');?></span>
                <b><?php echo $arResult['PROPERTIES']['AMOUNT']['VALUE'];?><?php echo $arResult['PROPERTIES']['PERCENTAGE']['VALUE'] ? ' %' : ' р';?></b>
            </p>
        </div>
        <div class="action-info-text">
			<?/* 
		    <i class="action-paragraph1">
                <?php echo $arResult['~PREVIEW_TEXT'];?>
            </i>
			*/?>
            <?php
            if (!empty($arResult['expire_date'])) {
                ?>
                <div class="action-info-time">
                    <div class="promo-ends">
                        <b><?php echo getMessage('PROMOTION_ENDS');?></b>
                        <div class="stock-timer">
                            <span class="service1-action-timer clock<?php echo $arResult['ID'];?>" data-date="<?php echo $arResult['expire_date'];?>" data-id="<?php echo $arResult['ID'];?>"></span>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php echo $arResult['~DETAIL_TEXT'];?>
        </div>
    </div>
</div>
