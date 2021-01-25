<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Personal;

/**
 * @var $arParams
 * @var $arResult
 */

$obDoctor = new Personal($arResult['ID']);

/**
 * get clinics
 */
$obClinics = $obDoctor->getClinics();
$arResult['CLINICS'] = $obClinics->getList();

/**
 * get certificates
 */
$arCertificates = array();
foreach ($arResult['PROPERTIES']['CERTIFICATES']['VALUE'] as $key => $certificateId) {
    $arCertificates[] = array(
        'PICTURE' => array(
            'PREVIEW' => array(
                'SRC' => CFile::resizeImageGet(
                    $certificateId,
                    array(
                        'width' => 378,
                        'height' => 269,
                    ),
                    'BX_RESIZE_IMAGE_EXACT'
                )['src'],
                'ALT' => $arResult['NAME'],
            ),
            'DETAIL' => array(
                'SRC' => CFile::getPath($certificateId),
                'ALT' => $arResult['NAME'],
            ),
        ),
        'DESCRIPTION' => $arResult['PROPERTIES']['CERTIFICATES']['~DESCRIPTION'][$key],
    );
}
$arResult['CERTIFICATES'] = $arCertificates;

/**
 * prices & offers
 */
$obOffers = $obDoctor->getOffers();

if (!empty($arResult['PROPERTIES']['PRICE']['VALUE']) && $arResult['PROPERTIES']['PRICE']['VALUE']) {
    
	$arResult['PRICES'] = array(
        'price' => $arResult['PROPERTIES']['PRICE']['VALUE'],
        'discount_price' => $arResult['PROPERTIES']['PRICE']['VALUE'],
		'simple' => 'Y'
    );
} else {
    if (!$obOffers->isEmpty()) {
        $arResult['PRICES'] = $obOffers->getMinimumPrice();
    }
}

$arResult['OFFERS'] = $obOffers->getList();



