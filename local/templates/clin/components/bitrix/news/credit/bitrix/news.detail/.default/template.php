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

<?php
$this->setViewTarget('credit_title');
    ?>
	<?if ( $arResult['PROPERTIES']['TITLE']['~VALUE'] ):?>
		<h1><?php echo $arResult['PROPERTIES']['TITLE']['~VALUE'];?></h1>
	<?endif;?>
    <?php
$this->endViewTarget();

$this->setViewTarget('credit_info');
    if (!empty($arResult['DETAIL_PICTURE']['SRC'])) {
        ?>
        <div class="creditFeedback-img">
            <img src="<?php echo $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?php echo $arResult['DETAIL_PICTURE']['ALT'];?>">
        </div>
        <?php
    }
    ?>
    <div class="creditFeedback-container-text">
        <?php echo $arResult['~DETAIL_TEXT'];?>
    </div>
    <?php
$this->endViewTarget();
?>
