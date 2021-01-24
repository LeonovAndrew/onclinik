<?php

namespace MWI;

/**
 * Class LawDocuments
 * @package MWI
 */
class LawDocuments implements IBEntityInterface
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
        'ru' => 18,
        'en' => 56,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'documents',
        'en' => 'documents_en',
    );

    public $id;
    public $name;

    /**
     * LawDocuments constructor.
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