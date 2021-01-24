<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application,
    MWI\Direction,
    MWI\Service;
	
	global $arDirectionsFilter;
	$arDirectionsFilter = unserialize( $_POST['arDirectionsFilter'] );
	
                            $APPLICATION->IncludeComponent(
                                "bitrix:news.list",
                                "directions",
                                array(
                                    "IBLOCK_TYPE" => Direction::getIBlockType(),
                                    "IBLOCK_ID" => Direction::getIBlockId(),
                                    "NEWS_COUNT" => 24,
									"IS_AJAX" => "Y",
                                    "SORT_BY1" => 'SORT',
                                    "SORT_ORDER1" => 'ASC',
                                    "FIELD_CODE" => array(
                                        'ID',
                                        'NAME',
                                        'DETAIL_PAGE_URL',
                                    ),
                                    "PROPERTY_CODE" => array(

                                    ),
                                    "SET_TITLE" => "N",
                                    "SET_LAST_MODIFIED" => "N",
                                    "SET_STATUS_404" => "N",
                                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                    "ADD_SECTIONS_CHAIN" => "N",
                                    "CACHE_TYPE" => "A",
                                    "CACHE_TIME" => "3600000",
                                    "CACHE_FILTER" => "Y",
                                    "CACHE_GROUPS" => "Y",
                                    "FILTER_NAME" => 'arDirectionsFilter',
                                ),
                                false
                            );
                            ?>