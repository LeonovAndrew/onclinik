<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Карта сайта");
?>

<section class="costsection">
    <div class="container">
        <?$APPLICATION->IncludeComponent(
            'bitrix:main.map',
            'sitemapn',
            array(
                'LEVEL' => '3',
                'COL_NUM' => '1',
                'SHOW_DESCRIPTION' => 'N',
                'SET_TITLE' => 'N',
                'CACHE_TYPE' => 'A',
                'CACHE_TIME' => '3600',
            )
        );?>
    </div>
</section>


<?php
$APPLICATION->IncludeFile(
    SITE_DIR . "/include/map.php",
    array(),
    array(
        "MODE" => "html",
        "NAME" => "Карта клиник",
    )
);
?>

<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>