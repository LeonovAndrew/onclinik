<?php

namespace MWI;

/**
 * Class ProgramsTypes
 * @package MWI
 */
class ProgramsTypes implements TaggedCacheInterface
{
    public static function clearTaggedCache()
    {
        $tag = 'hlblock_table_' . ProgramsTypesTable::getTableName();
        clearCacheByTag($tag);
    }
}