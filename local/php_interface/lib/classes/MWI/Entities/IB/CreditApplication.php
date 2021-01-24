<?php

namespace MWI;

/**
 * Class CreditApplication
 * @package MWI
 */
class CreditApplication implements IBEntityInterface
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
        'ru' => 38,
        'en' => 38,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'applications',
        'en' => 'applications',
    );

    public $id;
    public $name;

    /**
     * CreditApplication constructor.
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