<?php


namespace MWI;


use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache,
    \CFile as CFile;

/**
 * Class ClinicList
 * @package MWI
 */
class ClinicList extends AbstractCollection
{
    /**
     * @var string ITEMS_CLASS
     */
    const ITEMS_CLASS = 'MWI\Clinic';

    /**
     * ClinicList constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ITEMS_CLASS);
    }

    /**
     * @description - make data from database for all items in collection.
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
            $cacheId = '/MWI/Clinic_' . 'Id=' . implode("-", $arIds);
            $cachePath = '/clinics/';

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
                    $this->arItems[$arItem['ID']]->url = $arItem['DETAIL_PAGE_URL'];
                    $this->arItems[$arItem['ID']]->previewText = $arItem['PREVIEW_TEXT'];
                    $this->arItems[$arItem['ID']]->previewPicture = $arItem['PREVIEW_PICTURE'];
                    $this->arItems[$arItem['ID']]->address = $arItem['ADDRESS'];
                    $this->arItems[$arItem['ID']]->metro = $arItem['METRO'];
                    $this->arItems[$arItem['ID']]->phone = $arItem['PHONE'];
					$this->arItems[$arItem['ID']]->mapIcon = $arItem['MAP_ICON'];
                    $this->arItems[$arItem['ID']]->directionsId = $arItem['DIRECTIONS'];
                    $this->arItems[$arItem['ID']]->coords = $arItem['COORDS'];
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
                $obTaggedCache->registerTag('iblock_id_' . Clinic::getIBlockId());
                $obTaggedCache->registerTag('iblock_id_' . ServiceOffer::getIBlockId());
                $obTaggedCache->registerTag('iblock_id_' . Service::getIBlockId());
                $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
                //TODO: check dependent tags for this cache
                $obTaggedCache->endTagCache();

                /**
                 * get data from database
                 */
                $obItems = CIBlockElement::getList(
                    array(),
                    array(
                        'IBLOCK_ID' => Clinic::getIBlockId(),
                        'ID' => $arIds,
                        'ACTIVE' => 'Y',
                    ),
                    false,
                    array(),
                    array(
                        'ID',
                        'NAME',
                        'DETAIL_PAGE_URL',
                        'PREVIEW_TEXT',
                        'PREVIEW_PICTURE',
                        'PROPERTY_ADDRESS',
                        'PROPERTY_METRO',
                        'PROPERTY_PHONE',
                        'PROPERTY_DIRECTIONS',
                        'PROPERTY_MAP',
						'PROPERTY_MAP_ICON',
                    )
                );
                $arItems = array();
                while ($arItem = $obItems->getNext()) {
                    $previewPicture = array(
                        'SRC' => $arItem['PREVIEW_PICTURE'] ? CFile::GetPath($arItem['PREVIEW_PICTURE']) : '',
                        'ALT' => $arItem['NAME'],
                    );
                    $directionsId = $arItem['PROPERTY_DIRECTIONS_VALUE'];
                    $arCoords = explode(',', $arItem['PROPERTY_MAP_VALUE'], 2);
                    /**
                     * set data for collection items
                     */
                    $this->arItems[$arItem['ID']]->name = $arItem['NAME'];
                    $this->arItems[$arItem['ID']]->url = $arItem['DETAIL_PAGE_URL'];
                    $this->arItems[$arItem['ID']]->previewText = $arItem['~PREVIEW_TEXT'];
                    $this->arItems[$arItem['ID']]->previewPicture = $previewPicture;
                    $this->arItems[$arItem['ID']]->address = $arItem['PROPERTY_ADDRESS_VALUE'];
                    $this->arItems[$arItem['ID']]->metro = $arItem['PROPERTY_METRO_VALUE'];
                    $this->arItems[$arItem['ID']]->phone = $arItem['PROPERTY_PHONE_VALUE'];
					$this->arItems[$arItem['ID']]->mapIcon = $arItem['PROPERTY_MAP_ICON_ENUM_ID'];
                    $this->arItems[$arItem['ID']]->directionsId = $directionsId;
                    $this->arItems[$arItem['ID']]->coords = $arCoords;

                    /**
                     * collect data for cache
                     */
                    $arItems[$arItem['ID']] = array(
                        'ID' => $arItem['ID'],
                        'NAME' => $arItem['NAME'],
                        'DETAIL_PAGE_URL' => $arItem['DETAIL_PAGE_URL'],
                        'PREVIEW_TEXT' => $arItem['~PREVIEW_TEXT'],
                        'PREVIEW_PICTURE' => $previewPicture,
                        'ADDRESS' => $arItem['PROPERTY_ADDRESS_VALUE'],
                        'METRO' => $arItem['PROPERTY_METRO_VALUE'],
                        'PHONE' => $arItem['PROPERTY_PHONE_VALUE'],
						'MAP_ICON' => $arItem['PROPERTY_MAP_ICON_ENUM_ID'],
                        'DIRECTIONS' => $directionsId,
                        'COORDS' => $arCoords,
                    );
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