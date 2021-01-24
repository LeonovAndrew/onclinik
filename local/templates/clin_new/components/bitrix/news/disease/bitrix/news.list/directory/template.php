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
    <div class="block_content directory-tab" id="directory-tab1">
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
										$n = 0;
										$k = 1;
										$lines = 0;
										foreach ($arGroup['items'] as $arItem) {
										   
											?>
											<?if ( $n > 0 && $n == 10 ):?>
												</ul>
												
												<?if ( $k == 3 ):?>
													</div>
													<div class="directory-list-wrap hide_directory">
													<?$k = 0;?>
													<?$lines++;?>
												<?endif;?>
												<ul class="directory-list">
												<?$n = 0;?>
												<?$k++;?>
											<?endif;?>
											<li>
												<a href="<?php echo $arItem['url'];?>"><?php echo $arItem['name'];?></a>
											</li>
											<?
											$n++;
										}
										?>
									</ul>
									<?if ( $k < 3 ):?>
										<?for ( $i = $k; $i < 3; $i++ ):?>
											<ul class="directory-list">
											</ul>
										<?endfor;?>
									<?endif;?>
                                </div>
                                
                                <?if ( $lines > 0):?>
									<div class="directory-btn-wrap">
										<span class="btn2 directory-btn">Показать еще</span>
									</div>
                                <?endif;?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;" class="block_content directory-tab" id="directory-tab2">
        <div class="directory-tab-wrap">
            <div class="directory-specialization">
                <div class="directory-list-wrap">
                    <ul class="directory-list tab_list1">
                        <?php
                        //TODO: groups
                        foreach ($arResult['direction_groups'] as $directionId => $arGroup) {
                            ?>
                            <li>
                                <a href="#directory-specialization-tab<?php echo $directionId;?>"><?php echo $arGroup['name'];?></a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
            foreach ($arResult['direction_groups'] as $directionId => $arGroup) {
                ?>
                <div style="display: none;" class="directory-specialization-tabs block_content1" id="directory-specialization-tab<?php echo $directionId;?>">
                    <div class="directory-list-wrap">
                        <div class="directory-specialization-tabs-title">
                            <h2><?php echo $arGroup['name'];?></h2>
                            <span class="btn2 directory-specialization-tabs-btn"><?php echo getMessage('BACK_BTN');?></span>
                        </div>
                        <ul class="directory-list">
                            <?php
							$n = 0;
                            foreach ($arGroup['items'] as $arItem) {
                               
								?>
								<?if ( $n > 0 && $n == 10 ):?>
									</ul>
									<ul class="directory-list">
									<?$n = 0;?>
								<?endif;?>
                                <li>
                                    <a href="<?php echo $arItem['url'];?>"><?php echo $arItem['name'];?></a>
                                </li>
                                <?
								$n++;
                            }
                            ?>
                        </ul>
                        <?/*
                        //TODO: show more btn
                        <div class="directory-btn-wrap">
                            <span class="btn2 directory-btn">Показать еще</span>
                        </div>
                        */?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>