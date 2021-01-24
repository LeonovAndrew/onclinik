<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList();

$APPLICATION->AddChainItem(getMessage('CLINICS'), getMessage('CLINICS_URI'));
?>

<script>
    let paveRoute = <?php echo $getParams->getRaw('route') == 'Y' ? 'true' : 'false';?>;
</script>