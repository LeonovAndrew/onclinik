<?php
/**
 * @param string $response
 * @return bool
 */
function isValidCaptcha($response)
{
    $captcha = $response;
    $ip = $_SERVER['REMOTE_ADDR'];
    $key = RECAPTCHA_SECRET_KEY;
    $recaptcha_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $key . '&response=' . $captcha . '&remoteip=' . $ip);
    $data = json_decode($recaptcha_response);

    return $data->success === true;
}