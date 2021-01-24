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

<div class="directory-tabs">
    <div style="display: none;" class="block_content directory-tab" id="directory-tab1">
        <div class="directory-tab-wrap">
            <div class="directory-slider">
                <div class="swiper-pagination swiper-pagination19"></div>
                <div class="swiper-button-next swiper-button-next19 swiper-button-next-style2"></div>
                <div class="swiper-button-prev swiper-button-prev19 swiper-button-prev-style2"></div>
                <div class="swiper-container swiper-container19">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($arResult['letter_groups'] as $arGroup) {
                            ?>
                            <div class="swiper-slide" data-letter="<?php echo $arGroup['name'];?>">
                                <h2><?php echo $arGroup['name'];?></h2>
                                <div class="directory-list-wrap">
                                    <ul class="directory-list">
                                        <?php
                                        //TODO: items groups
                                        foreach ($arGroup['items'] as $arItem) {
                                            ?>
                                            <li>
                                                <a href="<?php echo $arItem['url'];?>"><?php echo $arItem['name'];?></a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?/*
                                //TODO: show more btn;
                                <div class="directory-btn-wrap">
                                    <span class="btn2 directory-btn">Показать еще</span>
                                </div>
                                */?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block_content directory-tab" id="directory-tab2">
        <div class="directory-tab-wrap">
            <div class="solutions">
                <div class="solutions-text1">
                    <p>Для просмотра симптомов, выберите любой участок тела - голову, глаза, сердце, руку, ногу, живот - соответствующий вашему больному органу</p>
                </div>
                <div class="solutions-wrap">
                    <div class="solutions-img-wrap">
                        <div class="solutions-img">
                            <img src="<?php echo SITE_TEMPLATE_PATH . '/assets/img/solutions-img.jpg';?>" alt="">
                        </div>
                        <ul class="tab_list1">
                            <?php
                            $first = true;
                            foreach ($arResult['body_part_groups'] as $key => $arGroup) {
                                ?>
                                <li>
                                    <a class="<?php if ($first) { echo 'active '; $first = false; }?>" href="#solutions-tab<?php echo $key;?>" style="top: <?php echo $arGroup['css_top'];?>px; left: <?php echo $arGroup['css_left'];?>px"><?php echo $arGroup['name'];?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="solutions-info">
                        <?php
                        $first = true;
                        foreach ($arResult['body_part_groups'] as $key => $arGroup) {
                            ?>
                            <div style="<?php if (!$first) { echo 'display: none;'; } else { $first = false; }?>" class="solutions-info-container block_content1" id="solutions-tab<?php echo $key;?>">
                                <div class="solutions-info-wrap">
                                    <ul class="solutions-list">
                                        <?php
                                        foreach ($arGroup['items'] as $arItem) {
                                            ?>
                                            <li>
                                                <a href="<?php echo $arItem['url'];?>"><?php echo $arItem['name'];?></a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="solutions-slider">
                                    <h2><?php echo $arGroup['name'];?></h2>
                                    <div class="swiper-container swiper-container24">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <ul class="solutions-list">
                                                    <?php
                                                    foreach ($arGroup['items'] as $arItem) {
                                                        ?>
                                                        <li>
                                                            <a href="<?php echo $arItem['url'];?>"><?php echo $arItem['name'];?></a>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <?php
                                            //TODO: slider
                                            ?>
                                        </div>
                                    </div>
                                    <div class="swiper-button-next swiper-button-next24 swiper-button-next-style2"></div>
                                    <div class="swiper-button-prev swiper-button-prev24 swiper-button-prev-style2"></div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="solutions-text2">
                    
                </div>
            </div>
        </div>
    </div>
</div>