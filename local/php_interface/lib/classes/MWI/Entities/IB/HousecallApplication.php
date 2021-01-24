<?php

namespace MWI;

/**
 * Class HousecallApplication
 * @package MWI
 */
class HousecallApplication implements IBEntityInterface
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
        'ru' => 71,
        'en' => 71,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'applications',
        'en' => 'applications',
    );

    public $id;
    public $name;

    /**
     * HousecallApplication constructor.
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