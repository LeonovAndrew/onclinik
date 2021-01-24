<?php

namespace MWI;

use \Bitrix\Main\Application as Application,
    \Bitrix\Main\Web\Cookie as Cookie,
    \CLang;

IncludeModuleLangFile(__FILE__);

/**
 * Class Version
 * @package MWI
 */
class Version
{
    /**
     * @var string VERSION_COLOR_COOKIE
     * @var string VERSION_WIDTH_COOKIE
     * @var string VERSION_SIZE_COOKIE
     * @var array $arColors
     * @var array $arWidth
     * @var array $arSize
     * @var array $arWidthVersion
     * @var array $arColorVersion
     * @var array $arSizeVersion
     */
    const VERSION_COLOR_COOKIE = 'version_color';
    const VERSION_WIDTH_COOKIE = 'version_width';
    const VERSION_SIZE_COOKIE = 'version_size';
    const VERSION_VISUALLY_COOKIE = 'version_visually';

    private static $arColors = array(
        array(
            'msg_code' => 'color',
            'value' => 'main',
            'class' => 'color1',
        ),
        array(
            'msg_code' => 'color',
            'value' => 'white',
            'class' => 'color2',
        ),
        array(
            'msg_code' => 'color',
            'value' => 'black',
            'class' => 'color3',
        ),
        array(
            'msg_code' => 'color',
            'value' => 'green',
            'class' => 'color4',
        ),
    );

    private static $arWidth = array(
        array(
            'msg_code' => 'tablet_version',
            'value' => 'tablet',
            'class' => 'main-footer-versions-item-1',
        ),
        array(
            'msg_code' => 'full_version',
            'value' => 'pc',
            'class' => 'main-footer-versions-item-2',
        ),
        array(
            'msg_code' => 'mobile_version',
            'value' => 'mobile',
            'class' => 'main-footer-versions-item-3',
        ),
    );

    private static $arSize = array(
        array(
            'msg_code' => 'size',
            'value' => 'main',
            'class' => '',
        ),
        array(
            'msg_code' => 'size',
            'value' => '150',
            'class' => 'middle',
        ),
    );

    private static $arWidthVersion = array(
        'main' => array(
            'viewport' => '',
            'css' => array(
                'media_main',
            ),
            'classes' => array(

            ),
        ),
        'pc' => array(
            'viewport' => 'content="width=1360, initial-scale=1"',
            'css' => array(
                'media_pc',
            ),
            'classes' => array(

            ),
        ),
        'tablet' => array(
            'viewport' => 'content="width=768, initial-scale=1"',
            'css' => array(
                'media_tablet',
            ),
            'classes' => array(
                'media_tablet',
            ),
        ),
        'mobile' => array(
            'viewport' => 'content="width=320, initial-scale=1"',
            'css' => array(
                'media_tablet',
                'media_mobile',
            ),
            'classes' => array(
                'media_tablet',
                'media_mobile',
            ),
        ),
    );

    private static $arColorVersion = array(
        'main' => array(
            'main' => array(
                'css' => array(

                ),
                'classes' => array(

                ),
            ),
            'pc' => array(
                'css' => array(

                ),
                'classes' => array(

                ),
            ),
            'tablet' => array(
                'css' => array(

                ),
                'classes' => array(

                ),
            ),
            'mobile' => array(
                'css' => array(

                ),
                'classes' => array(

                ),
            ),
        ),
        'black' => array(
            'main' => array(
                'css' => array(
                    'body_black',
                    'black_media',
                ),
                'classes' => array(
                    'body_black',
                ),
            ),
            'pc' => array(
                'css' => array(
                    'body_black',
                ),
                'classes' => array(
                    'body_black',
                ),
            ),
            'tablet' => array(
                'css' => array(
                    'body_black',
                    'black_tablet',
                ),
                'classes' => array(
                    'body_black',
                    'black_tablet',
                ),
            ),
            'mobile' => array(
                'css' => array(
                    'body_black',
                    'black_tablet',
                    'black_mobile',
                ),
                'classes' => array(
                    'body_black',
                    'black_tablet',
                    'black_mobile',
                ),
            ),
        ),
        'white' => array(
            'main' => array(
                'css' => array(
                    'body_white',
                    'white_media',
                ),
                'classes' => array(
                    'body_white',
                ),
            ),
            'pc' => array(
                'css' => array(
                    'body_white',
                ),
                'classes' => array(
                    'body_white',
                ),
            ),
            'tablet' => array(
                'css' => array(
                    'body_white',
                    'white_tablet',
                ),
                'classes' => array(
                    'body_white',
                    'white_tablet',
                ),
            ),
            'mobile' => array(
                'css' => array(
                    'body_white',
                    'white_tablet',
                    'white_mobile',
                ),
                'classes' => array(
                    'body_white',
                    'white_tablet',
                    'white_mobile',
                ),
            ),
        ),
        'green' => array(
            'main' => array(
                'css' => array(
                    'body_green',
                    'black_media',
                ),
                'classes' => array(
                    'body_green',
                ),
            ),
            'pc' => array(
                'css' => array(
                    'body_green',
                ),
                'classes' => array(
                    'body_green',
                ),
            ),
            'tablet' => array(
                'css' => array(
                    'body_green',
                    'green_tablet',
                ),
                'classes' => array(
                    'body_green',
                    'green_tablet',
                ),
            ),
            'mobile' => array(
                'css' => array(
                    'body_green',
                    'green_tablet',
                    'green_mobile',
                ),
                'classes' => array(
                    'body_green',
                    'green_tablet',
                    'green_mobile',
                ),
            ),
        ),
    );

    private static $arSizeVersion = array(
        'main' => array(
            'main' => array(
                'css' => array(

                ),
                'classes' => array(

                ),
            ),
            'pc' => array(
                'css' => array(

                ),
                'classes' => array(

                ),
            ),
            'tablet' => array(
                'css' => array(

                ),
                'classes' => array(

                ),
            ),
            'mobile' => array(
                'css' => array(

                ),
                'classes' => array(

                ),
            ),
        ),
        '150' => array(
            'main' => array(
                'css' => array(
                    'body_middle',
                    'middle_media',
                ),
                'classes' => array(
                    'body_middle',
                ),
            ),
            'pc' => array(
                'css' => array(
                    'body_middle',
                    'middle_pc',
                ),
                'classes' => array(
                    'body_middle',
                ),
            ),
            'tablet' => array(
                'css' => array(
                    'body_middle',
                    'middle_tablet',
                ),
                'classes' => array(
                    'body_middle',
                    'middle_tablet',
                ),
            ),
            'mobile' => array(
                'css' => array(
                    'body_middle',
                    'middle_tablet',
                    'middle_mobile',
                ),
                'classes' => array(
                    'body_middle',
                    'middle_tablet',
                    'middle_mobile',
                ),
            ),
        ),
    );

    /**
     * @return bool - return true if current version is version for visually impaired, otherwise return false
     */
    public static function isVisually()
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $versionVisually = $request->getCookie(self::VERSION_VISUALLY_COOKIE);

        return $versionVisually === null ? false : (bool) $versionVisually;
    }

    /**
     * @description - toggle visually impaired version
     */
    public static function toggle()
    {
        $response = Application::getInstance()->getContext()->getResponse();
        $versionVisually = !self::isVisually();

        $cookie = new Cookie(self::VERSION_VISUALLY_COOKIE, $versionVisually);
        $response->addCookie($cookie);
        $response->flush();
    }

    public static function update()
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $response = Application::getInstance()->getContext()->getResponse();
        $versionVisually = self::isVisually();
        if ($versionVisually) {
            $versionColor = $request->getPost('color');
			
			if ( $request->getPost('color') ){
				$_SESSION['VERSION_COLOR'] = $request->getPost('color');
			}
			
            $versionSize = $request->getPost('size');
			
			if ( $request->getPost('size') ){
				$_SESSION['VERSION_SIZE'] = $request->getPost('size');
			}
        }
		
		if ( $_SESSION['VERSION_COLOR'] ){
			$versionColor = $_SESSION['VERSION_COLOR'];
		}
		if ( $_SESSION['VERSION_SIZE'] ){
			$versionSize = $_SESSION['VERSION_SIZE'];
		}
		
        $versionWidth = $request->getPost('width');

        //width version
        if (empty($versionWidth) || !isset(self::$arWidthVersion[$versionWidth])) {
            $versionWidth = $request->getCookie(self::VERSION_WIDTH_COOKIE);
            if (empty($versionWidth) || !isset(self::$arWidthVersion[$versionWidth])) {
                $versionWidth = 'main';
            }
        }
        $cookie = new Cookie(self::VERSION_WIDTH_COOKIE, $versionWidth);
        $response->addCookie($cookie);

        if ($versionVisually) {
            //color version
			
		
            if (empty($versionColor) || !isset(self::$arColorVersion[$versionColor])) {
                $versionColor = $request->getCookie(self::VERSION_COLOR_COOKIE);
                if (empty($versionColor) || !isset(self::$arColorVersion[$versionColor])) {
                    $versionColor = $versionVisually ? 'green' : 'main';
                }
            }
            $cookie = new Cookie(self::VERSION_COLOR_COOKIE, $versionColor);
            $response->addCookie($cookie);

            //size version
            if (empty($versionSize) || !isset(self::$arSizeVersion[$versionSize])) {
                $versionSize = $request->getCookie(self::VERSION_SIZE_COOKIE);
                if (empty($versionSize) || !isset(self::$arSizeVersion[$versionSize])) {
                    $versionSize = 'main';
                }
            }
            $cookie = new Cookie(self::VERSION_SIZE_COOKIE, $versionSize);
            $response->addCookie($cookie);
        } else {
            $versionColor = 'main';
            $versionSize = 'main';
        }
        $response->flush();

        return array(
            'viewport' => self::$arWidthVersion[$versionWidth]['viewport'],
            'css' => array_merge(self::$arWidthVersion[$versionWidth]['css'], self::$arColorVersion[$versionColor][$versionWidth]['css'], self::$arSizeVersion[$versionSize][$versionWidth]['css']),
            'classes' => array_merge(self::$arWidthVersion[$versionWidth]['classes'], self::$arColorVersion[$versionColor][$versionWidth]['classes'], self::$arSizeVersion[$versionSize][$versionWidth]['classes']),
            'width' => $versionWidth,
            'color' => $versionColor,
            'size' => $versionSize,
        );
    }

    public static function getColors()
    {
        return self::$arColors;
    }

    public static function getWidths()
    {
        return self::$arWidth;
    }

    public static function getSizes()
    {
        return self::$arSize;
    }
}
