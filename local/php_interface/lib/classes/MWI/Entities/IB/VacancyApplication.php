<?php

namespace MWI;

/**
 * Class VacancyApplication
 * @package MWI
 */
class VacancyApplication implements IBEntityInterface
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
        'ru' => 37,
        'en' => 37,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'applications',
        'en' => 'applications',
    );

    public $id;
    public $name;

    /**
     * VacancyApplication constructor.
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