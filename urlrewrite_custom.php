<?php
$arCustomRoutes = [
    [
        'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
        'RULE'      => 'alias=$1',
        'ID'        => null,
        'PATH'      => '/desktop_app/router.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
        'RULE'      => 'componentName=$1',
        'ID'        => null,
        'PATH'      => '/bitrix/services/mobileapp/jn.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/communication/web-forms/#',
        'RULE'      => '',
        'ID'        => 'bitrix:form',
        'PATH'      => '/services_new/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/bitrix/services/ymarket/#',
        'RULE'      => '',
        'ID'        => '',
        'PATH'      => '/bitrix/services/ymarket/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/en/about/achievements/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/en/about/achievements/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/en/about/publications/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/en/about/publications/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/about/administration/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/about/administration/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/useful-information/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/useful-information/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/about/achievements/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/about/achievements/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/about/publications/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/about/publications/index.php',
        'SORT'      => 100,
    ],
	[
        'CONDITION' => '#^/about/partners/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/about/partners/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/online/(/?)([^/]*)#',
        'RULE'      => '',
        'ID'        => null,
        'PATH'      => '/desktop_app/router.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/stssync/calendar/#',
        'RULE'      => '',
        'ID'        => 'bitrix:stssync.server',
        'PATH'      => '/bitrix/services/stssync/calendar/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/payment/credit/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/payment/credit/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/about/news/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/about/news/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/about/jobs/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/about/jobs/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/en/doctor/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/en/doctor/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/doctors/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/doctors/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/actions/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/actions/index.php',
        'SORT'      => 100,
    ],
	[
        'CONDITION' => '#^/clinics/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/clinics/index.php',
        'SORT'      => 100,
    ],
	[
        'CONDITION' => '#^/en/clinics/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/en/clinics/index.php',
        'SORT'      => 100,
    ],
	[
        'CONDITION' => '#^/en/diseases/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/en/diseases/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/doctor/#',
        'RULE'      => '',
        'ID'        => 'bitrix:news',
        'PATH'      => '/doctor/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/rest/#',
        'RULE'      => '',
        'ID'        => null,
        'PATH'      => '/bitrix/services/rest/index.php',
        'SORT'      => 100,
    ],
	[
        'CONDITION' => '#^/en/([0-9a-zA-Z_-]+)/([0-9a-zA-Z_-]+)/#',
        'RULE'      => 'CODE=$1&PARAMS=$2',
        'ID'        => '',
        'PATH'      => '/en/router/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/en/([0-9a-zA-Z_-]+)/#',
        'RULE'      => 'CODE=$1',
        'ID'        => '',
        'PATH'      => '/en/router/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/([0-9a-zA-Z_-]+)/([0-9a-zA-Z_-]+)/#',
        'RULE'      => 'CODE=$1&PARAMS=$2',
        'ID'        => '',
        'PATH'      => '/router/index.php',
        'SORT'      => 100,
    ],
    [
        'CONDITION' => '#^/([0-9a-zA-Z_-]+)/#',
        'RULE'      => 'CODE=$1',
        'ID'        => '',
        'PATH'      => '/router/index.php',
        'SORT'      => 100,
    ],
	
];
