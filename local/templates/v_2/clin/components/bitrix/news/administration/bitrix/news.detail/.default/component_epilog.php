<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->AddChainItem(getMessage('ABOUT'), getMessage('ABOUT_URI'));
$APPLICATION->AddChainItem(getMessage('ADMINISTRATION'), getMessage('ADMINISTRATION_URI'));