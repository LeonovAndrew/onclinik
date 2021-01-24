<?php

namespace MWI;

/**
 * Class StockList
 * @package MWI
 */
class StockList extends AbstractCollection
{
    /**
     * @var string ITEMS_CLASS
     */
    const ITEMS_CLASS = 'MWI\Stock';

    /**
     * StockList constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ITEMS_CLASS);
    }

    /**
     * @description - make data for all items in collection.
     */
    public function makeData()
    {
        // TODO: Implement makeData() method.
    }
}