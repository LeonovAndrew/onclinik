<?php

namespace MWI;

/**
 * Class Content
 * @package MWI
 */
class Content
{
    /**
     * @param string $tag
     * @param string $text
     * @param array $arImages - Array containing the following fields:
     *      $arImages = [
     *          'SRC' => (string) src.
     *          'ALT' => (string) alt.
     *      ]
     */
    public static function replaceImgTile($tag, &$text, $arImages)
    {
        $content = '';

        if (!empty($arImages)) {
            $content = '<div class="rules-text-list3">';

            foreach ($arImages as $arImg) {
                $content .= "
                    <div class='rules-text-item3'>
                        <img src='{$arImg['SRC']}' alt='{$arImg['ALT']}'>
                    </div>
                ";
            }

            $content .= '
                </div>
            ';
        }

        $text = str_replace($tag, $content, $text);
    }

    /**
     * @param string $tag
     * @param string $text
     * @param array $arImages Array containing the following fields:
     *      $arImages = [
     *          'SRC' => (string) src.
     *          'ALT' => (string) alt.
     *      ]
     */
    public static function replaceImgSlider($tag, &$text, $arImages)
    {
        $content = '';

        if (!empty($arImages)) {
            $content = '
                <div class="rules-slider">
                    <div class="swiper-container swiper-container6">
                        <div class="swiper-wrapper">
            ';

            foreach ($arImages as $arImg) {
                $content .= "
                    <div class='swiper-slide'>
                        <div class='swiper-slide-wrap'>
                            <img src='{$arImg['SRC']}' alt='{$arImg['ALT']}'>
                        </div>
                    </div>
                ";
            }

            $content .= '
                </div>
                    </div>
                    <div class="swiper-button-next swiper-button-next6 swiper-button-next-style3"></div>
                    <div class="swiper-button-prev swiper-button-prev6 swiper-button-prev-style3"></div>
                </div>
            ';
        }

        $text = str_replace($tag, $content, $text);
    }

    /**
     * @param string $tag
     * @param string $text
     * @param array $arFiles Array containing the following fields:
     *      $arFiles = [
     *          'TYPE' => (string) file type.
     *          'SRC' => (string) src.
     *          'NAME' => (string) file name
     *          'SIZE' => (string) file size
     *      ]
     */
    public static function replaceFile($tag, &$text, $arFiles)
    {
        global $APPLICATION;

        $content = '';

        if (!empty($arFiles)) {
            $content = '<div class="rules-info-link">';

            ob_start();
            $APPLICATION->IncludeFile(
                SITE_DIR . "/include/files_order.php",
                array(),
                array(
                    "MODE" => "html",
                    "NAME" => "Положение приказа Рособрнадзора № 785",
                )
            );
            $filesText = ob_get_contents();
            ob_end_clean();

            $content .= <<<EOT
{$filesText}
EOT;

            $content .= '<ul class="rules-info-link-list">';
            foreach ($arFiles as $arFile) {
                $content .= "
                    <li class='rules-info-link-item {$arFile['TYPE']}'>
                        <a href='{$arFile['SRC']}' download='{$arFile['NAME']}'>
                            <i>{$arFile['NAME']}</i>
                            <span>{$arFile['SIZE']}</span>
                        </a>
                    </li>          
                ";
            }

            $content .= '</ul></div>';
        }

        $text = str_replace($tag, $content, $text);
    }

    /**
     * @param string $tag
     * @param string $text
     * @param array $arVideo Array containing the following fields:
     *      $arVideo = [
     *          'SRC' => (string) src.
     *          'PREVIEW_SRC' => (string) preview picture src.
     *      ]
     */
    public static function replaceVideo($tag, &$text, $arVideo)
    {
        $content = '';
        if (!empty($arVideo['SRC'])) {
            $content = "
                <div class='rules-text-video'>
                    <div class='video_wrapper video_wrapper_full js-videoWrapper'>
                        <iframe class='videoIframe js-videoIframe' src='' frameborder='0' allowTransparency='true' allowfullscreen data-src='{$arVideo['SRC']}?autoplay=1&modestbranding=1&rel=0&hl=ru&showinfo=0&color=white'></iframe>
                        <button class='videoPoster js-videoPoster' style='background-image: url({$arVideo['PREVIEW_SRC']});'></button>
                    </div>
                </div>
            ";
        }

        $text = str_replace($tag, $content, $text);
    }
}