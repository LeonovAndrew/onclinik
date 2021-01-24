<?php
namespace MWI;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader;

/**
 * @var CBitrixComponent $this
 * @var array $arParams
 * @var array $arResult
 * @var string $componentPath
 * @var string $componentName
 * @var string $componentTemplate
 * @global CDatabase $DB
 * @global CUser $USER
 * @global CMain $APPLICATION
 */


$clinicsList = Clinic::getList(100);
$clinicsList->makeData();

$arFeatures = array();
$index = 0;

foreach ($clinicsList->getList() as $obClinic) {
    if (count($obClinic->coords) == 2) {
        $arFeatures[$index++] = array(
            'type' => 'Feature',
            'id' => $obClinic->id,
            'geometry' => array(
                'type' => 'Point',
                'coordinates' => $obClinic->coords,
            ),
            'properties' => array(
                'balloonContentHeader' => $obClinic->name,
                'hideIconOnBalloonOpen' =>  false
            ),
            'options' => array(
                'hideIconOnBalloonOpen' =>  false,
            ),
			'mapIcon' => $obClinic->mapIcon
        );
    }
}

$arResult['features'] = $arFeatures;

$this->IncludeComponentTemplate();
