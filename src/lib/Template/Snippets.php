<?php

namespace Masteryl\Template;

use Masteryl\Helpers\Str;

class Snippets
{
    public static function noIndex()
    {
        return '<meta name="robots" content="noindex" /><meta name="googlebot" content="noindex" />';
    }
    public static function meta($name, $content)
    {
        return '<meta name="' . $name . '" content="' . $content . '" />';
    }

    public static function favicon($url)
    {
        $type = Str::extension($url);

        return '<link rel="icon" type="image/' . $type . '" href="' . $url . '" />';
    }

    public static function bgImage($src, $args = [])
    {
        $scale = !empty($args['scale']) ? $args['scale'] : 1;
        $filter = !empty($args['filter']) ? $args['filter'] : '';

        $str = '<style>.bg-image {';
        $str .= 'background-image: url(' . $src . ');';

        if (!empty($args['scale'])) {
            $str .= 'transform: scale(' . $scale . ');';
        }
        if (!empty($args['filter'])) {
            $str .= 'filter: ' . $filter . ';';
        }
        $str .= '}</style>';

        return $str;
    }

    public static function bgColor($value)
    {
        return '<style>body, html, .theme--light.v-application, .theme--dark.v-application {
			background-color: ' . $value . ' !important;
		}</style>';
    }

    public static function description($content)
    {
        $meta = '<meta name="description" content="' . $content . '" />';
        $meta .= '<meta property="og:description" content="' . $content . '" />';
        $meta .= '<meta name="twitter:description" content="' . $content . '" />';

        return $meta;
    }

    public static function keywords($content)
    {
        return '<meta name="keywords" content="' . $content . '" />';
    }

    public static function image($content)
    {
        return '<meta name="og:image" content="' . $content . '" />' .
            '<meta name="twitter:image" content="' . $content . '" />';

    }

    public static function ogType($content = 'website')
    {
        return '<meta property="og:type" content="' . $content . '" />';
    }

    public static function fbAppId($content)
    {
        return '<meta property="fb:app_id" content="' . $content . '" />';
    }

    public static function googleAnalytics($id)
    {
        return '<script async src="https://www.googletagmanager.com/gtag/js?id=' . $id . '"></script><script>
        window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag(\'js\', new Date());gtag(\'config\', \'' . $id . '\');</script>';
    }

    public static function fbPixel($id)
    {
        return "<script>!function(f,b,e,v,n,t,s) {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init', '" . $id . "');fbq('track', 'PageView');
            </script>";
    }
}
