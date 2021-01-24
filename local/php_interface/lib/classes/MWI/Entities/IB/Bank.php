<?php

namespace MWI;

/**
 * Class Bank
 * @package MWI
 */
class Bank implements IBEntityInterface
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
        'ru' => 27,
        'en' => 54,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'credit',
        'en' => 'credit_en',
    );

    public $id;
    public $name;

    /**
     * Bank constructor.
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