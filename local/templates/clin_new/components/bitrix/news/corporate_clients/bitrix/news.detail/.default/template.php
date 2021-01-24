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
<div class="company-text-container">
    <div class="company-text-wrap1">
        <div class="company-img1">
            <img src="<?php echo $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?php echo $arResult['DETAIL_PICTURE']['ALT'];?>">
        </div>
        <div class="company-text1">
            <?php echo $arResult['~PREVIEW_TEXT'];?>
            <?php
            if (!empty($arResult['PROPERTIES']['SITE']['VALUE'])) {
                ?>
                <a href="//<?php echo $arResult['PROPERTIES']['SITE']['VALUE'];?>"><?php echo $arResult['PROPERTIES']['SITE']['VALUE'];?></a>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="company-text-wrap2">
        <div class="company-text2">
            <?php echo $arResult['~DETAIL_TEXT'];?>
        </div>
    </div>
    <div class="text-btn">
        <i></i>
        <span>Показать еще</span>
        <span>Скрыть</span>
    </div>
</div>

