<?php

namespace MWI;


interface IBEntityInterface
{
    /**
     * @return int
     */
    public static function getIBlockId();

    /**
     * @return string
     */
    public static function getIBlockType();

    /**
     * @description Make data for entity from database.
     */
    public function makeData();
}