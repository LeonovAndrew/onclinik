<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Direction,
    MWI\DirectionList;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

$arResult['directions'] = array();
$directionsList = Direction::getAll();
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
