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

?>
<?
 if (!empty($arResult['DOCTOR'])) {
        ?>
        <div class="service1-doctors service1-doctors-services-style">
            <h3>НАШИ ВРАЧИ</h3>
            <div class="service1-doctors-slider">
                <div class="swiper-container swiper-container7">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($arResult['DOCTOR'] as $obDoctor) {
                            ?>
                            <div class="swiper-slide">
                                <?php
                                if (!empty($obDoctor["IMG"])) {
                                    ?>
                                    <div class="service1-doctors-img">
                                        <img src="<?php echo $obDoctor["IMG"];?>" alt="<?php echo $obDoctor["NAME"];?>">
                                    </div>
                             <?}else{?>
                                    <div class="service1-doctors-img">
                                        <img src="/no-photo.jpg" alt="<?php echo $obDoctor["NAME"];?>">
                                    </div>
				<?}?>
                                <div class="service1-doctors-text">
                                    <h4><?php echo $obDoctor["NAME"];?></h4>
                                    <p><?=$obDoctor["POSITION"];?></p>
                                    <a href="<?=$obDoctor["URL"];?>" class="btn3">Подробнее о враче</a>
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
