<?php

namespace MWI;

/**
 * Class Publication
 * @package MWI
 */
class Publication implements IBEntityInterface
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
        'ru' => 6,
        'en' => 65,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'content',
        'en' => 'content_en',
    );

    public $id;
    public $name;

    /**
     * Publication constructor.
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