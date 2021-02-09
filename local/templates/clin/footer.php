<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

global $USER;

$curLang = MWI\Lang::getCurrent();
?>



	</main>	
	<footer class="main-footer">
		<div class="container">
			<div class="main-footer-container">
				<div class="main-footer-wrap1">
					<div class="main-footer-list-wrap main-footer-list-wrap1">
                        <?php
                        $APPLICATION->IncludeComponent(
                            'bitrix:menu',
                            'bottom_section',
                            array(
                                'COMPONENT_TEMPLATE' => 'bottom_section',
                                'ROOT_MENU_TYPE' => 'bottom_sec1',
                                'MENU_CACHE_TYPE' => 'A',
                                'MENU_CACHE_TIME' => '3600',
                                'MENU_CACHE_USE_GROUPS' => 'Y',
                                'MENU_CACHE_GET_VARS' => '',
                                'MAX_LEVEL' => '1',
                                'CHILD_MENU_TYPE' => '',
                                'USE_EXT' => 'N',
                                'DELAY' => 'N',
                                'ALLOW_MULTI_SELECT' => 'N',
                                'TITLE' => getMessage('bottom_menu_sec1_title'),
                            )
                        );
                        ?>
					</div>
					<div class="main-footer-list-wrap main-footer-list-wrap2">
                        <?php
                        $APPLICATION->IncludeComponent(
                            'bitrix:menu',
                            'bottom_section',
                            array(
                                'COMPONENT_TEMPLATE' => 'bottom_section',
                                'ROOT_MENU_TYPE' => 'bottom_sec2',
                                'MENU_CACHE_TYPE' => 'A',
                                'MENU_CACHE_TIME' => '3600',
                                'MENU_CACHE_USE_GROUPS' => 'Y',
                                'MENU_CACHE_GET_VARS' => '',
                                'MAX_LEVEL' => '1',
                                'CHILD_MENU_TYPE' => '',
                                'USE_EXT' => 'N',
                                'DELAY' => 'N',
                                'ALLOW_MULTI_SELECT' => 'N',
                                'TITLE' => getMessage('bottom_menu_sec2_title'),
                            )
                        );
                        ?>
					</div>
					<div class="main-footer-list-wrap main-footer-list-wrap3">
                        <?php
                        $APPLICATION->IncludeComponent(
                            'bitrix:menu',
                            'bottom_section',
                            array(
                                'COMPONENT_TEMPLATE' => 'bottom_section',
                                'ROOT_MENU_TYPE' => 'bottom_sec3',
                                'MENU_CACHE_TYPE' => 'A',
                                'MENU_CACHE_TIME' => '3600',
                                'MENU_CACHE_USE_GROUPS' => 'Y',
                                'MENU_CACHE_GET_VARS' => '',
                                'MAX_LEVEL' => '1',
                                'CHILD_MENU_TYPE' => '',
                                'USE_EXT' => 'N',
                                'DELAY' => 'N',
                                'ALLOW_MULTI_SELECT' => 'N',
                                'TITLE' => getMessage('bottom_menu_sec3_title'),
                            )
                        );
                        ?>
					</div>
					<div class="main-footer-list-wrap main-footer-list-wrap4">
                        <?php
                        $APPLICATION->IncludeComponent(
                            'bitrix:menu',
                            'bottom_section',
                            array(
                                'COMPONENT_TEMPLATE' => 'bottom_section',
                                'ROOT_MENU_TYPE' => 'bottom_sec4',
                                'MENU_CACHE_TYPE' => 'A',
                                'MENU_CACHE_TIME' => '0',
                                'MENU_CACHE_USE_GROUPS' => 'Y',
                                'MENU_CACHE_GET_VARS' => '',
                                'MAX_LEVEL' => '1',
                                'CHILD_MENU_TYPE' => '',
                                'USE_EXT' => 'N',
                                'DELAY' => 'N',
                                'ALLOW_MULTI_SELECT' => 'N',
                                'TITLE' => getMessage('bottom_menu_sec4_title'),
                            )
                        );
                        ?>
					</div>
                    <?php
                    $APPLICATION->IncludeComponent(
                        'bitrix:menu',
                        'bottom_bold',
                        array(
                            'COMPONENT_TEMPLATE' => 'bottom_bold',
                            'ROOT_MENU_TYPE' => 'bottom_bold',
                            'MENU_CACHE_TYPE' => 'A',
                            'MENU_CACHE_TIME' => '3600',
                            'MENU_CACHE_USE_GROUPS' => 'Y',
                            'MENU_CACHE_GET_VARS' => '',
                            'MAX_LEVEL' => '1',
                            'CHILD_MENU_TYPE' => '',
                            'USE_EXT' => 'N',
                            'DELAY' => 'N',
                            'ALLOW_MULTI_SELECT' => 'N',
                        )
                    );
                    ?>
					<div class="main-footer-contacts">
                        <?php
                        $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_RECURSIVE" => "Y",
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "",
                                "PATH" => "/include/footer/contacts.php"
                            ),
                            false,
                            array(
                                'HIDE_ICONS' => 'Y'
                            )
                        );
                        ?>
						<a href="#" class="js-appointment-btn btn1" onclick="gtag('event','Open',{'event_category':'AppointmentForm','event_label':'Click-button-zapisatsya-na-priem-footer'});ym(2120464,'reachGoal','Appointment-Form-Footer-Open'); return true;">
<?php echo getMessage('make_an_appointment');?></a>
					</div>
					<div class="main-footer-social-wrap">
						<div class="main-footer-social">
							<h3><?php echo getMessage('bottom_social_title');?></h3>
							<ul class="main-footer-social-list">
								<li>
									<a href="https://vk.com/onclinicru" target="_blank" rel="nofollow noopener">
										<img src="<?php echo SITE_TEMPLATE_PATH;?>/assets/img/main-footer-social-item-1.svg" alt="">
									</a>
								</li>
								<li>
									<a href="https://www.facebook.com/onclinicmsk" target="_blank" rel="nofollow noopener">
										<img src="<?php echo SITE_TEMPLATE_PATH;?>/assets/img/main-footer-social-item-2.svg" alt="">
									</a>
								</li>
								<li>
									<a href="https://ok.ru/profile/577149703061" target="_blank" rel="nofollow noopener">
										<img src="<?php echo SITE_TEMPLATE_PATH;?>/assets/img/main-footer-social-item-3.svg" alt="">
									</a>
								</li>
								<li>
									<a href="https://www.instagram.com/onclinic.ru/" target="_blank" rel="nofollow noopener">
										<img src="<?php echo SITE_TEMPLATE_PATH;?>/assets/img/main-footer-social-item-4.svg" alt="">
									</a>
								</li>
								<li>
									<a href="https://www.youtube.com/channel/UCh0c50jjP9oiElp3UyCjPXw" target="_blank" rel="nofollow noopener">
										<img src="<?php echo SITE_TEMPLATE_PATH;?>/assets/img/main-footer-social-item-5.svg" alt="">
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="main-footer-wrap2">
					<div class="main-footer-certificates-list">
                        <?php
                        $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_RECURSIVE" => "Y",
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "",
                                "PATH" => "/include/footer/advantages.php"
                            ),
                            false,
                            array(
                                'HIDE_ICONS' => 'Y'
                            )
                        );
                        ?>
					</div>
				</div>
				<div class="main-footer-wrap3">
					<div class="main-footer-share-wrap">
						<span>Поделиться в социальных сетях</span>
						<ul class="main-footer-share-list">
							<li>
								<a onclick="Share.vkontakte('https://<?=$_SERVER['HTTP_HOST']?><?=$APPLICATION->GetCurDir()?>','<?$APPLICATION->ShowTitle();?>','<?$APPLICATION->ShowProperty('description');?>','')" class="main-footer-share-item main-footer-share-item-1" href="#" target="_blank" rel="nofollow noopener"></a>
							</li>
							<li>
								<a onclick="Share.facebook('https://<?=$_SERVER['HTTP_HOST']?><?=$APPLICATION->GetCurDir()?>','<?$APPLICATION->ShowTitle();?>','<?$APPLICATION->ShowProperty('description');?>','')" class="main-footer-share-item main-footer-share-item-2" href="#" target="_blank" rel="nofollow noopener"></a>
							</li>
							<li>
								<a onclick="Share.odnoklassniki('https://<?=$_SERVER['HTTP_HOST']?><?=$APPLICATION->GetCurDir()?>','<?$APPLICATION->ShowTitle();?>','<?$APPLICATION->ShowProperty('description');?>','')" class="main-footer-share-item main-footer-share-item-3" href="#" target="_blank" rel="nofollow noopener"></a>
							</li>
						</ul>
					</div>
					<div class="main-footer-subscribe-btn-wrap">
						<a href="#subscription_modal" class="modal_link"><?php echo getMessage('subscription_btn');?></a>
					</div>
                    <?php
                    $APPLICATION->IncludeComponent(
                        'bitrix:menu',
                        'widths',
                        array(
                            'COMPONENT_TEMPLATE' => 'widths',
                            'ROOT_MENU_TYPE' => 'widths',
                            'MENU_CACHE_TYPE' => 'A',
                            'MENU_CACHE_TIME' => '3600',
                            'MENU_CACHE_USE_GROUPS' => 'Y',
                            'MENU_CACHE_GET_VARS' => '',
                            'MAX_LEVEL' => '1',
                            'CHILD_MENU_TYPE' => '',
                            'USE_EXT' => 'Y',
                            'DELAY' => 'N',
                            'ALLOW_MULTI_SELECT' => 'N',
                            'CUR_WIDTH' => $curVersion['width'],
                        )
                    );
                    ?>
				</div>
				<div class="main-footer-wrap4">
					<p>© <?php echo getMessage('copyright');?>, 1995-<?php echo date('Y');?></p>
                    <?php
                    $APPLICATION->IncludeComponent(
                        'bitrix:menu',
                        'widths',
                        array(
                            'COMPONENT_TEMPLATE' => 'widths',
                            'ROOT_MENU_TYPE' => 'widths',
                            'MENU_CACHE_TYPE' => 'A',
                            'MENU_CACHE_TIME' => '3600',
                            'MENU_CACHE_USE_GROUPS' => 'Y',
                            'MENU_CACHE_GET_VARS' => '',
                            'MAX_LEVEL' => '1',
                            'CHILD_MENU_TYPE' => '',
                            'USE_EXT' => 'Y',
                            'DELAY' => 'N',
                            'ALLOW_MULTI_SELECT' => 'N',
                            'CUR_WIDTH' => $curVersion['width'],
                        )
                    );
                    ?>
					<ul class="main-footer-list2">
						<li>
							<a href="<?php echo getMessage('sitemap_link');?>"><?php echo getMessage('sitemap');?></a>
						</li>
						<!--<li>
							<a href="<?php echo getMessage('privacy_policy_link');?>"><?php echo getMessage('privacy_policy');?></a>
						</li>
						<li>
							<a href="<?php echo getMessage('terms_of_use_link');?>"><?php echo getMessage('terms_of_use');?></a>
						</li>-->
					</ul>
					<span class="made_by">
						<a href="https://mwi.me" rel="nofollow" target="blank">Сделано в MWI</a>
					</span>
				</div>
			</div>
		</div>
	</footer>
    <div class="fixed-header fixed hidden-fixed">
        <div class="fixed-header-wrap1">
            <div style="display: none;" class="fixed-header-list-wrap">
                <ul class="fixed-header-list">
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
                    </li>
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
                <div class="main-header-nav-mobile-block">
                    <div class="main-header-nav-link-wrap1">
                        <a href="javascript:void(0)" class="langChange" data-id="<?php echo $curLang['ID'];?>"><?php echo $curLang['NAME'];?></a>
                    </div>
                    <div class="main-header-nav-link-wrap3">
                        <a href="#"></a>

                    </div>
                    <div class="main-header-nav-link-wrap4">
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
            <div class="fixed-header-menu-toggle">Меню</div>
            <form action="<?php echo getMessage('search_link');?>" class="fixed-header-search-form">
                <input type="search" name="q" placeholder="Поиск">
                <button type="submit">Найти</button>
            </form>
            <div class="fixed-header-tel-wrap">
                <a href="tel:+74952232222" onclick="gtag('event', 'form_submit', { 'event_category': 'form', 'event_action': 'Tel-Footer', }); ym('2120464', 'reachGoal', 'Tel-Footer'); return true;">+7 495 223-22-22</a>
                <span>с 8:00 до 23:00</span>
            </div>
            <div class="fixed-header-feedback">
                <a href="#" class="js-appointment-btn" onclick="gtag('event','Open',{'event_category':'AppointmentForm','event_label':'Click-button-zapisatsya-na-priem-footer'});ym(2120464,'reachGoal','Appointment-Form-Footer-Open'); return true;">Запись <span>на прием</span></a>
            </div>
        </div>
    </div>
	<div class="toTop-wrap">
		<div style="display: none;" class="toTop-icon" id="toTop"></div>
	</div>

</div>
<div class="hidden"></div>
<?php
$APPLICATION->IncludeComponent(
    'mwi:subscription.form',
    'subscription',
    array(
        'SUCCESS_MSG' => getMessage('success_msg_subscribe'),
    )
);
?>

    <?php
    if (!$USER->IsAdmin()) {
        $APPLICATION->ShowHeadStrings();
    }
    $APPLICATION->ShowHeadScripts();
    ?>
	<?if(strpos($_SERVER['HTTP_USER_AGENT'],'Chrome-Lighthouse') === false):?>
        <script>
            let counterWords = <?php echo json_encode([
                                                          'hours' => getMessage('clock_words_hours'),
                                                          'minutes' => getMessage('clock_words_minutes'),
                                                      ]);?>;
        </script>
		<link rel="stylesheet" href="https://cdn.envybox.io/widget/cbk.css">
        <script type="text/javascript" src="https://cdn.envybox.io/widget/cbk.js?wcb_code=8e2e6d7e28110ce6b3fe485ab56e9519" charset="UTF-8" async></script>
<script>
var ct_cb_style = document.createElement('style'); ct_cb_style.id = 'ct_custom_style';
ct_cb_style.innerHTML = '#CalltouchWidgetFrame{height:0px!important;width:0px!important;}';
document.getElementsByTagName('head')[0].appendChild(ct_cb_style);
var on_show_widget = function(event){
 console.log('widget show: ',event);
 if (!!ct_cb_style && !!ct_cb_style.parentNode){ ct_cb_style.parentNode.removeChild(ct_cb_style); }
}
var on_close_widget = function(event){
 console.log('widget close: ',event);
 if (!document.getElementById('ct_custom_style')){ document.getElementsByTagName('head')[0].appendChild(ct_cb_style); }
}
window.ct('modules','widgets','subscribeToEvent',[
 {object:'form',action:'show',callback:function(event){ on_show_widget(event); }},
 {object:'form',action:'close',callback:function(event){ on_close_widget(event); }},
 {object:'widget-button',action:'show',callback:function(event){ on_close_widget(event); }},
]);
</script>
	<?endif;?>
	</body>
</html>
