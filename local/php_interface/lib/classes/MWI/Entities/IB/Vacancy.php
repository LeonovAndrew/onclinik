<?php

namespace MWI;

/**
 * Class Vacancy
 * @package MWI
 */
class Vacancy implements IBEntityInterface
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
        'ru' => 24,
        'en' => 53,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'jobs',
        'en' => 'jobs_en',
    );

    public $id;
    public $name;

    /**
     * News constructor.
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