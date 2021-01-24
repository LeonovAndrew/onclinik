<?php
function _Check404Error()
{
    if (defined('ERROR_404') && ERROR_404 == 'Y') {
        global $APPLICATION;

        $APPLICATION->RestartBuffer();
        CHTTP::SetStatus('404 Not Found');
        include($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php');
        include($_SERVER['DOCUMENT_ROOT'] . '/404.php');
        include($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php');
    }
}