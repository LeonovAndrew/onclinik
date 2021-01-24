<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Direction;

$aMenuLinksExt = array();

$directionsList = Direction::getMenu(100);
//$directionsList->makeData();

foreach ($directionsList as $obDirection) {
    $aMenuLinksExt[] = array(
        $obDirection['NAME'],
        $obDirection['URL'],
        array(),
        array(
            //'departments' => $obDirection->departments,
			'BLANK' => $obDirection['BLANK']
        ),
        ''
    );
}



$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
