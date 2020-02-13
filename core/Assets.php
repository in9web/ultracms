<?php 
namespace Ultra;

class Assets
{
    public static $css = [];
    
    public static $js = [];

    public static $scripts = [];

    public static $vendors = [];

    public static function addCss($path)
    {
        static::$css[] = $path;
    }
    
    public static function getCss()
    {
        $string = "";
        $format = '<link rel="stylesheet" href="%s" type="text/css" />';

        foreach (static::$css as $link) {
            $string .= PHP_EOL.sprintf($format, $link);             
        }
        
        return $string;
    }

    public static function addJs($path)
    {
        static::$js[] = $path;
    }

    public static function getJs()
    {
        $string = "";
        $format = '<script type="text/javascript" src="%s"></script>';

        foreach(static::$js as $js) {
            $string .= PHP_EOL.sprintf($format, $js);
        }

        $string .= "<script>";
        $string .= static::getScripts();
        $string .= "</script>";

        return $string;
    }

    public static function addScript($string_script)
    {
        static::$scripts[] = $string_script;
    }

    public static function getScripts()
    {
        return implode(PHP_EOL, static::$scripts);
    }

    public static function addAssetVendor($vendor)
    {
        static::$vendors = array(
            'jquery-1.10.1' => array(
                'js' => array(assets_url('/vendors/jquery/1.10.1/jquery.min.js'))
            ),
            'jquery-1.11.3' => array(
                'js' => array(assets_url('/vendors/jquery/1.11.3/jquery.min.js'))
            ),
            'bootstrap-3.3.6' => array(
                'css' => array(
                    assets_url('/vendors/bootstrap/3.3.6/css/bootstrap.min.css'),
                    assets_url('/vendors/bootstrap/3.3.6/css/bootstrap-theme.min.css')
                ),
                'js' => array(assets_url('/vendors/bootstrap/3.3.6/js/bootstrap.min.js'))
            ),
            'font-awesome-4.6.3' => array(
                'css' => array(assets_url('/vendors/font-awesome-4.6.3/css/font-awesome.min.css')),
            ),
            'prettyphoto-3.1.5' => array(
                'css' => array(assets_url('/vendors/prettyPhoto/3.1.5/css/prettyPhoto.css')),
                'js' => array(assets_url('/vendors/prettyPhoto/3.1.5/js/jquery.prettyPhoto.js'))
            ),
            'cidades-estados-1.2-utf8' => array(
                'js' => array(assets_url('/vendors/cidades-estados/1.2-utf8/cidades-estados-1.2-utf8.js'))
            )
        );

        if (isset(static::$vendors[$vendor]['css']))
            foreach (static::$vendors[$vendor]['css'] as $css_link)
                static::addCss($css_link);

        if (isset(static::$vendors[$vendor]['js']))
            foreach (static::$vendors[$vendor]['js'] as $js_link)
                static::addJs($js_link);
    }
}