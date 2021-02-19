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

<div class="clinic-title">
    <h1><?php $APPLICATION->ShowTitle(false);?></h1>
    <div class="clinic-title-btn">
        <a href="<?php echo getMessage('STOCKS_LINK') . '?clinicId=' . $arResult['ID'];?>" class="btn2"><?php echo getMessage('CLINIC_STOCKS');?></a>
        <a href="#" class="clinic-btn-print"></a>
    </div>
</div>
<div class="clinic-map-wrap">
    <div class="clinic-map-container">
        <div id="map"></div>
    </div>
    <div class="clinic-map-info">
        <div class="clinic-map-info-title">
            <h2><?php echo $arResult['NAME'];?></h2>
            <a href="#" id="pave-route"><?php echo getMessage('PAVE_ROUTE');?></a>
        </div>
        <?php
        if (!empty($arResult['PROPERTIES']['ADDRESS']['VALUE'])) {
            ?>
            <h3><?php echo $arResult['PROPERTIES']['ADDRESS']['VALUE'];?></h3>
            <?php
        }
        ?>
        <ul class="clinic-map-info-list1">
            <?php
            if (!empty($arResult['PROPERTIES']['METRO']['VALUE'])) {
                ?>
                <li class="clinic-map-info-item1 clinic-map-info-item11">
                    <?php echo $arResult['PROPERTIES']['METRO']['VALUE'];?>
                </li>
                <?php
            }

            if (!empty($arResult['PROPERTIES']['ADDRESS']['VALUE'])) {
                ?>
                <li class="clinic-map-info-item1 clinic-map-info-item12">
                    <span><?php echo getMessage('PHONE');?>:</span>
                    <a href="tel:<?php echo getNumericalPhone($arResult['PROPERTIES']['PHONE']['VALUE']);?>" onclick="gtag('event', 'form_submit', { 'event_category': 'form', 'event_action': 'Tel-Clinica', }); ym('2120464', 'reachGoal', 'Tel-Clinica'); return true;"><?php echo $arResult['PROPERTIES']['PHONE']['VALUE'];?></a>
                </li>
                <?php
            }

            if (!empty($arResult['PROPERTIES']['WORK_TIME']['VALUE'])) {
                ?>
                <li class="clinic-map-info-item1 clinic-map-info-item13">
                    <span><?php echo getMessage('SCHEDULE');?>: <i><?php echo $arResult['PROPERTIES']['WORK_TIME']['VALUE'];?></i></span>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php echo $arResult['PROPERTIES']['ADDITIONAL_INFO']['~VALUE']['TEXT'];?>

        <div class="clinic-map-info-btn-wrap">
            <?php
            //TODO: registration form
            ?>
									<?php
									$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										array(
											"AREA_FILE_RECURSIVE" => "Y",
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"PATH" => "/include/order_clinic.php"
										),
										false,
										array(
											'HIDE_ICONS' => 'Y'
										)
									);
									?>
        </div>
    </div>
</div>
<?php
if (!empty($arResult['HTG'])) {
    ?>
    <div class="clinic-text1">
        <div class="clinic-text1-title">
            <h2><?php echo getMessage('HOW_TO_GET');?>?</h2>
            <ul class="clinic-tab_list tab_list">
                <?php
                foreach ($arResult['HTG'] as $key => $arHTG) {
                    ?>
                    <li>
                        <a href="#clinic-tab-<?php echo $key;?>" class="clinic-tab-item clinic-tab-item1<?php echo $arHTG['selected'] ? ' active' : '';?>">
                            <span><?php echo $arHTG['name'];?></span>
                            <i>
                                <?php echo $arHTG['svg'];?>
                            </i>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
        foreach ($arResult['HTG'] as $key => $arHTG) {
            ?>
            <p class="htg-print"><?php echo $arHTG['name'] . ':';?></p><p<?php echo $arHTG['selected'] ? '' : ' style="display: none;"';?> class="block_content" id="clinic-tab-<?php echo $key;?>"><?php echo $arHTG['text'];?></p>
            <?php
        }
        ?>
    </div>
    <?php
}
?>

<?php
$this->setViewTarget('detail_text');
    if (!empty($arResult['~DETAIL_TEXT'])) {
        ?>
        <div class="clinic-text2 readmore">
            <div class="clinic-text2-wrap">
                <?php echo $arResult['~DETAIL_TEXT'];?>
            </div>
        </div>
        <?php
    }
$this->endViewTarget();
?>

<?php
$this->setViewTarget('photo');
    if (!empty($arResult['photo'])) {
        ?>
        <div class="clinic-photo-slider-wrap">
            <h2><?php echo getMessage('PHOTO_TITLE');?></h2>
            <div class="clinic-photo-slider">
                <div class="swiper-container swiper-container17">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($arResult['photo'] as $arPhoto) {
                            ?>
                            <div class="swiper-slide">
                                <img src="<?php echo $arPhoto['preview']['src'];?>" alt="<?php echo $arPhoto['preview']['alt'];?>">
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="swiper-button-next swiper-button-next17 swiper-button-next-style2"></div>
                <div class="swiper-button-prev swiper-button-prev17 swiper-button-prev-style2"></div>
            </div>
        </div>

        <div class="clinic-photo">
            <h2><?php echo getMessage('PHOTO_TITLE');?></h2>
            <div class="clinic-photo-main-container">
                <?php
                $firstPhoto = array_shift($arResult['photo']);
                ?>
                <a href="<?php echo $firstPhoto['detail']['src'];?>" class="clinic-photo-container1 fancybox" data-fancybox="gallery1">
                    <img src="<?php echo $firstPhoto['preview']['src'];?>" alt="<?php echo $firstPhoto['preview']['alt'];?>">
                </a>
                <div class="clinic-photo-container2">
                    <?php
                    $cnt = count($arResult['photo']);
                    $k = 0;
                    foreach ($arResult['photo'] as $arPhoto) {
                        $k++;

                        if ($k <= 3) {
                            ?>
                            <a href="<?php echo $arPhoto['detail']['src'];?>" class="clinic-photo-wrap clinic-photo-wrap<?php echo $k;?> fancybox" data-fancybox="gallery1">
                                <img src="<?php echo $arPhoto['preview']['src'];?>" alt="<?php echo $arPhoto['preview']['alt'];?>">
                                <?php
                                if (($k == 3) && ($cnt > $k)) {
                                    ?>
                                    <div class="clinic-photo-btn-wrap">
                                        <span class="btn4">+ <?php echo getMessage('MORE');?> <?php echo $cnt - $k;?></span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a style="display: none;" href="<?php echo $arPhoto['detail']['src'];?>" class="clinic-photo-wrap clinic-photo-wrap3 fancybox" data-fancybox="gallery1"></a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
$this->endViewTarget();
?>

<?php
$this->setViewTarget('tour');
    if (!empty($arResult['PROPERTIES']['TOUR']['~VALUE']['TEXT'])) {
        ?>
        <div class="clinic-tour">
            <div class="clinic-tour-img-wrap">
                <div class="clinic-tour-img">
                    <img src="<?php echo $this->GetFolder() . '/images/tour-img.jpg'; ?>" alt="3d тур">
                </div>
                <div class="clinic-tour-btn">
                    <a href="#" class="btn5 tour" data-id="<?php echo $arResult['ID'];?>"><?php echo getMessage('3d_tour');?></a>
                </div>
            </div>
        </div>
        <?php
    }
$this->endViewTarget();
?>

<script>
    let clinicCoords = [<?php echo $arResult['PROPERTIES']['MAP']['VALUE'];?>],
        clinicName = '<?php echo $arResult['NAME'];?>';
</script>

<script type='application/ld+json'> 
{
  "@context": "http://www.schema.org",
  "@type": "MedicalClinic",
  "name": "<?=$arResult['NAME']?>",
  "url": "https://<?=$_SERVER['HTTP_HOST'] . $APPLICATION->GetCurPageParam("", Array("CODE", "PARAMS", "search", "PAGEN_2") )?>",
  "logo": "https://<?=$_SERVER['HTTP_HOST']?>/local/templates/clin/assets/img/logo.svg",
  "image": "https://<?=$_SERVER['HTTP_HOST'] . $arResult['DETAIL_PICTURE']['SRC']?>",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "<?php echo $arResult['PROPERTIES']['ADDRESS']['VALUE'];?>",
    "addressLocality": "Москва"
  },
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "<?=getNumericalPhone($arResult['PROPERTIES']['PHONE']['VALUE']);?>"
  }
}
 </script>

