<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */
?>



<div class="banner-tabs-wrap">
    <?php
    $k = 0;
        ?>
        <div <?php echo $k != 0 ? ' style="display:none"' : '';?> class="banner-tab block_content" id="banner-tab-<?php echo ++$k;?>">
            <div class="banner-tab-slider">
                <div class="swiper-container swiper-containerNew<?php echo $k;?>">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($arResult['tabs']['section'] as $arSection) {
                            ?>
                            <div class="swiper-slide">
                                <ul class="banner-list">
                                    <?php
                                    foreach ($arSection['items'] as $arItem) {
                                        ?>
                                        <li>
                                            <a href="<?php echo $arItem['LINK'];?>" <?=$arItem["PARAMS"]["BLANK"]?> <?if ($arItem["PARAMS"]["BLANK"] == "Y" ):?>target="_blank"<?endif;?>><?php echo $arItem['TEXT'];?></a>
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
                </div>
                <div class="swiper-button-next swiper-button-nextNew<?php echo $k;?> swiper-button-next-style1"></div>
                <div class="swiper-button-prev swiper-button-prevNew<?php echo $k;?> swiper-button-prev-style1"></div>
            </div>
        </div>
</div>
<div class="banner-link-wrap1">
    <a href="<?php echo getMessage('all_directions_link');?>"><?php echo getMessage('all_directions');?></a>
</div>
