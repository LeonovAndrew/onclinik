<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Clinic,
    MWI\ClinicList,
    MWI\Personal,
    MWI\PersonalList;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

/**
 * pagination
 */
$arResult['NAV_STRING_BOTTOM'] = $arResult['NAV_RESULT']->GetPageNavStringEx(
    $arParams['PAGER_DESC_NUMBERING'],
    $arParams['PAGER_TITLE'],
    $arParams['PAGER_BOTTOM_TEMPLATE'] ? $arParams['PAGER_BOTTOM_TEMPLATE'] : $arParams['PAGER_TEMPLATE'],
    $arParams['PAGER_SHOW_ALWAYS'],
    $this->__component,
    $arResult['NAV_PARAM']
);

/**
 * get info about linked clinics and doctors
 */
$clinicsList = new ClinicList();
$doctorsList = new PersonalList();

foreach ($arResult['ITEMS'] as $arItem) {
    if (!empty($arItem['PROPERTIES']['CLINIC']['VALUE'])) {
        $clinic = new Clinic($arItem['PROPERTIES']['CLINIC']['VALUE']);
        $clinicsList->add($clinic);
    }

    if (!empty($arItem['PROPERTIES']['DOCTOR']['VALUE'])) {
        $doctor = new Personal($arItem['PROPERTIES']['DOCTOR']['VALUE']);
        $doctorsList->add($doctor);
    }
}

$clinicsList->makeData();
$doctorsList->makeData();

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['CLINIC'] = $clinicsList->getById($arItem['PROPERTIES']['CLINIC']['VALUE']);
    $arItem['DOCTOR'] = $doctorsList->getById($arItem['PROPERTIES']['DOCTOR']['VALUE']);
}
