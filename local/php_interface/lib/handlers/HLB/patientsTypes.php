<?php
use \Bitrix\Main\EventManager as EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    '',
    'PatientsTypesOnBeforeAdd',
    array(
        'MWI\PatientsTypes',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'PatientsTypesOnBeforeUpdate',
    array(
        'MWI\PatientsTypes',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'PatientsTypesOnBeforeDelete',
    array(
        'MWI\PatientsTypes',
        'clearTaggedCache'
    )
);