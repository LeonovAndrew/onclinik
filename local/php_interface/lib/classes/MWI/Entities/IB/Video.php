<?php


namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache;

/**
 * Class Direction
 * @package MWI
 */
class Video implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var int $id
     * @var string $name
     * @var string $url
     */

    const IBLOCK_ID = array(
        'ru' => 35,
        'en' => 68,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'content',
        'en' => 'content_en',
    );

    public $id;
    public $name;
    public $url;

    /**
     * Video constructor.
     * @param $id
     */
    public function __construct($id)
    {
        if ($this->isValidId($id)) {
            $this->id = $id;
        }
    }

    /**
     * @description make data from database
     */
    public function makeData()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Video' . 'DId=' . $this->id;
        $cachePath = '/video/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arVideo = $vars['video'];
        } else {
            /**
             * start buffering the output
             */
            $obCache->startDataCache();

            /**
             * get data from database
             */
            $arVideo = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => self::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => $this->id,
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                    'DETAIL_PAGE_URL',
                )
            )->getNext();

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'video' => $arVideo,
                )
            );
        }

        /**
         * set data
         */
        $this->name = $arVideo['NAME'];
        $this->url = $arVideo['DETAIL_PAGE_URL'];
    }

    /**
     * @description Get all directions linked in videos
     * @return DirectionList
     */
    public static function getAllDirections()
    {
        Loader::includeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Videos_Directions';
        $cachePath = '/directions/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $directionsList = $vars['directions'];
        } else {
            /**
             * start buffering the output
             */
            $obCache->startDataCache();

            /**
             * add tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Video::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obDirections = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => Direction::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => CIBlockElement::SubQuery(
                        "PROPERTY_DIRECTION",
                        array(
                            'IBLOCK_ID' => Video::getIBlockId(),
                            'ACTIVE' => 'Y',
                        )
                    ),
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                )
            );
            $directionsList = new DirectionList();
            while ($arDirection = $obDirections->fetch()) {
                $obDirection = new Direction($arDirection['ID']);
                $obDirection->name = $arDirection['NAME'];

                $directionsList->add($obDirection);
            }
        }

        /**
         * write pre-buffered output to the cache file
         * with additional variables
         */
        $obCache->endDataCache(
            array(
                'directions' => $directionsList,
            )
        );

        return $directionsList;
    }
}