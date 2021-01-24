<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "ММЦ ОН КЛИНИК: кредит на лечение и обследование. Где взять кредит или рассрочку в Москве на выгодных условиях.");
$APPLICATION->SetPageProperty("title", "Лечение в кредит или рассрочку");

$APPLICATION->SetTitle("Лечение в кредит");
?>

<script src="//api.b2pos.ru/shop/connect.js" charset="utf-8" type="text/javascript"></script>
<script>
var accessID = "82670";
var productsList = new Array();
productsList[0] = { id: 'Введите артикул товара', name: 'Название товара', category: 'Бренд и модель товара', price: 'Стоимость товара', count: 'Количество товара цифрой' };

function issueApplicationPosCreditOpen() {
    poscreditServices('creditProcess', accessID, { order: 'Номер заказа в вашем магазине, возможно передавать всегда одинаковое значение', products: productsList, phone: '' }, function(result){
          if(result.success === false){
               alert('Произошла ошибка при попытке оформить кредит. Попробуйте позднее...');
          }
    });
}
</script>

<input type="button" value="Оформить в кредит" onclick="issueApplicationPosCreditOpen()" />

<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>