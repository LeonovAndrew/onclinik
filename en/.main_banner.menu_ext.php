<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Direction;

$aMenuLinksExt = array();

$directionsList = Direction::getList(100, array('PROPERTY_SHOW_ON_MAIN' => true));
$directionsList->makeData();

foreach ($directionsList->getList() as $obDirection) {
    $aMenuLinksExt[] = array(
        $obDirection->name,
        $obDirection->url,
        array(),
        array(
            'departments' => $obDirection->departments,
        ),
        ''
    );
}



$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
