<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use MWI\Dbconnect;
use MWI\Price;

CModule::IncludeModule("iblock");
$iblock_prices_id = Price::getIBlockId();
$props = Price::getPropsID();
$db = Dbconnect::getConnection();
$stmt = $db->prepare("EXEC load_price_MWI");
$stmt->execute();
$pricesarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($pricesarray);

if ($count >= ($_POST['id']+1)):
    if ($_POST['id'] > 0):
        $pricesarray = array_slice($pricesarray, $_POST['id']);
    endif;
    foreach ($pricesarray as $k => $price):
        $el = new CIBlockElement;
        $PROP = array();
        $PROP[$props['CODE']] = trim($price['Код']);
        $PROP[$props['SERVICE']] = trim($price['Услуга']);
        $PROP[$props['PRICE']] = trim($price['Цена']);
        $PROP[$props['PRICEDET']] = trim($price['ЦенаДет']);
        $PROP[$props['GROUPCODE']] = trim($price['КодГруппы']);
        $PROP[$props['GROUP']] = trim($price['Группа']);
        $PROP[$props['SPECCODE']] = trim($price['КодСпециализация']);
        $PROP[$props['SPEC']] = trim($price['Специализация']);

        $arLoadProductArray = Array(
            "MODIFIED_BY" => $USER->GetID(),
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => $iblock_prices_id,
            "PROPERTY_VALUES" => $PROP,
            "NAME" => $price['Код'],
            "ACTIVE" => "Y",
        );

        if ($PRODUCT_ID = $el->Add($arLoadProductArray)):

        else:
            echo "Error: " . $el->LAST_ERROR;
        endif;

        if ($k == 1999 || $k >= $count): break; endif;
    endforeach;
    if ($k == ($count-1) || $k == $count || $k > $count):
        echo 'Выгрузка окончена';
    else:
        echo(($k+1) + $_POST['id']);
    endif;
else:
    echo 'Выгрузка окончена';
endif;
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>