<?php

namespace MWI;

/**
 * Class ClinicsTypes
 * @package MWI
 */
class ClinicsTypes implements TaggedCacheInterface
{
    public static function clearTaggedCache()
    {
        $tag = 'hlblock_table_' . ClinicsTypesTable::getTableName();
        clearCacheByTag($tag);
    }
}