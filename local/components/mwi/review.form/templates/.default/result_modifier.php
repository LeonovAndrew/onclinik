<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Clinic,
    MWI\ClinicList,
    MWI\Direction,
    MWI\DirectionList,
    MWI\Personal;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

$arResult['clinics'] = array();
$arResult['directions'] = array();
$arResult['hints_doctors'] = array();

$obDoctorsList = Personal::getDoctors();
foreach ($obDoctorsList->getList() as $obDoctor) {
    $arResult['hints_doctors'][] = $obDoctor->name;
}

$clinicsList = Clinic::getList(100);
$clinicsList->makeData();
$directionsList = new DirectionList();
$clinicSelected = false;
foreach ($clinicsList->getList() as $obClinic) {
    foreach ($obClinic->directionsId as $directionId) {
        $direction = new Direction($directionId);

        $directionsList->add($direction);
    }

    $arClinic = array(
        'id' => $obClinic->id,
        'name' => $obClinic->name,
    );
    if ($obClinic->id == $arParams['CLINIC_ID']) {
        $arClinic['selected'] = true;
        $clinicSelected = true;
    } else {
        $arClinic['selected'] = false;
    }
    $arResult['clinics'][] = $arClinic;
}
array_unshift(
    $arResult['clinics'],
    array(
        'id' => '',
        'name' => getMessage('choose_clinic'),
        'selected' => !$clinicSelected,
    )
);
$directionsList->makeData();

foreach ($directionsList->getList() as $obDirection) {
    $arResult['directions'][] = array(
        'id' => $obDirection->id,
        'name' => $obDirection->name,
        'selected' => false,
    );
}
array_unshift(
    $arResult['directions'],
    array(
        'id' => '',
        'name' => getMessage('choose_direction'),
        'selected' => true,
    )
);
