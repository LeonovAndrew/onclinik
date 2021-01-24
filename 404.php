<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/lib/urlrewrite_custom.php');



CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");
$APPLICATION->SetPageProperty("title", "404 Not Found");

?>

<section class="page404">
	<div class="container">

		<div class="img">
			<img src="/upload/404.jpg">
		</div>
		<div class="title">
			Страница не найдена
		</div>
		<p>
			Вы неправильно ввели адрес страницы или страница<br> по этому адресу не существует.
		</p>
		<p>
			<a href="/" class="js-appointment-btn btn1">На главную</a>
		</p>
		<p>
			<a href="/sitemap/" class="map_link">Карта сайта</a>	
		</p>

	</div>
</section>
	
<?require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>