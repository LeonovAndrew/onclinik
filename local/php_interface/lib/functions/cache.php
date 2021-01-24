<?php

use Bitrix\Main\Application as Application;

/**
 * @description - clear cache by $tag
 * @param string $tag
 */
function clearCacheByTag($tag)
{
    $obTaggedCache = Application::getInstance()->getTaggedCache();
    $obTaggedCache->clearByTag($tag);
}


/**
 * @param CBitrixComponent $obComp
 * @param array $arTags Array of strings
 */
function addTagsToComponentCache($obComp, $arTags)
{
    if (defined('BX_COMP_MANAGED_CACHE') && is_object($GLOBALS['CACHE_MANAGER'])) {
        if (strlen($obComp->getCachePath())) {
            foreach ($arTags as $tag) {
                $GLOBALS['CACHE_MANAGER']->RegisterTag($tag);
            }
        }
    }
}