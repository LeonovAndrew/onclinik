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
 * get other news
 */
if (empty($arParams['OTHER_NEWS_COUNT'])) {
    $arParams['OTHER_NEWS_COUNT'] = 9;
}

$obEl = CIBlockElement::getList(
    array(
        "DATE_ACTIVE_FROM" => "DESC",
    ),
    array(
        "IBLOCK_ID" => $arResult['IBLOCK_ID'],
        "!ID" => $arResult['ID'],
        "!PREVIEW_PICTURE" => false,
        "ACTIVE" => "Y",
    ),
    false,
    array(
        "nTopCount" => $arParams['OTHER_NEWS_COUNT'],
    ),
    array(
        "ID",
        "NAME",
        "PREVIEW_TEXT",
        "PREVIEW_PICTURE",
        "DETAIL_PAGE_URL",
    )
);

$arNews = array();
while ($arEl = $obEl->getNext()) {
    $pic = new MWI\File($arEl['PREVIEW_PICTURE']);
    $arEl['PREVIEW_PICTURE'] = array(
        "SRC" => $pic->getSrc(),
        "ALT" => $arEl['NAME'],
    );

    $arNews[] = $arEl;
}

$arResult['OTHER_NEWS'] = $arNews;

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