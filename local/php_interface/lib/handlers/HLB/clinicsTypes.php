<?php
use \Bitrix\Main\EventManager as EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    '',
    'ClinicsTypesOnBeforeAdd',
    array(
        'MWI\ClinicsTypes',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'ClinicsTypesOnBeforeUpdate',
    array(
        'MWI\ClinicsTypes',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'ClinicsTypesOnBeforeDelete',
    array(
        'MWI\ClinicsTypes',
        'clearTaggedCache'
    )
);