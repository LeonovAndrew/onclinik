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


<div class="doctor-info clearfix<?php echo !empty($arResult['~DETAIL_TEXT']) ? ' readmore' : '';?>">
    <div class="doctor-info-img">
<?if(empty($arResult['DETAIL_PICTURE']['SRC'])){?>                   
<img src="/no-photo.jpg" alt="<?php echo $arResult['DETAIL_PICTURE']['ALT'];?>">
<?}else{?>
        <img src="<?php echo $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?php echo $arResult['DETAIL_PICTURE']['ALT'];?>">
<?}?>
    </div>
    <div class="doctor-info-text">
        <div class="doctor-info-title">
            <h1><?php echo $arResult['NAME'];?></h1>
				
            <span><?php echo $arResult['PROPERTIES']['POSITION']['VALUE']['TEXT'];?></span>
        </div>
        <div class="doctor-info-text-wrap1">
            <?php
            if (!empty($arResult['CLINICS'])) {
                ?>
                <b><?php echo getMessage('LEADS_RECEPTION_IN');?>:</b>
                <ul>
                    <?php
                    foreach ($arResult['CLINICS'] as $obClinic) {
                        ?>
                        <li><a href="<?php echo $obClinic->url;?>"><?php echo $obClinic->name;?></a></li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }

            if (!empty($arResult['PROPERTIES']['EXPERIENCE']['~VALUE'])) {
                ?>
                <p><?php echo $arResult['PROPERTIES']['EXPERIENCE']['~VALUE'];?></p>
                <?php
            }
            ?>
        </div>
        <?php
        if (!empty($arResult['PRICES'])) {
            ?>
            <div class="doctor-info-text-wrap2">
                <h2><?php echo getMessage('ADMISSION_COST');?>: <b><?php echo getMessage('PRICE_FROM');?> <i><?php echo priceFormat($arResult['PRICES']['discount_price']);?> ₽</i></b></h2>
                <?php
                if ($arResult['PRICES']['price'] != $arResult['PRICES']['discount_price']) {
                    ?>
                    <b><?if ( !$arResult['PRICES']['simple']){ echo getMessage('PRICE_FROM');}?> <i><?php echo priceFormat($arResult['PRICES']['discount_price']);?> ₽</i></b>
                    <span><?if ( !$arResult['PRICES']['simple']){ echo getMessage('PRICE_FROM');}?> <?php echo priceFormat($arResult['PRICES']['price']);?> ₽</span>
                    <?php
                } else {
                    ?>
                    <b><?if ( !$arResult['PRICES']['simple']){ echo getMessage('PRICE_FROM');}?> <i><?php echo priceFormat($arResult['PRICES']['price']);?> ₽</i></b>
                    <?php
                }

                if (!empty($arResult['OFFERS'])) {
                    ?>
                    <a href="#prices" class="btn3"><?php echo getMessage('ALL_PRICES');?></a>
                    <?php
                }
                ?>
            </div>
			 <?php
        }
        ?>
		
        <div class="doctor-info-text-wrap3">
            <?php echo $arResult['~PREVIEW_TEXT'];?>
        </div>
        <div class="doctor-info-text-wrap4">
            <?php echo $arResult['~DETAIL_TEXT'];?>
        </div>
    </div>
    <?php
    if (!empty($arResult['~DETAIL_TEXT'])) {
        ?>
        <b></b>
        <?php
    }
    ?>
</div>

<?php
$this->setViewTarget('offers');
    if (!empty($arResult['OFFERS'])) {
        ?>
        <div class="doctor-cost" id="prices">
            <h2><?php echo getMessage('PRICE_TITLE');?></h2>
            <ul class="action-programs-list">
                <?php
                foreach ($arResult['OFFERS'] as $obOffer) {
                    ?>
                    <li>
                        <div class="action-programs-item-wrap">
                            <p><?php echo $obOffer->name;?></p>
                            <?php
                            if ($obOffer->price != $obOffer->discountPrice) {
                                ?>
								<div>
									<b><?php echo priceFormat($obOffer->discountPrice);?> ₽</b>
									<span><?php echo priceFormat($obOffer->price);?> ₽</span>
                                </div>
								<?php
                            } else {
                                ?>
								<div class="no_discount">
									<b><?php echo priceFormat($obOffer->price);?> ₽</b>
                                </div>
								<?php
                            }
                            ?>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
		<p class="price_info_text"><small><?php echo getMessage('PRICE_TEXT')?></small></p>
           
        <?php
    }
$this->endViewTarget();
?>

<?php
$this->setViewTarget('specialization');
    if (!empty($arResult['PROPERTIES']['SPECIALIZATION']['~VALUE']['TEXT'])) {
        ?>
        <div class="doctor-specialization">
            <h2><?php echo getMessage('SPECIALIZATION_TITLE');?></h2>
            <?php
            echo $arResult['PROPERTIES']['SPECIALIZATION']['~VALUE']['TEXT'];
            ?>
        </div>
        <?php
    }
$this->endViewTarget();
?>



<?php
$this->setViewTarget('regalia');
    if (!empty($arResult['PROPERTIES']['REGALIA']['~VALUE']['TEXT'])) {
        ?>
        <div class="doctor-regalia readmore">
            <h2><?php echo getMessage('REGALIA_TITLE');?></h2>
            <?php echo $arResult['PROPERTIES']['REGALIA']['~VALUE']['TEXT'];?>
        </div>
        <?php
    }
$this->endViewTarget();
?>

<?php
$this->setViewTarget('certificates');
    if (!empty($arResult['CERTIFICATES'])) {
        ?>
        <div class="doctor-certificates">
            <h2><?php echo getMessage('CERTIFICATES_TITLE');?></h2>
            <div class="doctor-certificates-slider">
                <div class="swiper-container swiper-container23">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($arResult['CERTIFICATES'] as $arCertificate) {
                            ?>
                            <div class="swiper-slide">
                                <div class="doctor-certificates-item">
                                    <a class="doctor-certificates-img fancybox" href="<?php echo $arCertificate['PICTURE']['DETAIL']['SRC'];?>">
                                        <img src="<?php echo $arCertificate['PICTURE']['PREVIEW']['SRC'];?>" alt="<?php echo $arCertificate['PICTURE']['PREVIEW']['ALT'];?>">
                                    </a>
                                    <p><?php echo $arCertificate['DESCRIPTION'];?></p>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="swiper-button-next swiper-button-next23 swiper-button-next-style2"></div>
                <div class="swiper-button-prev swiper-button-prev23 swiper-button-prev-style2"></div>
            </div>
        </div>
        <?php
    }
$this->endViewTarget();
?>

<?php
$this->setViewTarget('practical_activity');
    if (!empty($arResult['PROPERTIES']['PRACTICAL_ACTIVITY']['~VALUE']['TEXT'])) {
        ?>
        <div class="doctor-text-wrap">
            <?php echo $arResult['PROPERTIES']['PRACTICAL_ACTIVITY']['~VALUE']['TEXT'];?>
        </div>
        <?php
    }
$this->endViewTarget();
?>

<?php
$this->setViewTarget('video');
    if (!empty($arResult['PROPERTIES']['VIDEO']['VALUE'])) {
        ?>
        <div class="rules-text-video">
            <div class="video_wrapper video_wrapper_full js-videoWrapper">
                <iframe class="videoIframe js-videoIframe" src="" frameborder="0" allowTransparency="true" allowfullscreen data-src="<?php echo $arResult['PROPERTIES']['VIDEO']['VALUE'];?>"></iframe>
                <button class="videoPoster js-videoPoster" <?php echo $arResult['PROPERTIES']['VIDEO']['VALUE'] ? 'style="background-image:' . $arResult['PROPERTIES']['VIDEO']['VALUE'] . '"' : '';?></button>
            </div>
        </div>
        <?php
    }
$this->endViewTarget();
?>
<?if ( $arResult['PROPERTIES']['FORM']['VALUE']['TEXT'] ):?>
	<div class="doctor-form">
		<?=$arResult['PROPERTIES']['FORM']['~VALUE']['TEXT']?>
	</div>
<?endif;?>

<script type='application/ld+json'> 
{
  "@context": "http://www.schema.org",
  "@type": "Physician",
  "name": "<?=$arResult['NAME']?>",
  "description": "<?php echo $arResult['PROPERTIES']['POSITION']['VALUE']['TEXT'];?>",
  "url": "https://<?=$_SERVER['HTTP_HOST'] . $APPLICATION->GetCurPageParam("", Array("CODE", "PARAMS", "search", "PAGEN_2") )?>",
  "logo": "https://<?=$_SERVER['HTTP_HOST']?>/local/templates/clin/assets/img/logo.svg",
  "image": "https://<?=$_SERVER['HTTP_HOST'] . $arResult['DETAIL_PICTURE']['SRC']?>",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "<?=getNumericalPhone($arResult['PROPERTIES']['PHONE']['VALUE']);?>"
  }
}
 </script>
