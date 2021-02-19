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

/**
 * how to get
 */
$arHTG = array();
$first = true;
/**
 * by car
 */
if (!empty($arResult['PROPERTIES']['HTG_CAR']['~VALUE']['TEXT'])) {
    $arHTG[] = array(
        'name' => getMessage('HTG_CAR'),
        'text' => $arResult['PROPERTIES']['HTG_CAR']['~VALUE']['TEXT'],
        'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14"><g><g><g><path fill="#0a9beb" d="M15.316 10.326a1.476 1.476 0 1 1 0-2.951 1.476 1.476 0 0 1 0 2.95zM2.756 8.85a1.475 1.475 0 1 1 2.95 0 1.475 1.475 0 0 1-2.95 0zM5 2.44c1.915-1.264 7.615-1.264 9.529 0 .372.245.85 1.235 1.289 2.446H3.71c.438-1.21.916-2.2 1.288-2.445zm14.417 1.836a.502.502 0 0 0-.388-.184h-1.9c-.47-1.237-1.08-2.45-1.775-2.907-2.402-1.58-8.775-1.58-11.177 0-.695.458-1.304 1.672-1.775 2.907H.5a.498.498 0 0 0-.49.601l.281 1.364a.5.5 0 0 0 .49.399h.563a3.376 3.376 0 0 0-.81 2.206C.53 9.638.9 10.52 1.578 11.144l.022.018v1.908c0 .414.336.75.75.75h1.753a.75.75 0 0 0 .75-.75v-.767h9.82v.767c0 .414.336.75.75.75h1.753c.413 0 .75-.336.75-.75V11.2c.72-.66 1.063-1.565 1.067-2.47a3.368 3.368 0 0 0-.848-2.275h.6a.498.498 0 0 0 .49-.4l.282-1.363a.504.504 0 0 0-.102-.416z"/></g></g></g></svg>',
        'selected' => $first,
    );
    $first = false;
}
/**
 * by foot
 */
if (!empty($arResult['PROPERTIES']['HTG_FOOT']['~VALUE']['TEXT'])) {
    $arHTG[] = array(
        'name' => getMessage('HTG_FOOT'),
        'text' => $arResult['PROPERTIES']['HTG_FOOT']['~VALUE']['TEXT'],
        'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="11" height="20" viewBox="0 0 11 20"><g><g><g><path fill="#0a9beb" d="M5.265 3.228a1.505 1.505 0 0 0 1.104-.51c.297-.325.439-.707.424-1.146A1.611 1.611 0 0 0 6.305.447 1.463 1.463 0 0 0 5.18 0a1.505 1.505 0 0 0-1.104.51 1.646 1.646 0 0 0-.446 1.146c0 .439.163.814.488 1.125.326.312.708.46 1.147.446z"/></g><g><path fill="#0a9beb" d="M10.636 8.6L8.301 7.328 6.39 4.269c-.368-.453-.821-.679-1.359-.679-.368 0-.722.156-1.062.467l-2.887 2.93a.934.934 0 0 0-.17.382L.53 10.64v.085c0 .198.07.368.212.51a.695.695 0 0 0 .51.212c.198 0 .36-.071.488-.213a.916.916 0 0 0 .234-.467l.297-2.802 1.02-1.02-.935 7.814L.7 18.452c-.057.17-.085.325-.085.467 0 .311.106.573.318.786a.938.938 0 0 0 .786.276c.425 0 .736-.199.934-.595l1.784-3.991c0-.029.014-.078.042-.149.028-.07.057-.135.085-.191a.377.377 0 0 0 .042-.17l.213-1.91 1.826 6.284c.198.51.552.75 1.061.722.283 0 .531-.106.743-.319.213-.212.319-.474.319-.785a.347.347 0 0 0-.021-.106.35.35 0 0 1-.022-.107L6.178 9.96l.297-2.845.722 1.147a.758.758 0 0 0 .212.212l2.505 1.401c.17.057.283.085.34.085a.665.665 0 0 0 .51-.233.768.768 0 0 0 .212-.53.665.665 0 0 0-.34-.595z"/></g></g></g></svg>',
        'selected' => $first,
    );
    $first = false;
}
/**
 * by public
 */
if (!empty($arResult['PROPERTIES']['HTG_PUBLIC']['~VALUE']['TEXT'])) {
    $arHTG[] = array(
        'name' => getMessage('HTG_PUBLIC'),
        'text' => $arResult['PROPERTIES']['HTG_PUBLIC']['~VALUE']['TEXT'],
        'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><g><g><path fill="#0a9beb" d="M18 0c1.105 0 2 1 2 2.104v14a2 2 0 0 1-2 2v1c0 .552-.448.896-1 .896h-2c-.552 0-1-.344-1-.896V18H6v1.104c0 .552-.448.896-1 .896H3c-.552 0-1-.344-1-.896v-1a2 2 0 0 1-2-2v-14C0 1 .895 0 2 0zm-2 16.104a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-12 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zM18 10V3.104C18 2.552 17.552 2 17 2H3c-.552 0-1 .552-1 1.104V10z"/></g></g></svg>',
        'selected' => $first,
    );
    $first = false;
}

$arResult['HTG'] = $arHTG;


/**
 * photo
 */
$arResult['photo'] = array();
foreach ($arResult['PROPERTIES']['PHOTO']['VALUE'] as $photoId) {
    $arResult['photo'][] = array(
        'preview' => array(
            'src' => CFile::getPath($photoId),
            'alt' => $arResult['name'],
        ),
        'detail' => array(
            'src' => CFile::getPath($photoId),
            'alt' => $arResult['name'],
        )
    );
}

