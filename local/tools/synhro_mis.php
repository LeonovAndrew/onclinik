<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$iblock_ru = 29;
$iblock_en = 39;


$arFilter = Array(
	"IBLOCK_ID"=>$iblock_ru, 
);
$res = CIBlockElement::GetList(Array(), $arFilter, Array("ID", "PROPERTY_MIS_CODE"));
$arServices = Array();
while($ar_fields = $res->GetNext()){
	$arServices[ $ar_fields['PROPERTY_MIS_CODE_VALUE'] ] = $ar_fields['ID'];
}

	echo "<pre>";
	print_r( $arServices );
	echo "</pre>";	

$arFilter = Array(
	"IBLOCK_ID"=>$iblock_en, 
);
$res = CIBlockElement::GetList(Array(), $arFilter, Array("ID", "NAME", "PROPERTY_CODE", "PROPERTY_GROUP", "PROPERTY_SPEC"));
while($ar_fields = $res->GetNext()){
	if ( $arServices[$ar_fields['PROPERTY_CODE_VALUE']] ){
	
		$id = $arServices[$ar_fields['PROPERTY_CODE_VALUE']];
		
		$PROP = Array(
			'GROUP' => $ar_fields['PROPERTY_GROUP_VALUE'],
			'SPEC' => $ar_fields['PROPERTY_SPEC_VALUE']
		);
		CIBlockElement::SetPropertyValuesEx($id, $iblock_ru, $PROP);

	}
	
}

exit();

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


