<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('highloadblock');



function GetEntityDataClass($HlBlockId) {
    if (empty($HlBlockId) || $HlBlockId < 1)
    {
        return false;
    }
    $hlblock = HLBT::getById($HlBlockId)->fetch();   
    $entity = HLBT::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    return $entity_data_class;
}

$iblockH_ru = 8;
$iblockH_en = 20;

$arHData_ru = Array();
$entity_data_class = GetEntityDataClass($iblockH_ru);
$rsData = $entity_data_class::getList(array(
   'select' => array('*')
));
while($el = $rsData->fetch()){
	$arHData_ru[$el['ID']] = $el['UF_XML_ID'];
}

$arHData_en = Array();
$entity_data_class = GetEntityDataClass($iblockH_en);
$rsData = $entity_data_class::getList(array(
   'select' => array('*')
));
while($el = $rsData->fetch()){
	$arHData_en[$arHData_ru[$el['ID']]] = $el['UF_XML_ID'];
}

	echo "<pre>";
	print_r( $arHData_en );
	echo "</pre>";



$iblock_ru = 28;
$iblock_en = 63;

$iblock_prop_ru = 2;
$iblock_prop_en = 43;

$propCode = 'CLIENTS_TYPE';
	



$arNeeProp = Array();
	
$arFilter = Array(
	"IBLOCK_ID"=>$iblock_en 
);
$res = CIBlockElement::GetList(Array(), $arFilter, Array("ID", "PROPERTY_ru_id", "PROPERTY_" . $propCode ));
while($ar_fields = $res->GetNext()){

	$arNewProp[$ar_fields['ID']][] = $arHData_en[$ar_fields['PROPERTY_'.$propCode.'_VALUE']];
	
	//echo "<pre>";
	//print_r( $ar_fields );
	//echo "</pre>";

}

	echo "<pre>";
	print_r( $arNewProp );
	echo "</pre>";



foreach ( $arNewProp as $id => $prop ){
	$PROP = Array($propCode => $prop);
	CIBlockElement::SetPropertyValuesEx($id, $iblock_en, $PROP);
}


