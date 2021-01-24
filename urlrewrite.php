<?php
$arUrlRewrite=array (
  0 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  34 => 
  array (
    'CONDITION' => '#^/video/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => 'bitrix:im.router',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  21 => 
  array (
    'CONDITION' => '#^/([0-9a-zA-Z_-]+)/([0-9a-zA-Z_-]+)/#',
    'RULE' => 'CODE=$1&PARAMS=$2',
    'ID' => '',
    'PATH' => '/router/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/about/partners/corporate-clients/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about/partners/corporate-clients/index.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/communication/web-forms/#',
    'RULE' => '',
    'ID' => 'bitrix:form',
    'PATH' => '/services_new/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/en/about/achievements/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/en/about/achievements/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/en/about/publications/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/en/about/publications/index.php',
    'SORT' => 100,
  ),
  35 => 
  array (
    'CONDITION' => '#^/about/achievements/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about/achievements/index.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/about/publications/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about/publications/index.php',
    'SORT' => 100,
  ),
  30 => 
  array (
    'CONDITION' => '#^/useful-information/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/useful-information/index.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  22 => 
  array (
    'CONDITION' => '#^/([0-9a-zA-Z_-]+)/#',
    'RULE' => 'CODE=$1',
    'ID' => '',
    'PATH' => '/router/index.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  29 => 
  array (
    'CONDITION' => '#^/payment/credit/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/payment/credit/index.php',
    'SORT' => 100,
  ),
  33 => 
  array (
    'CONDITION' => '#^/about/partners/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about/partners/index.php',
    'SORT' => 100,
  ),
  14 => 
  array (
    'CONDITION' => '#^/about/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about/news/index.php',
    'SORT' => 100,
  ),
  27 => 
  array (
    'CONDITION' => '#^/en/doctors/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/en/doctors/index.php',
    'SORT' => 100,
  ),
  32 => 
  array (
    'CONDITION' => '#^/about/jobs/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about/jobs/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/en/doctor/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/en/doctor/index.php',
    'SORT' => 100,
  ),
  37 => 
  array (
    'CONDITION' => '#^/actions/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/actions/index.php',
    'SORT' => 100,
  ),
  19 => 
  array (
    'CONDITION' => '#^/doctor/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/doctor/index.php',
    'SORT' => 100,
  ),
  20 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  36 => 
  array (
    'CONDITION' => '#^/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/doctors/index.php',
    'SORT' => 100,
  ),
);
