<?php

namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache;

/**
 * Class RecommendationList
 * @package MWI
 */
class RecommendationList extends AbstractCollection
{
    /**
     * @var string ITEMS_CLASS
     */
    const ITEMS_CLASS = 'MWI\Recommendation';

    /**
     * QuestionList constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ITEMS_CLASS);
    }

    /**
     * @description - make data for all items in collection.
     */
    public function makeData()
    {
        Loader::IncludeModule('iblock');

        if (!$this->isEmpty()) {
            /**
             * get id's
             */
            $arIds = $this->getIds();
            sort($arIds);

            /**
             * cache params
             */
            $cacheTtl = 360000;
            $obCache = new CPHPCache();
            $cacheId = '/MWI/Recommendations_' . 'Id=' . implode("-", $arIds);
            $cachePath = '/recommendations/';

            if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
                /**
                 * cache is exist
                 */

                /**
                 * get data from cache
                 */
                $vars = $obCache->GetVars();
                $arItems = $vars['items'];

                /**
                 * set data for collection items
                 */
                foreach ($arItems as $arItem) {
                    $this->arItems[$arItem['ID']]->name = $arItem['NAME'];
                    $this->arItems[$arItem['ID']]->doctor = $arItem['DOCTOR'];
                    $this->arItems[$arItem['ID']]->text = $arItem['TEXT'];
                }
            } else {
                /**
                 * start buffering the output
                 */
                $obCache->startDataCache();

                /**
                 * register tags for cache
                 */
                $obTaggedCache = Application::getInstance()->getTaggedCache();
                $obTaggedCache->startTagCache($cachePath);
                $obTaggedCache->registerTag('iblock_id_' . Recommendation::getIBlockId());
                $obTaggedCache->registerTag('iblock_id_' . Personal::getIBlockId());
                //TODO: check dependent tags for this cache
                $obTaggedCache->endTagCache();

                /**
                 * get data from database
                 */

                /**
                 * get services
                 */
                $obItems = CIBlockElement::getList(
                    array(),
                    array(
                        'IBLOCK_ID' => Recommendation::getIBlockId(),
                        'ID' => $arIds,
                        'ACTIVE' => 'Y',
                    ),
                    false,
                    array(),
                    array(
                        'ID',
                        'NAME',
                        'PREVIEW_TEXT',
                        'PROPERTY_DOCTOR',
                    )
                );

                $arItems = array();
                while ($arItem = $obItems->fetch()) {
				
				
					if ( $arItem['PROPERTY_DOCTOR_VALUE'] ){
						$obDoctor = new Personal($arItem['PROPERTY_DOCTOR_VALUE']);
						$obDoctor->makeData();
						$obDoctor->makeUrl();
						
						$this->arItems[$arItem['ID']]->doctor = $obDoctor;
						$this->arItems[$arItem['ID']]->name = $arItem['NAME'];
						$this->arItems[$arItem['ID']]->text = $arItem['PREVIEW_TEXT'];
						$arItems[$arItem['ID']] = array(
							'ID' => $arItem['ID'],
							'NAME' => $arItem['NAME'],
							'DOCTOR' => $obDoctor,
							'TEXT' => $arItem['PREVIEW_TEXT'],
						);	
					}
					else {
						$this->arItems[$arItem['ID']]->name = $arItem['NAME'];
						$this->arItems[$arItem['ID']]->text = $arItem['PREVIEW_TEXT'];
						$arItems[$arItem['ID']] = array(
							'ID' => $arItem['ID'],
							'NAME' => $arItem['NAME'],
							'DOCTOR' => "",
							'TEXT' => $arItem['PREVIEW_TEXT'],
						);	
					}
					
                    
                }

                /**
                 * write pre-buffered output to the cache file
                 * with additional variables
                 */
                $obCache->endDataCache(
                    array(
                        'items' => $arItems,
                    )
                );
            }
        }
    }
}