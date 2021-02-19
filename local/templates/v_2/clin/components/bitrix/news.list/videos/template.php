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



<div class="videos-list" id="ajax-items-list">
    <?php
    foreach ($arResult['ITEMS'] as $index => $arItem) {
        ?>
        <div class="videos-item ajax-item" itemscope itemtype="http://schema.org/VideoObject">
            <a href="#videos-popup-<?=$arItem['ID']?>" data-link="<?php echo $arItem['PROPERTIES']['LINK']['VALUE'];?>" class="videos-item-wrap fancybox">
                <span itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
					<img itemprop="contentUrl" src="<?php echo $arItem['DETAIL_PICTURE']['SRC']?>" alt="<?php echo $arItem['DETAIL_PICTURE']['ALT'];?>">
				</span>
			</a>
			
			<span itemprop="url" href="<?php echo $arItem['PROPERTIES']['LINK']['VALUE'];?>"></span>
            <span class="video_hidden" itemprop="description"><?php echo $arItem['NAME'];?></span>
			<span class="video_hidden" itemprop="uploadDate"><?=str_replace(Array('/', ' '), Array('-', 'T'), $arItem['TIMESTAMP_X'])?></span>
			<meta itemprop="duration" content="PT6M58S">
			<meta itemprop="isFamilyFriendly" content="true">
			<meta itemprop="thumbnailUrl" content="<?php echo $arItem['DETAIL_PICTURE']['SRC']?>">
			<meta itemprop="contentUrl" content="<?php echo $arItem['PROPERTIES']['LINK']['VALUE'];?>">
			
			<div class="videos-item-text">
                <h3 itemprop="name"><?php echo $arItem['NAME'];?></h3>
            </div>

            <div class="hidden">
                <div class="popup-videos" id="videos-popup-<?=$arItem['ID']?>">
                    <div class="thumb-wrap">
                        <iframe src="<?php echo $arItem['PROPERTIES']['LINK']['VALUE'];?>" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<?php
echo $arResult['NAV_STRING'];
?>
