<?php
use \Bitrix\Main\EventManager as EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    '',
    'DepartmentsOnBeforeAdd',
    array(
        'MWI\Departments',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'DepartmentsOnBeforeUpdate',
    array(
        'MWI\Departments',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'DepartmentsOnBeforeDelete',
    array(
        'MWI\Departments',
        'clearTaggedCache'
    )
);