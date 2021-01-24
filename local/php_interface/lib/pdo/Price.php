<?php


namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CIBlockProperty as CIBlockProperty,
    \CPHPCache as CPHPCache,
    Bitrix\Iblock\PropertyTable;

/**
 * Class Price
 * @package MWI
 */
class Price implements IBEntityInterface
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
        'ru' => 39,
        'en' => 39,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'prices',
        'en' => 'prices',
    );

    public $id;
    public $name;
    public $url;

    /**
     * Price constructor.
     * @param $id
     */
    public function __construct($id)
    {
        if ($this->isValidId($id)) {
            $this->id = $id;
        }
    }
    public function getPropsID()
    {
        Loader::IncludeModule('iblock');
        $props = array();
        $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>self::IBLOCK_ID['ru']));
        while ($prop_fields = $properties->GetNext())
        {
            $props[$prop_fields["CODE"]] = $prop_fields["ID"];
        }
        return $props;
    }




    public function makeData()
    {
        Loader::IncludeModule('iblock');
    }

    /**
     * @return ServiceOfferList
     */

}