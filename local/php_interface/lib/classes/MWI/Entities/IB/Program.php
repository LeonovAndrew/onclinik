<?php


namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache;

/**
 * Class Program
 * @package MWI
 */
class Program implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var int $id
     */
    const IBLOCK_ID = array(
        'ru' => 32,
        'en' => 44,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'catalog',
        'en' => 'catalog_en',
    );

    public $id;
    public $name;
    public $price;
    public $discountPrice;

    /**
     * Program constructor.
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

    }

    /**
     *
     */
    public function makeDiscountPrice()
    {
        //TODO: programs discount
        $discountPrice = $this->price;

        $this->discountPrice = ($discountPrice >= 0) ? $discountPrice : $this->price;
    }

    /**
     * @description get list of all programs
     * @return ProgramList
     */
    public static function getList()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Programs';
        $cachePath = '/programs/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obProgramsList = $vars['programs'];
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
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->endTagCache();

            $obProgramsList = new ProgramList();
            /**
             * get data from database
             */
            $obPrograms = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => self::getIBlockId(),
                    'ACTIVE' => 'Y',
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                )
            );
            while ($arProgram = $obPrograms->fetch()) {
                $obProgram = new self($arProgram['ID']);
                $obProgram->name = $arProgram['NAME'];

                $obProgramsList->add($obProgram);
            }

            $obCache->endDataCache(
                array(
                    'programs' => $obProgramsList,
                )
            );
        }

        return $obProgramsList;
    }
}