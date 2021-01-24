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

foreach ($arResult['ITEMS'] as &$arItem) {
    /**
     * get pictures
     */
    $arPictures = array();
    $cnt = 0;

    if (!empty($arItem['PREVIEW_PICTURE'])) {
        $pic = new MWI\File($arItem['PREVIEW_PICTURE']['ID']);
        $alt = $arItem['PREVIEW_PICTURE']['ALT'] ? $arItem['PREVIEW_PICTURE']['ALT'] : $arItem['NAME'];
    } elseif (!empty($arItem['PROPERTIES']['ADDITIONAL_PICTURES']['VALUE'])) {
        $pic = new MWI\File(array_shift($arItem['PROPERTIES']['ADDITIONAL_PICTURES']['VALUE']));
        $alt = $arItem['NAME'];
    }
    if ($pic) {
        $arItem['PREVIEW_PICTURE'] = array(
            'SRC' => $pic->getSrc(),
            'ALT' => $alt,
            'PREVIEW' => array(
                'SRC' => $pic->resize('303', '417', 'BX_RESIZE_IMAGE_PROPORTIONAL'),
                'ALT' => $alt,
            )
        );
    }

    foreach ($arItem['PROPERTIES']['ADDITIONAL_PICTURES']['VALUE'] as $picId) {
        $pic = new MWI\File($picId);
        $arPictures[] = array(
            'SRC' => $pic->getSrc(),
            'ALT' => $arItem['NAME'],
            'PREVIEW' => array(
                'SRC' => $pic->resize('303', '417', 'BX_RESIZE_IMAGE_PROPORTIONAL'),
                'ALT' => $arItem['NAME'],
            )
        );
        $cnt++;
    }
    $arItem['ADDITIONAL_PICTURES'] = array(
        'ITEMS' => $arPictures,
    );
    $arItem['ADDITIONAL_PICTURES']['COUNT'] = ($cnt > 2) ? $cnt -= 2 : 0;
}