<?php

namespace MWI;

/**
 * Class Advantage
 * @package MWI
 */
class Advantage implements IBEntityInterface
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
        'ru' => 40,
        'en' => 69,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'content',
        'en' => 'content_en',
    );

    public $id;
    public $name;

    /**
     * Advantage constructor.
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