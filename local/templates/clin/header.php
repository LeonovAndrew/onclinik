<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

global $USER;

$curLang = MWI\Lang::getCurrent();
$curVersion = MWI\Version::update();
$isVisually = MWI\Version::isVisually();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?$APPLICATION->ShowTitle();?></title>
		<link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/assets/img/favicon/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/assets/img/favicon/fav72.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?=SITE_TEMPLATE_PATH?>/assets/img/favicon/fav72.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?=SITE_TEMPLATE_PATH?>/assets/img/favicon/fav114.png">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" <?php echo !empty($curVersion['viewport']) ? $curVersion['viewport'] : 'content="width=device-width, initial-scale=1, maximum-scale=1"';?>>
		<meta name = "format-detection" content = "telephone=no">
		<meta name="robots" content="index, follow"/>	
		
				

		<?//$APPLICATION->ShowHead();?>

        <meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CHARSET;?>" />
        <?php
        $APPLICATION->ShowMeta("description");
        $APPLICATION->ShowCSS();
        if ($USER->IsAdmin()) {
            $APPLICATION->ShowHeadStrings();
        }
		if ($APPLICATION->GetCurPage(false) !== '/'){
			\Bitrix\Main\Page\Asset::getInstance()->addString('<link rel="canonical" href="https://' . $_SERVER['HTTP_HOST'] . $APPLICATION->GetCurPageParam("", Array("CODE", "PARAMS", "search", "PAGEN_2") ) . '" />');
        }
		?>

		<!-- Подключение файлов стилей -->
		<?php
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/libs/swiper/swiper.css");
		Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/libs/jQueryFormStylerMaster/jquery.formstyler.css");
		Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/libs/fancybox/jquery.fancybox.css");
		Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/normalize.css");
		Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/fonts.css");
		Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/main.css");

        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/autocomplete.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/custom.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/print.css');

        //version styles
        foreach ($curVersion['css'] as $cssName) {
            Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/" . $cssName . ".css");
        }
		?>
        		
        <!-- Подключение скриптов -->
        <?php
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/libs/jquery/jquery-3.4.1.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/libs/swiper/swiper.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/libs/jQueryFormStylerMaster/jquery.formstyler.min.js');
        //Asset::getInstance()->addJs('https://api-maps.yandex.ru/2.1/?apikey=870293a8-8ba5-4fd8-9948-dbc7ed29b9a7&lang=ru_RU');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/libs/jquery.countdown/jquery.countdown.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/libs/mask/jquery.inputmask.bundle.min.js');
        Asset::getInstance()->addJs('//cdn.gbooking.ru/widget/js/gb_loader.js');
        //Asset::getInstance()->addJs('https://www.google.com/recaptcha/api.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/libs/fancybox/jquery.fancybox.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/map.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/preloader.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/common.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/lang.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/search.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/version.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/counter.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/readmore.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/FormErrors.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/recaptcha.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/filter.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/autocomplete.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/script.js');
        ?>
		<script type="text/javascript">
			var gbookingWidgetSetup = {
			  preload: false,
			  networkId: '235',
			};
		</script>
		<?if(strpos($_SERVER['HTTP_USER_AGENT'],'Chrome-Lighthouse') === false):?>
		<? $APPLICATION->IncludeFile("/counters.php") ?>
		<?endif;?>
		<script>
			window.addEventListener('message', function (event) {
			   'use strict';
			   var data = event.data;
			   try {
				   var messageEvent = JSON.parse(data);
				   console.log(
					   'Message  received  event  "' + messageEvent.name + '":', messageEvent.data
				   );
				   switch (messageEvent.name) {
						case 'service.select':
							dataLayer.push({event: "gbookingFormComplete"});
							gtag('event','gbookingFormComplete',{'event_category':'service.group', 'event_action':'select'});
							ym(2120464,'reachGoal','vibor_uslugi_click');
						break;
						case 'business.select':
							dataLayer.push({event: "gbookingFormComplete"});
							gtag('event','gbookingFormComplete',{'event_category':'business', 'event_action':'select'});
							ym(2120464,'reachGoal','address-zapis-click');
						break;
						case 'resource.select':
							dataLayer.push({event: "gbookingFormComplete"});
							gtag('event','gbookingFormComplete',{'event_category':'service', 'event_action':'select'});
							ym(2120464,'reachGoal','vibor_priem_click');
						break;
						case 'appointment.confirm':
							gtag('event','Submit',{'event_category':'AppointmentForm'});
							ym(2120464,'reachGoal','Appointment-Form-Submit');
						break;
				   }
			   }
			   catch (e) {
				   //console.error('Error  on  message  data  parsing:', e);
			   }
			});
	</script>
	</head>
	<body class="<?php echo implode(' ', $curVersion['classes']); if (defined('BODY_CLASS')) { echo ' ' . BODY_CLASS; };?>">

		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>

		<div class="site-wrap">

		<header class="main-header">
			<div class="container">
				<div class="main-header-container">
					<div class="main-header-wrap1">
						<div class="main-header-link1">
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu",
								"top_small",
								Array(
									"ALLOW_MULTI_SELECT" => "N",
									"CHILD_MENU_TYPE" => "left",
									"DELAY" => "N",
									"MAX_LEVEL" => "1",
									"MENU_CACHE_GET_VARS" => array(""),
									"MENU_CACHE_TIME" => "3600",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"ROOT_MENU_TYPE" => "top_small",
									"USE_EXT" => "N"
								)
							);?>
						</div>
                        <form action="<?php echo getMessage('search_link');?>" class="main-header-form-search">
                            <input type="search" name="q" placeholder="<?php echo getMessage('search_placeholder');?>">
                            <button type="submit">Найти</button>
                        </form>
						<div class="main-header-link-wrap">
							<ul class="main-header-link-list<?php echo $isVisually ? '' : ' small';?>">
								<li class="main-header-link-item main-header-link-item-1">
									<a href="<?php echo getMessage('about_center_link');?>"><?php echo getMessage('about_center');?></a>
								</li>
								<li class="main-header-link-item main-header-link-item-2">
                                    <a href="<?php echo getMessage('video_link');?>"><?php echo getMessage('video');?></a>
								</li>
                                <li class="main-header-link-item main-header-link-item-3">
                                    <button class="open_visually<?php echo $isVisually ? ' active' : '';?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12">
                                            <g>
                                                <g>
                                                    <path d="M13.357 9.075a8.262 8.262 0 0 1-4.362 1.22 8.26 8.26 0 0 1-4.362-1.22c-1.341-.813-2.457-1.906-3.347-3.28C2.303 4.216 3.578 3.034 5.11 2.25a4.392 4.392 0 0 0-.612 2.26c0 1.239.44 2.298 1.32 3.18.88.88 1.939 1.32 3.177 1.32s2.297-.44 3.177-1.32c.88-.881 1.32-1.941 1.32-3.18 0-.81-.204-1.564-.612-2.26 1.532.783 2.807 1.965 3.824 3.546-.89 1.373-2.006 2.466-3.347 3.28zM6.843 2.353a2.93 2.93 0 0 1 2.148-.897c.134 0 .247.047.34.14.094.094.141.208.141.341a.464.464 0 0 1-.14.34.463.463 0 0 1-.34.141c-.575 0-1.066.204-1.473.611a2.007 2.007 0 0 0-.61 1.472.464.464 0 0 1-.141.341.463.463 0 0 1-.34.14.464.464 0 0 1-.341-.14.464.464 0 0 1-.14-.34c0-.835.298-1.551.896-2.15zm10.956 2.75a10.728 10.728 0 0 0-3.782-3.697C12.434.476 10.761.01 9 .01c-1.761 0-3.434.465-5.017 1.396A10.725 10.725 0 0 0 .2 5.103 1.39 1.39 0 0 0 0 5.796c0 .228.067.459.2.693a10.723 10.723 0 0 0 3.783 3.696c1.583.931 3.256 1.396 5.017 1.396 1.761 0 3.434-.463 5.017-1.39A10.657 10.657 0 0 0 17.8 6.488c.134-.234.201-.465.201-.693a1.39 1.39 0 0 0-.2-.693z"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </button>

                                    <div class="box_flex">
                                        <?php
                                        $APPLICATION->IncludeComponent(
                                            'bitrix:menu',
                                            'colors',
                                            array(
                                                'COMPONENT_TEMPLATE' => 'colors',
                                                'ROOT_MENU_TYPE' => 'colors',
                                                'MENU_CACHE_TYPE' => 'A',
                                                'MENU_CACHE_TIME' => '3600',
                                                'MENU_CACHE_USE_GROUPS' => 'Y',
                                                'MENU_CACHE_GET_VARS' => '',
                                                'MAX_LEVEL' => '1',
                                                'CHILD_MENU_TYPE' => '',
                                                'USE_EXT' => 'Y',
                                                'DELAY' => 'N',
                                                'ALLOW_MULTI_SELECT' => 'N',
                                                'CUR_COLOR' => $curVersion['color'],
                                            ),
											false,
											array(
												'HIDE_ICONS' => 'Y',
											)
                                        );

                                        $APPLICATION->IncludeComponent(
                                            'bitrix:menu',
                                            'sizes',
                                            array(
                                                'COMPONENT_TEMPLATE' => 'sizes',
                                                'ROOT_MENU_TYPE' => 'sizes',
                                                'MENU_CACHE_TYPE' => 'A',
                                                'MENU_CACHE_TIME' => '3600',
                                                'MENU_CACHE_USE_GROUPS' => 'Y',
                                                'MENU_CACHE_GET_VARS' => '',
                                                'MAX_LEVEL' => '1',
                                                'CHILD_MENU_TYPE' => '',
                                                'USE_EXT' => 'Y',
                                                'DELAY' => 'N',
                                                'ALLOW_MULTI_SELECT' => 'N',
                                                'CUR_SIZE' => $curVersion['size'],
                                            ),
											false,
											array(
												'HIDE_ICONS' => 'Y',
											)
                                        );
                                        ?>
                                    </div>
                                </li>
								<li class="main-header-link-item main-header-link-item-5">
									<a href="javascript:void(0)" class="langChange" data-id="<?php echo $curLang['ID'];?>"><?php echo $curLang['NAME'];?></a>
								</li>
								<li class="main-header-link-item main-header-link-item-6">
									<a href="tel:+74952232222" onclick="gtag('event', 'form_submit', { 'event_category': 'form', 'event_action': 'Tel-Header', }); ym('2120464', 'reachGoal', 'Tel-Header'); return true;">+7 495 223-22-22</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="main-header-wrap2">
						<a href="/" class="main-header-logo">
							<img src="<?=SITE_TEMPLATE_PATH?>/assets/img/logo.svg" alt="">
						</a>
						<div class="main-header-feedback-wrap">
							<div class="main-header-feedback">
								<div class="main-header-tel-wrap">
									<a href="tel:+74952232222">+7 495 223-22-22</a>
									<b>с 8:00 до 23:00</b>
								</div>
								<div class="main-header-btn-wrap">
									<?php
									$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										array(
											"AREA_FILE_RECURSIVE" => "Y",
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"PATH" => "/include/order_button.php"
										),
										false,
										array(
											'HIDE_ICONS' => 'Y'
										)
									);
									?>
								</div>
							</div>
						</div>
					</div>

					<div class="main-header-wrap3">
						<div class="main-header-menuToggle">Меню</div>
						<form action="<?php echo getMessage('search_link');?>" class="main-header-form-search">
							<input type="search" name="q" placeholder="<?php echo getMessage('search_placeholder');?>">
							<button type="submit">Найти</button>
						</form>
						<nav class="main-header-nav">
							<ul class="main-header-list">
                                <li class="submenu-wrap">
                                    <?php
                                    $APPLICATION->IncludeComponent(
                                        'bitrix:menu',
                                        'top_section',
                                        array(
                                            'COMPONENT_TEMPLATE' => 'top_section',
                                            'ROOT_MENU_TYPE' => 'top_sec5',
                                            'MENU_CACHE_TYPE' => 'A',
                                            'MENU_CACHE_TIME' => '3600',
                                            'MENU_CACHE_USE_GROUPS' => 'Y',
                                            'MENU_CACHE_GET_VARS' => '',
                                            'MAX_LEVEL' => '1',
                                            'CHILD_MENU_TYPE' => '',
                                            'USE_EXT' => 'Y',
                                            'DELAY' => 'N',
                                            'ALLOW_MULTI_SELECT' => 'N',
                                            'TITLE' => getMessage('top_menu_sec5_title'),
                                            'ALL_TITLE' => getMessage('top_menu_sec5_all_title'),
                                            'ALL_LINK' => getMessage('top_menu_sec5_all_link'),
                                        )
                                    );
                                    ?>
                                </li>
								  <li class="submenu-wrap">
                                    <?php
                                    $APPLICATION->IncludeComponent(
                                        'bitrix:menu',
                                        'top_section',
                                        array(
                                            'COMPONENT_TEMPLATE' => 'top_section',
                                            'ROOT_MENU_TYPE' => 'top_sec3',
                                            'MENU_CACHE_TYPE' => 'A',
                                            'MENU_CACHE_TIME' => '3600',
                                            'MENU_CACHE_USE_GROUPS' => 'Y',
                                            'MENU_CACHE_GET_VARS' => '',
                                            'MAX_LEVEL' => '1',
                                            'CHILD_MENU_TYPE' => '',
                                            'USE_EXT' => 'Y',
                                            'DELAY' => 'N',
                                            'ALLOW_MULTI_SELECT' => 'N',
                                            'TITLE' => getMessage('top_menu_sec3_title'),
                                            'ALL_TITLE' => getMessage('top_menu_sec3_all_title'),
                                            'ALL_LINK' => getMessage('top_menu_sec3_all_link'),
                                        )
                                    );
                                    ?>
                                </li>
								<li class="submenu-wrap">
                                    <?php
                                    $APPLICATION->IncludeComponent(
                                        'bitrix:menu',
                                        'top_section',
                                        array(
                                            'COMPONENT_TEMPLATE' => 'top_section',
                                            'ROOT_MENU_TYPE' => 'top_sec1',
                                            'MENU_CACHE_TYPE' => 'A',
                                            'MENU_CACHE_TIME' => '3600',
                                            'MENU_CACHE_USE_GROUPS' => 'Y',
                                            'MENU_CACHE_GET_VARS' => '',
                                            'MAX_LEVEL' => '1',
                                            'CHILD_MENU_TYPE' => '',
                                            'USE_EXT' => 'Y',
                                            'DELAY' => 'N',
                                            'ALLOW_MULTI_SELECT' => 'N',
                                            'TITLE' => getMessage('top_menu_sec1_title'),
                                            'ALL_TITLE' => getMessage('top_menu_sec1_all_title'),
                                            'ALL_LINK' => getMessage('top_menu_sec1_all_link'),
                                        )
                                    );
                                    ?>
                                </li>
                                <li class="submenu-wrap">
                                    <?php
                                    $APPLICATION->IncludeComponent(
                                        'bitrix:menu',
                                        'top_section',
                                        array(
                                            'COMPONENT_TEMPLATE' => 'top_section',
                                            'ROOT_MENU_TYPE' => 'top_sec2',
                                            'MENU_CACHE_TYPE' => 'A',
                                            'MENU_CACHE_TIME' => '3600',
                                            'MENU_CACHE_USE_GROUPS' => 'Y',
                                            'MENU_CACHE_GET_VARS' => '',
                                            'MAX_LEVEL' => '1',
                                            'CHILD_MENU_TYPE' => '',
                                            'USE_EXT' => 'Y',
                                            'DELAY' => 'N',
                                            'ALLOW_MULTI_SELECT' => 'N',
                                            'TITLE' => getMessage('top_menu_sec2_title'),
                                            'ALL_TITLE' => getMessage('top_menu_sec2_all_title'),
                                            'ALL_LINK' => getMessage('top_menu_sec2_all_link'),
                                        )
                                    );
                                    ?>
                                </li>
                              
                                <!--<li class="submenu-wrap">
                                    <?php
                                    $APPLICATION->IncludeComponent(
                                        'bitrix:menu',
                                        'top_section',
                                        array(
                                            'COMPONENT_TEMPLATE' => 'top_section',
                                            'ROOT_MENU_TYPE' => 'top_sec4',
                                            'MENU_CACHE_TYPE' => 'A',
                                            'MENU_CACHE_TIME' => '3600',
                                            'MENU_CACHE_USE_GROUPS' => 'Y',
                                            'MENU_CACHE_GET_VARS' => '',
                                            'MAX_LEVEL' => '1',
                                            'CHILD_MENU_TYPE' => '',
                                            'USE_EXT' => 'Y',
                                            'DELAY' => 'N',
                                            'ALLOW_MULTI_SELECT' => 'N',
                                            'TITLE' => getMessage('top_menu_sec4_title'),
                                            'ALL_LINK' => getMessage('top_menu_sec4_all_link'),
                                        )
                                    );
                                    ?>
                                </li>-->
                                
                                <li class="submenu-wrap">
                                    <?php
                                    $APPLICATION->IncludeComponent(
                                        'bitrix:menu',
                                        'top_section',
                                        array(
                                            'COMPONENT_TEMPLATE' => 'top_section',
                                            'ROOT_MENU_TYPE' => 'top_sec6',
                                            'MENU_CACHE_TYPE' => 'A',
                                            'MENU_CACHE_TIME' => '3600',
                                            'MENU_CACHE_USE_GROUPS' => 'Y',
                                            'MENU_CACHE_GET_VARS' => '',
                                            'MAX_LEVEL' => '1',
                                            'CHILD_MENU_TYPE' => '',
                                            'USE_EXT' => 'Y',
                                            'DELAY' => 'N',
                                            'ALLOW_MULTI_SELECT' => 'N',
                                            'TITLE' => getMessage('top_menu_sec6_title'),
                                            'ALL_TITLE' => getMessage('top_menu_sec6_all_title'),
                                            'ALL_LINK' => getMessage('top_menu_sec6_all_link'),
                                        )
                                    );
                                    ?>
                                </li>
                                <li class="submenu-wrap">
                                    <?php
                                    $APPLICATION->IncludeComponent(
                                        'bitrix:menu',
                                        'top_section',
                                        array(
                                            'COMPONENT_TEMPLATE' => 'top_section',
                                            'ROOT_MENU_TYPE' => 'top_sec7',
                                            'MENU_CACHE_TYPE' => 'A',
                                            'MENU_CACHE_TIME' => '3600',
                                            'MENU_CACHE_USE_GROUPS' => 'Y',
                                            'MENU_CACHE_GET_VARS' => '',
                                            'MAX_LEVEL' => '1',
                                            'CHILD_MENU_TYPE' => '',
                                            'USE_EXT' => 'Y',
                                            'DELAY' => 'N',
                                            'ALLOW_MULTI_SELECT' => 'N',
                                            'TITLE' => getMessage('top_menu_sec7_title'),
                                            'ALL_LINK' => getMessage('top_menu_sec7_all_link'),
                                        )
                                    );
                                    ?>
                                </li>
							</ul>
							<div class="main-header-nav-mobile-block<?php echo $isVisually ? '' : ' small';?>">
								<div class="main-header-nav-link-wrap1">
                                    <a href="javascript:void(0)" class="langChange" data-id="<?php echo $curLang['ID'];?>"><?php echo $curLang['NAME'];?></a>
								</div>
                                <div class="main-header-nav-link-wrap3">
                                    <button class="open_visually<?php echo $isVisually ? ' active' : '';?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12">
                                            <g>
                                                <g>
                                                    <path d="M13.357 9.075a8.262 8.262 0 0 1-4.362 1.22 8.26 8.26 0 0 1-4.362-1.22c-1.341-.813-2.457-1.906-3.347-3.28C2.303 4.216 3.578 3.034 5.11 2.25a4.392 4.392 0 0 0-.612 2.26c0 1.239.44 2.298 1.32 3.18.88.88 1.939 1.32 3.177 1.32s2.297-.44 3.177-1.32c.88-.881 1.32-1.941 1.32-3.18 0-.81-.204-1.564-.612-2.26 1.532.783 2.807 1.965 3.824 3.546-.89 1.373-2.006 2.466-3.347 3.28zM6.843 2.353a2.93 2.93 0 0 1 2.148-.897c.134 0 .247.047.34.14.094.094.141.208.141.341a.464.464 0 0 1-.14.34.463.463 0 0 1-.34.141c-.575 0-1.066.204-1.473.611a2.007 2.007 0 0 0-.61 1.472.464.464 0 0 1-.141.341.463.463 0 0 1-.34.14.464.464 0 0 1-.341-.14.464.464 0 0 1-.14-.34c0-.835.298-1.551.896-2.15zm10.956 2.75a10.728 10.728 0 0 0-3.782-3.697C12.434.476 10.761.01 9 .01c-1.761 0-3.434.465-5.017 1.396A10.725 10.725 0 0 0 .2 5.103 1.39 1.39 0 0 0 0 5.796c0 .228.067.459.2.693a10.723 10.723 0 0 0 3.783 3.696c1.583.931 3.256 1.396 5.017 1.396 1.761 0 3.434-.463 5.017-1.39A10.657 10.657 0 0 0 17.8 6.488c.134-.234.201-.465.201-.693a1.39 1.39 0 0 0-.2-.693z"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </button>

                                    <div class="box_flex">
                                        <?php
                                        $APPLICATION->IncludeComponent(
                                            'bitrix:menu',
                                            'colors',
                                            array(
                                                'COMPONENT_TEMPLATE' => 'colors',
                                                'ROOT_MENU_TYPE' => 'colors',
                                                'MENU_CACHE_TYPE' => 'A',
                                                'MENU_CACHE_TIME' => '3600',
                                                'MENU_CACHE_USE_GROUPS' => 'Y',
                                                'MENU_CACHE_GET_VARS' => '',
                                                'MAX_LEVEL' => '1',
                                                'CHILD_MENU_TYPE' => '',
                                                'USE_EXT' => 'Y',
                                                'DELAY' => 'N',
                                                'ALLOW_MULTI_SELECT' => 'N',
                                                'CUR_COLOR' => $curVersion['color'],
                                            )
                                        );

                                        $APPLICATION->IncludeComponent(
                                            'bitrix:menu',
                                            'sizes',
                                            array(
                                                'COMPONENT_TEMPLATE' => 'sizes',
                                                'ROOT_MENU_TYPE' => 'sizes',
                                                'MENU_CACHE_TYPE' => 'A',
                                                'MENU_CACHE_TIME' => '3600',
                                                'MENU_CACHE_USE_GROUPS' => 'Y',
                                                'MENU_CACHE_GET_VARS' => '',
                                                'MAX_LEVEL' => '1',
                                                'CHILD_MENU_TYPE' => '',
                                                'USE_EXT' => 'Y',
                                                'DELAY' => 'N',
                                                'ALLOW_MULTI_SELECT' => 'N',
                                                'CUR_SIZE' => $curVersion['size'],
                                            )
                                        );
                                        ?>
                                    </div>
                                </div>
								<div class="main-header-nav-link-wrap4">
									<a href="#" class="js-appointment-btn btn1">Запись на прием</a>
								</div>
							</div>
						</nav>
					</div>

				</div>
			</div>
		</header>

		<main>






