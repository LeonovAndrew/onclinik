<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Content;

/**
 * @var $arParams
 * @var $arResult
 */

/**
 * get documents
 */
$arDocs = array();
if (!empty($arResult['PROPERTIES']['DOCUMENTS']['VALUE'])) {
    foreach ($arResult['PROPERTIES']['DOCUMENTS']['VALUE'] as $key => $docId) {
        if ($docId) {
            $doc = new MWI\File($docId);
            $arDocs[] = array(
                'SRC' => $doc->getSrc(),
                'TYPE' => $doc->getType(),
                'NAME' => $doc->getName(),
                'SIZE' => $doc->getSize(),
            );
        }
    }
    $arResult['DOCUMENTS'] = $arDocs;
}

/**
 * get pictures
 */
$arPictures = array();
if (!empty($arResult['PROPERTIES']['PICTURES']['VALUE'])) {
    if (!empty($arResult['DETAIL_PICTURE'])) {
        $pic = new MWI\File($arResult['DETAIL_PICTURE']['ID']);
        $arPictures[] = array(
            'SRC' => $pic->resize(489, 360, 'BX_RESIZE_IMAGE_EXACT'),
            'ALT' => $arResult['DETAIL_PICTURE']['ALT'] ? $arResult['DETAIL_PICTURE']['ALT'] : $arResult['NAME'],
        );
    }

    foreach ($arResult['PROPERTIES']['PICTURES']['VALUE'] as $pic) {
        $pic = new MWI\File($pic);
        $arPictures[] = array(
            'SRC' => $pic->resize(489, 360, 'BX_RESIZE_IMAGE_EXACT'),
            'ALT' => $arResult['NAME'],
        );
    }
    $arResult['PICTURES'] = $arPictures;
}

if (!empty($arResult['PROPERTIES']['VIDEO_PREVIEW']['VALUE'])) {
    $arResult['PROPERTIES']['VIDEO_PREVIEW']['SRC'] = CFile::GetPath($arResult['PROPERTIES']['VIDEO_PREVIEW']['VALUE']);
}

$detailText = $arResult['~DETAIL_TEXT'];
$arVideo = array(
    'SRC' => $arResult['PROPERTIES']['VIDEO']['VALUE'],
    'PREVIEW_SRC' => $arResult['PROPERTIES']['VIDEO_PREVIEW']['SRC']
);
Content::replaceImgTile('#IMG#', $detailText, $arResult['PICTURES']);
Content::replaceImgSlider('#SLIDER#', $detailText, $arResult['PICTURES']);
Content::replaceFile('#FILE#', $detailText, $arResult['DOCUMENTS']);
Content::replaceVideo('#VIDEO#', $detailText, $arVideo);
$arResult['TEXT_REPLACED'] = $detailText;