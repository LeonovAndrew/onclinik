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

<div class="text__block text_block">

	<?if ( $arResult['PROPERTIES']['H1']['~VALUE'] ):?>
		<h1><?php echo $arResult['PROPERTIES']['H1']['~VALUE'];?></h1>
	<?endif;?>
	
    <img class="left" src="<?php echo $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?php echo $arResult['DETAIL_PICTURE']['ALT'];?>">
    <?php
    echo $arResult['TEXT_REPLACED'];
    ?>
</div>

<?php
if (!empty($arResult['OTHER_NEWS'])) {
    ?>
    <div class="achievement-wrap1">
        <h2><?php echo getMessage('ND_ACHIEV_OTHER_TITLE');?></h2>
        <div class="achievement-slider">
            <div class="swiper-container swiper-container13">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($arResult['OTHER_NEWS'] as $arAchieve) {
                        ?>
                        <div class="swiper-slide">
                            <div class="achievement-item achievement-item-1">
                                <div class="achievement-item-img-wrap">
                                    <div class="achievement-item-img">
                                        <img src="<?php echo $arAchieve['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo $arAchieve['PREVIEW_PICTURE']['ALT'];?>">
                                    </div>
                                    <div class="achievement-item-btn-wrap">
                                        <a href="<?php echo $arAchieve['DETAIL_PAGE_URL'];?>" class="btn4">Подробнее</a>
                                    </div>
                                </div>
                                <div class="achievement-item-text">
                                    <h3><?php echo $arAchieve['NAME'];?></h3>
                                    <p><?php echo $arAchieve['~PREVIEW_TEXT'];?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="swiper-button-next swiper-button-next13 swiper-button-next-style2"></div>
            <div class="swiper-button-prev swiper-button-prev13 swiper-button-prev-style2"></div>
        </div>
    </div>
    <?php
}
?>
