<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Web\Uri;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

$arTechParams = [
    'PAGEN_' . $arResult['NavNum'],
    'ajax',
    'ajax_filter',
];

$arResult['sUrlPathParams'] = new Uri(html_entity_decode($arResult['sUrlPathParams']));
$arResult['sUrlPathParams'] = $arResult['sUrlPathParams']->deleteParams([
                                              'ajax',
                                              'ajax_filter',
                                          ])->getPathQuery();

$arResult['pages'] = [];

$nPageWindow = 5; //количество отображаемых страниц
if ($arResult["NavPageNomer"] > floor($nPageWindow / 2) + 1 && $arResult["NavPageCount"] > $nPageWindow) {
    $nStartPage = $arResult["NavPageNomer"] - floor($nPageWindow / 2);
} else {
    $nStartPage = 1;
}

if ($arResult["NavPageNomer"] <= $arResult["NavPageCount"] - floor($nPageWindow / 2) && $nStartPage + $nPageWindow - 1 <= $arResult["NavPageCount"]) {
    $nEndPage = $nStartPage + $nPageWindow - 1;
} else {
    $nEndPage = $arResult["NavPageCount"];
    if ($nEndPage - $nPageWindow + 1 >= 1) {
        $nStartPage = $nEndPage - $nPageWindow + 1;
    }
}

$arResult["nStartPage"] = $nStartPage;
$arResult["nEndPage"] = $nEndPage;

if ($arResult['nStartPage'] > 1) {
    $uri = new Uri($arResult['sUrlPathParams']);
    array_push(
        $arResult['pages'],
        [
            'value'  => '1',
            'uri'    => $uri->getUri(),
            'active' => false,
        ]
    );

    if ($arResult['nStartPage'] > 2) {
        $uri = new Uri($arResult['sUrlPathParams']);
        $uri->addParams([
                            'PAGEN_' . $arResult['NavNum'] => round($arResult['nStartPage'] / 2),
                        ]
        );
        array_push(
            $arResult['pages'],
            [
                'value'  => '...',
                'uri'    => $uri->getUri(),
                'active' => false,
            ]
        );
    }
}

do {
    $uri = new Uri($arResult['sUrlPathParams']);
    if ($arResult['nStartPage'] != 1) {
        $uri->addParams([
                            'PAGEN_' . $arResult['NavNum'] => $arResult['nStartPage'],
                        ]
        );
    }
    $arResult['pages'][] = [
        'value'  => $arResult['nStartPage'],
        'uri'    => $uri->getUri(),
        'active' => $arResult['nStartPage'] == $arResult['NavPageNomer'],
    ];
    $arResult["nStartPage"]++;
} while ($arResult["nStartPage"] <= $arResult["nEndPage"]);

if ($arResult['nEndPage'] < $arResult['NavPageCount']) {
    if ($arResult['nEndPage'] < $arResult['NavPageCount'] - 1) {
        $uri = new Uri($arResult['sUrlPathParams']);
        $uri->addParams([
                            'PAGEN_' . $arResult['NavNum'] => round($arResult['nEndPage'] + ($arResult['NavPageCount'] - $arResult['nEndPage']) / 2),
                        ]
        );
        array_push(
            $arResult['pages'],
            [
                'value'  => '...',
                'uri'    => $uri->getUri(),
                'active' => false,
            ]
        );
    }

    $uri = new Uri($arResult['sUrlPathParams']);
    $uri->addParams([
                        'PAGEN_' . $arResult['NavNum'] => $arResult['NavPageCount'],
                    ]
    );
    array_push(
        $arResult['pages'],
        [
            'value'  => $arResult['NavPageCount'],
            'uri'    => $uri->getUri(),
            'active' => false,
        ]
    );
}

/**
 * preview
 */
$prevUri = new Uri($arResult['sUrlPathParams']);
if ($arResult['NavPageNomer'] - 1 != 1) {
    $prevUri->addParams([
                            'PAGEN_' . $arResult['NavNum'] => $arResult['NavPageNomer'] - 1,
                        ]
    );
}
$arResult['prev_uri'] = $prevUri->getUri();

/**
 * next
 */
$nextUri = new Uri($arResult['sUrlPathParams']);
$nextUri->addParams([
                        'PAGEN_' . $arResult['NavNum'] => $arResult['NavPageNomer'] + 1,
                    ]
);
$arResult['next_uri'] = $nextUri->getUri();
