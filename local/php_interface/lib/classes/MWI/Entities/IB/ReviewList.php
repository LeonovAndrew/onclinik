<?php

namespace MWI;

/**
 * Class ReviewList
 * @package MWI
 */
class ReviewList extends AbstractCollection
{
    /**
     * @var string ITEMS_CLASS
     */
    const ITEMS_CLASS = 'MWI\Review';

    /**
     * ReviewList constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ITEMS_CLASS);
    }
}