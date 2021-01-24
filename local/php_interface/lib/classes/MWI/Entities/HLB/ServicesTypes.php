<?php

namespace MWI;

/**
 * Class ServicesTypes
 * @package MWI
 */
class ServicesTypes implements TaggedCacheInterface
{
    public static function clearTaggedCache()
    {
        $tag = 'hlblock_table_' . ServicesTypesTable::getTableName();
        clearCacheByTag($tag);
    }
}