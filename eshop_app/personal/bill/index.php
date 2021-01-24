<?
require($_SERVER["DOCUMENT_ROOT"]."/eshop_app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?><?$APPLICATION->IncludeComponent("bitrix:sale.personal.account", "mobile", array(
	),
	false
);?>
<?require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>