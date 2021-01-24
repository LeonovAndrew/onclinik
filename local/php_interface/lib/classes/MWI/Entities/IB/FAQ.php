<?php

namespace MWI;

/**
 * Class FAQ
 * @package MWI
 */
class FAQ implements IBEntityInterface
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
        'ru' => 33,
        'en' => 50,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'FAQ',
        'en' => 'FAQ_en',
    );

    public $id;
    public $name;

    /**
     * FAQ constructor.
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