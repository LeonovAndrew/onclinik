<?php

namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache,
    \CFile as CFile;

/**
 * Class DoctorList
 * @package MWI
 */
class PersonalList extends AbstractCollection
{
    /**
     * @var string ITEMS_CLASS
     */
    const ITEMS_CLASS = 'MWI\Personal';

    /**
     * DoctorList constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ITEMS_CLASS);
    }

    /**
     *
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
            $cacheId = '/MWI/Doctor_' . 'Id=' . implode("-", $arIds) . '_SiteId=' . SITE_ID;
            $cachePath = '/doctors/';

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
                    $this->arItems[$arItem['ID']]->position = $arItem['POSITION'];
                    $this->arItems[$arItem['ID']]->previewPicture = $arItem['PREVIEW_PICTURE'];
                    $this->arItems[$arItem['ID']]->administrator = $arItem['ADMINISTRATOR'];
                    $this->arItems[$arItem['ID']]->doctor = $arItem['DOCTOR'];
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
                $obTaggedCache->registerTag('iblock_id_' . Personal::getIBlockId());
                //TODO: check dependent tags for this cache
                $obTaggedCache->endTagCache();

                /**
                 * get data from database
                 */
                $obItems = CIBlockElement::getList(
                    array(),
                    array(
                        'IBLOCK_ID' => Personal::getIBlockId(),
                        'ID' => $arIds,
                        'ACTIVE' => 'Y',
                    ),
                    false,
                    array(),
                    array(
                        'ID',
                        'NAME',
                        'DETAIL_PAGE_URL',
                        'PREVIEW_PICTURE',
                        'PROPERTY_POSITION',
                        'PROPERTY_ADMINISTRATOR',
                        'PROPERTY_DOCTOR',
                    )
                );
                $arItems = array();
                while ($arItem = $obItems->getNext()) {
				
					if ( $arItem['PREVIEW_PICTURE'] )
						$pic = File::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>285, 'height'=>380), BX_RESIZE_IMAGE_PROPORTIONAL);
				
                    $previewPicture = array(
                        'SRC' => $arItem['PREVIEW_PICTURE'] ? CFile::GetPath($arItem['PREVIEW_PICTURE']) : '',
                        'SMALL_SRC' => $arItem['PREVIEW_PICTURE'] ? $pic['src'] : '',
						'ALT' => $arItem['NAME'],
                    );
                    /**
                     * set data for collection items
                     */
                    $this->arItems[$arItem['ID']]->name = $arItem['NAME'];
                    $this->arItems[$arItem['ID']]->url = $arItem['DETAIL_PAGE_URL'];
                    $this->arItems[$arItem['ID']]->position = $arItem['PROPERTY_POSITION_VALUE']['TEXT'];
                    $this->arItems[$arItem['ID']]->previewPicture = $previewPicture;
                    $this->arItems[$arItem['ID']]->administrator = $arItem['PROPERTY_ADMINISTRATOR_VALUE'];
                    $this->arItems[$arItem['ID']]->doctor = $arItem['PROPERTY_DOCTOR_VALUE'];

                    /**
                     * collect data for cache
                     */
                    $arItems[$arItem['ID']] = array(
                        'ID' => $arItem['ID'],
                        'NAME' => $arItem['NAME'],
                        'DETAIL_PAGE_URL' => $arItem['DETAIL_PAGE_URL'],
                        'POSITION' => $arItem['PROPERTY_POSITION_VALUE']['TEXT'],
                        'PREVIEW_PICTURE' => $previewPicture,
                        'ADMINISTRATOR' => $arItem['PROPERTY_ADMINISTRATOR_VALUE'],
                        'DOCTOR' => $arItem['PROPERTY_DOCTOR_VALUE'],
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