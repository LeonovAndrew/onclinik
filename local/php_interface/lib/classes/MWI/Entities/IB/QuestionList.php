<?php

namespace MWI;

/**
 * Class QuestionList
 * @package MWI
 */
class QuestionList extends AbstractCollection
{
    /**
     * @var string ITEMS_CLASS
     */
    const ITEMS_CLASS = 'MWI\Question';

    /**
     * QuestionList constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ITEMS_CLASS);
    }
}