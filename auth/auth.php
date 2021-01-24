<?//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
?>

<?
global $USER, $APPLICATION;

//$APPLICATION->AuthForm('Необходимо авторизоваться');
$APPLICATION->IncludeComponent(
	"bitrix:main.auth.form",
	"",
	Array(
		"AUTH_FORGOT_PASSWORD_URL" => "",
		"AUTH_REGISTER_URL" => "",
		"AUTH_SUCCESS_URL" => "/bitrix/"
	)
);?>