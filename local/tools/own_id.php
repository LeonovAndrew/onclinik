<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$iblock_id = 28;
		
$arFilter = Array(
	"IBLOCK_ID"=>$iblock_id 
);
$res = CIBlockElement::GetList(Array(), $arFilter, Array("ID"));
while($ar_fields = $res->GetNext()){

	$PROP = Array("ru_id" => $ar_fields['ID']);
	CIBlockElement::SetPropertyValuesEx($ar_fields['ID'], $iblock_id, $PROP);
}

