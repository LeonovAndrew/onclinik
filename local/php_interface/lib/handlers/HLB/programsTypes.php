<?php
use \Bitrix\Main\EventManager as EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    '',
    'ProgramsTypesOnBeforeAdd',
    array(
        'MWI\ProgramsTypes',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'ProgramsTypesOnBeforeUpdate',
    array(
        'MWI\ProgramsTypes',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'ProgramsTypesOnBeforeDelete',
    array(
        'MWI\ProgramsTypes',
        'clearTaggedCache'
    )
);