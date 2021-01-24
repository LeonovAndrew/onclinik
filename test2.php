<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");



$arPrice = Array();


$arFilter = Array(
	"IBLOCK_ID"=>39, 
);
$res = CIBlockElement::GetList(Array(), $arFilter, Array("ID", "PROPERTY_SERVICE", "PROPERTY_PRICE", "PROPERTY_PRICEDET"));
while($ar_fields = $res->GetNext()){
	if ( $ar_fields['PROPERTY_PRICEDET_VALUE'] > 0 ){
		$arPrice[$ar_fields['PROPERTY_SERVICE_VALUE']] = $ar_fields['PROPERTY_PRICEDET_VALUE'];
	}
}



foreach ( $arPrice as $name => $price ){
			
	$arFilter = Array(
		"IBLOCK_ID"=>29, 
		"NAME" => $name
	);
	$res = CIBlockElement::GetList(Array(), $arFilter, Array("ID"));
	while($ar_fields = $res->GetNext()){

		
		$PROP = Array("PRICEDET" => $price );
		
		CIBlockElement::SetPropertyValuesEx($ar_fields['ID'], 29, $PROP);
	
	}
}