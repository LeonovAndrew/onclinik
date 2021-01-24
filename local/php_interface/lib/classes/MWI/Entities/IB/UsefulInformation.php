<?php

namespace MWI;

/**
 * Class UsefulInformation
 * @package MWI
 */
class UsefulInformation implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var int $id
     * @var string $name
     */
    const IBLOCK_ID = array(
        'ru' => 34,
        'en' => 67,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'content',
        'en' => 'content_en',
    );

    public $id;
    public $name;

    /**
     * UsefulInformation constructor.
     * @param $id
     */
    public function __construct($id)
    {
        if ($this->isValidId($id)) {
            $this->id = $id;
        }
    }

    /**
     * @description - get data from database
     */
    public function makeData()
    {
        // TODO: Implement makeData() method.
    }
}