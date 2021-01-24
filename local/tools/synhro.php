<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$iblock_ru = 28;
$iblock_en = 63;

$iblock_prop_ru = 1;
$iblock_prop_en = 46;

$propCode = 'SERVICES';
	

$arNewID = Array();

$arFilter = Array(
	"IBLOCK_ID"=>$iblock_prop_en, 
);
$res = CIBlockElement::GetList(Array(), $arFilter, Array("ID", "PROPERTY_ru_id"));
while($ar_fields = $res->GetNext()){

	$arNewID[$ar_fields['PROPERTY_RU_ID_VALUE']] = $ar_fields['ID'];
}

echo "<pre>";
print_r( $arNewID );
echo "</pre>";

$arPropRu = Array();

$arFilter = Array(
	"IBLOCK_ID"=>$iblock_ru, 
	"!PROPERTY_" . $propCode => false
);
$res = CIBlockElement::GetList(Array(), $arFilter, Array("ID", "PROPERTY_ru_id", "PROPERTY_" . $propCode ));
while($ar_fields = $res->GetNext()){
	$propVal = $ar_fields['PROPERTY_'.$propCode.'_VALUE'];
	$arPropRu[$ar_fields['ID']][] = $arNewID[$propVal];;
}

echo "<pre>";
print_r( $arPropRu );
echo "</pre>";

$arNeeProp = Array();
	
$arFilter = Array(
	"IBLOCK_ID"=>$iblock_en 
);
$res = CIBlockElement::GetList(Array(), $arFilter, Array("ID", "PROPERTY_ru_id"));
while($ar_fields = $res->GetNext()){

	$oldID = $ar_fields['PROPERTY_RU_ID_VALUE'];
	$arNewProp[$ar_fields['ID']] = $arPropRu[$oldID];


}

echo "<pre>";
print_r( $arNewProp );
echo "</pre>";


foreach ( $arNewProp as $id => $prop ){
	$PROP = Array($propCode => $prop);
	CIBlockElement::SetPropertyValuesEx($id, $iblock_en, $PROP);
}


