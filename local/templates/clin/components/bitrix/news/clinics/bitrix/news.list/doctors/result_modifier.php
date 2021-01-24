<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Clinic,
    MWI\ClinicList;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

$obClinicsList = new ClinicList();
foreach ($arResult['ITEMS'] as $arItem) {
    /**
     * get clinics list
     */
    foreach ($arItem['PROPERTIES']['CLINICS']['VALUE'] as $clinicId) {
        $obClinic = new Clinic($clinicId);

        $obClinicsList->add($obClinic);
    }
}
/**
 * get info about clinics
 */
$obClinicsList->makeData();

foreach ($arResult['ITEMS'] as &$arItem) {
    /**
     * set clinics info
     */
	 
	if (!empty($arItem['PREVIEW_PICTURE']['SRC'])) {
		$pic = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>320, 'height'=>450), BX_RESIZE_IMAGE_PROPORTIONAL);
		$arItem['PREVIEW_PICTURE']['SRC'] = $pic['src'];			
	} 
	 
    $arClinics = array();
    foreach ($arItem['PROPERTIES']['CLINICS']['VALUE'] as $clinicId) {
        if ($obClinic = $obClinicsList->getById($clinicId)) {
            $arClinics[] = array(
                'name' => $obClinic->name,
            );
        }

        $arItem['clinics'] = $arClinics;
    }
}