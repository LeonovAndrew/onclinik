<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

if ($arParams['DISPLAY_TOP_PAGER'] == 'Y') {
    $arResult['NAV_STRING_TOP'] = $arResult['NAV_RESULT']->GetPageNavStringEx(
        $arParams['PAGER_DESC_NUMBERING'],
        $arParams['PAGER_TITLE'],
        $arParams['PAGER_TEMPLATE_TOP'] ? $arParams['PAGER_TEMPLATE_TOP'] : $arParams['PAGER_TEMPLATE'],
        $arParams['PAGER_SHOW_ALWAYS'],
        $this->__component,
        $arResult['NAV_PARAM']
    );
}