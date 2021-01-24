<?php
use \Bitrix\Main\EventManager as EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    '',
    'ServicesTypesOnBeforeAdd',
    array(
        'MWI\ServicesTypes',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'ServicesTypesOnBeforeUpdate',
    array(
        'MWI\ServicesTypes',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'ServicesTypesOnBeforeDelete',
    array(
        'MWI\ServicesTypes',
        'clearTaggedCache'
    )
);