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
<?if ( $arResult['PROPERTIES']['PRICE_H1']['VALUE'] ):?>
	<h1><?php echo $arResult['PROPERTIES']['PRICE_H1']['VALUE'];?></h1>
<?else:?>
	<h1><?=getMessage('TITLE_1')?> <?=$arResult['PROPERTIES']['DOCTOR_TITLE']['VALUE'];?></h1>
<?endif;?>


<?if ( $arResult['PROPERTIES']['PRICE_TEXT']['~VALUE']['TEXT'] ):?>
	<div class="attendance-text1 readmore">
		<?php echo $arResult['PROPERTIES']['PRICE_TEXT']['~VALUE']['TEXT'];?>
	</div>
<?endif;?>

<ul class="attendance-list">
    <?php
    //for hidden offers
    $k = 0;
    foreach ($arResult['offers'] as $obOffer) {
        ?>
        <li<?php if ($k++ > 13) {?> class="attendance-item-hidden1"<?php }?>>
            <span><?php echo $obOffer->name;?></span>
            <?php
            if ($obOffer->price != $obOffer->discountPrice) {
                ?>
                <b><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obOffer->discountPrice);?> ₽</b>
                <i><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obOffer->price);?> ₽</i>
                <?php
            } else {
                ?>
                <b><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obOffer->price);?> ₽</b>
                <?php
            }
            ?>
        </li>
        <?php
    }
    ?>
</ul>
<p class="price_info_text"><small><?php echo getMessage('PRICE_TEXT')?></small></p>
<div class="attendance-btn-wrap">
    <div class="attendance-btn1-wrap">
        <a href="<?php echo $arResult['DETAIL_PAGE_URL'];?>" class="attendance-btn1"><?php echo getMessage('ND_DIRECTIONS_DIRECTION');?></a>
    </div>
    <?php
    if ($k > 14) {
        ?>
        <div class="attendance-btn2-wrap">
            <span class="btn2 attendance-btn2"><?php echo getMessage('ND_DIRECTIONS_SHOW_MORE_TEXT');?></span>
        </div>
        <?php
    }
    ?>

    <?php
    if (!empty($arResult['FILE_SERVICES'])) {
        ?>
        <div class="attendance-btn3-wrap">
            <a href="<?php echo $arResult['FILE_SERVICES'];?>" download="<?php echo getMessage('DOWNLOAD_NAME') . ' ' . $arResult['NAME'];?>" class="attendance-btn3 excel"><?php echo getMEssage('DOWNLOAD_BTN');?></a>
        </div>
        <?php
    }
    ?>
</div>




<?if ( $arResult['PROPERTIES']['PRICE_TEXT_BOTTOM']['~VALUE']['TEXT'] ):?>
	<br><br>
	<div class="attendance-text1 readmore">
		<?php echo $arResult['PROPERTIES']['PRICE_TEXT_BOTTOM']['~VALUE']['TEXT'];?>
	</div>
<?endif;?>