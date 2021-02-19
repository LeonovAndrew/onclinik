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

/**
 * get clinics
 */
$obClinics = new ClinicList();
foreach ($arResult['ITEMS'] as $arItem) {
    foreach ($arItem['PROPERTIES']['CLINICS']['VALUE'] as $clinicId) {
        $obClinic = new Clinic($clinicId);

        $obClinics->add($obClinic);
    }
}
$obClinics->makeData();

foreach ($arResult['ITEMS'] as &$arItem) {
    foreach ($arItem['PROPERTIES']['CLINICS']['VALUE'] as $clinicId) {
        $obClinic = $obClinics->getById($clinicId);
        $arItem['CLINICS'][$clinicId] = array(
            'NAME' => $obClinic->name,
        );
    }
}
