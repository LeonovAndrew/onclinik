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
<?
 if (!empty($arResult['DOCTORS'])) {
        ?>
        <div class="service1-doctors service1-doctors-services-style">
            <h3>НАШИ ВРАЧИ</h3>
            <div class="service1-doctors-slider">
                <div class="swiper-container swiper-container7">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($arResult['DOCTORS'] as $obDoctor) {
                            ?>
                            <div class="swiper-slide">
                                <?php
                                if (!empty($obDoctor->previewPicture['SRC'])) {
                                    ?>
                                    <div class="service1-doctors-img">
                                        <img src="<?php echo $obDoctor->previewPicture['SMALL_SRC'];?>" alt="<?php echo $obDoctor->previewPicture['ALT'];?>">
                                    </div>
                             <?}else{?>
                                    <div class="service1-doctors-img">
                                        <img src="/no-photo.jpg" alt="<?php echo $obDoctor->previewPicture['ALT'];?>">
                                    </div>
				<?}?>
                                <div class="service1-doctors-text">
                                    <h4><?php echo $obDoctor->name;?></h4>
                                    <p><?php echo $obDoctor->position;?></p>
                                    <a href="<?php echo $obDoctor->url;?>" class="btn3"><?php echo getMessage('ND_DIRECTIONS_DOCTOR_DETAIL');?>Подробнее о враче</a>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="swiper-button-next swiper-button-next7 swiper-button-next-style2"></div>
                <div class="swiper-button-prev swiper-button-prev7 swiper-button-prev-style2"></div>
            </div>
            <div class="service1-doctors-link-wrap">
                <a href="/doctors/?departmentId=&directionId=<?=$arResult["PROPERTY_128"][0]?>">ВСЕ ВРАЧИ НАПРАВЛЕНИЯ</a>
            </div>
        </div>
        <?php
    }

?>

<!--
<pre>
    <?/*print_r($arResult['DOCTORS']);*/?>
</pre>-->
