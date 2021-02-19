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
<?php echo $arResult['~DETAIL_TEXT'];?>
<div class="box_price">
    <?php
    if ($arResult['price']['base']) {
        ?>
        <div class="price_name"><?php echo getMessage('program_price');?>:</div>
        <?php
        if ($arResult['price']['base'] > $arResult['price']['discount']) {
            ?>
            <div class="price"><?php echo getMessage('program_price_from');?> <b><?php echo priceFormat($arResult['price']['discount']);?> ₽</b> <span><?php echo getMessage('program_price_from');?> <b><?php echo priceFormat($arResult['price']['base']);?> ₽</span></div>
            <?php
        } else {
            ?>
            <div class="price"><?php echo getMessage('program_price_from');?> <b><?php echo priceFormat($arResult['price']['base']);?> ₽</b></div>
            <?php
        }
        ?>
        <?php
    }
    ?>
</div>