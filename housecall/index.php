<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "ММЦ ОН КЛИНИК - вызов врача на дом.");
$APPLICATION->SetPageProperty("title", "Вызвать врача на дом");

use MWI\HousecallApplication;

$APPLICATION->SetTitle("Правила первичного приема");
?>

<section class="housecall">
    <div class="container">
        <div class="housecall-container">
            <div class="housecall-wrap">
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_RECURSIVE" => "Y",
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "",
                        "PATH" => "/include/tools/breadcrumbs.php"
                    ),
                    false,
                    array(
                        'HIDE_ICONS' => 'Y'
                    )
                );
                ?>

                <h1><?php $APPLICATION->showTitle();?></h1>
                <div class="housecall-form-wrap1">
                    <?php
                    $APPLICATION->IncludeComponent(
                        'mwi:housecall.form',
                        '',
                        array(
                            'IBLOCK_ID' => HousecallApplication::getIBlockId(),
                            'EVENT_NAME' => 'HOUSECALL_FORM',
                            'SUCCESS_MSG' => 'Ваша заявка успешно отправлена!',
                        )
                    );
                    ?>
                </div>
                <div class="housecall-text">
                    <?php
                    $APPLICATION->IncludeFile(
                        SITE_DIR . "/include/housecall/text.php",
                        array(),
                        array(
                            "MODE" => "html",
                            "NAME" => "Описание раздела",
                        )
                    );
                    ?>
                </div>

                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_RECURSIVE" => "Y",
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "",
                        "PATH" => "/include/tools/breadcrumbs_mobile.php"
                    ),
                    false,
                    array(
                        'HIDE_ICONS' => 'Y'
                    )
                );
                ?>
            </div>
        </div>
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