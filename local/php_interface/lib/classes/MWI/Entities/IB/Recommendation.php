<?php

namespace MWI;

/**
 * Class Recommendation
 * @package MWI
 */
class Recommendation implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var int $id
     * @var string $name
     * @var Personal $doctor
     * @var string $text
     */
    const IBLOCK_ID = array(
        'ru' => 36,
        'en' => 49,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'FAQ',
        'en' => 'FAQ_en',
    );

    public $id;
    public $name;
    public $doctor;
    public $text;

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