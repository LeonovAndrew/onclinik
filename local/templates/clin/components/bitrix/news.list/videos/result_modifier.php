<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */
 
foreach ($arResult['ITEMS'] as $key => $arItem) {

	$arYoutube = explode('/', $arItem['PROPERTIES']['LINK']['VALUE']);
	$videoID = end($arYoutube);
	
	if ( !$arItem['DETAIL_PICTURE']['SRC'] && strpos($arItem['PROPERTIES']['LINK']['VALUE'], 'youtu') ) {
		
		$arResult['ITEMS'][$key]['DETAIL_PICTURE']['SRC'] = '//img.youtube.com/vi/'. $videoID .'/0.jpg';
	
		if ( strpos($arItem['PROPERTIES']['LINK']['VALUE'], 'youtu.be') ){
			
			$arResult['ITEMS'][$key]['PROPERTIES']['LINK']['VALUE'] = 'https://www.youtube.com/embed/' . $videoID;
		}
		
	}
}
