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

<h1><?php echo $arResult['NAME'];?></h1>
<?php /*echo $arResult['TEXT_REPLACED'];*/?>
<div class="certificates-text1">
    <p><?=$arResult["DETAIL_TEXT"];?></p>
    <div class="text-btn">
        <span>Показать еще</span> <span>Скрыть</span>
    </div>
</div>
<?if(count($arResult["PROPERTIES"]["PICTURES"]["VALUE"])>1):?>
<div class="certificates-list certificates-list1">
    <?foreach ($arResult["PROPERTIES"]["PICTURES"]["VALUE"] as $pic):?>
    <div class="certificates-item ajax-item">
        <?$URL = CFile::GetPath($pic);?>
        <!--<h3>Сертификат ООО «ОН Клиник Геоконик» 2018-19' (Клиническая химия)</h3>-->
        <div class="certificates-item-wrap">
            <a class="certificates-item-img1 fancybox" data-fancybox="galleryPic" href="<?=$URL?>">
                <img src="<?=$URL?>" alt="">
            </a>
            <div class="certificates-item-img-wrap">
            </div>
        </div>
    </div>
    <?endforeach;?>
</div>
<?endif;?>

<!--<pre>
    <?/*print_r($arResult["DETAIL_TEXT"]);*/?>
</pre>-->
