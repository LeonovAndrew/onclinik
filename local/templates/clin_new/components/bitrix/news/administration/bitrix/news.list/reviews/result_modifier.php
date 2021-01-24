<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Clinic,
    MWI\ClinicList,
    MWI\Personal;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

/**
 * get clinics info
 */
$obClinicsList = new ClinicList();
foreach ($arResult['ITEMS'] as $arItem) {
    if (!empty($arItem['PROPERTIES']['CLINIC'])) {
        $obClinic = new Clinic($arItem['PROPERTIES']['CLINIC']);
        $obClinicsList->add($obClinic);
    }
}
$obClinicsList->makeData();

/**
 * update clinics info
 */
foreach ($arResult['ITEMS'] as &$arItem) {
    if (!empty($arItem['PROPERTIES']['CLINIC']['VALUE'])) {
        $obClinic = $obClinicsList->getById($arItem['PROPERTIES']['CLINIC']['VALUE']);
        $arItem['CLINIC'] = array(
            'NAME' => $obClinic->name,
        );
    }
}

/**
 * all reviews link
 */
if (!empty($arParams['DOCTOR_ID'])) {
    $obPersonal = new Personal($arParams['DOCTOR_ID']);
    $obPersonal->makeData();
    $arResult['doctor'] = $obPersonal;
}
