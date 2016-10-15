<?php 

function app_log($level, $message)
{
    return \Ultra\App::$log->$level($message);
}

function storage_path($path='')
{
    return \Ultra\Config::getConfig('storage_path').($path ? DIRECTORY_SEPARATOR.ltrim($path, '/') : $path);
}

function base_path($path='')
{
    return \Ultra\Config::getConfig('base_path').($path ? DIRECTORY_SEPARATOR.ltrim($path, '/') : $path);
}

function core_path($path='')
{
    return \Ultra\Config::getConfig('core_path').($path ? DIRECTORY_SEPARATOR.ltrim($path, '/') : $path);
}

function assets_path($path='')
{
    return \Ultra\Config::getConfig('assets_path').($path ? DIRECTORY_SEPARATOR.ltrim($path, '/') : $path);
}

function get_theme_admin($path='', $data=null)
{
    $theme_admin_folder = \Ultra\Config::getConfig('admin_path').'/themes/'.\Ultra\Config::getConfig('admin_theme_name').'/';

    if (file_exists($theme_admin_folder.$path.'.php')) {

        if (is_array($data))
            extract($data);

        // autoload functions file
        include_once($theme_admin_folder.'/functions.php');

        // load theme requested
        require_once($theme_admin_folder.$path.'.php');

        return true;
    }

    return false;
}

function get_header_admin(){ return get_theme_admin('header'); }
function get_footer_admin(){ return get_theme_admin('footer'); }
function get_pager_admin($data){ return get_theme_admin('pager', $data); }

function get_assets_css()
{
    return \Ultra\Assets::getCss();
}

function get_assets_js()
{
    return \Ultra\Assets::getJs();
}

function clear_filename($filename)
{
    $filename_arr = explode('.', $filename);
    $extension = array_pop($filename_arr);
    $new_filename = '';

    if (count($filename_arr) > 1){

        foreach ($filename_arr as $item) {
        
            $new_filename .= \Stringy\StaticStringy::slugify($item) . '.';
            
        }

        $new_filename .= $extension;

        return $new_filename;

    }

    return $filename;

}

function pretty_filesize($num, $precision=1)
{
    if ($num >= 1000000000000) {
        $num = round($num / 1099511627776, $precision);
        $unit = 'TB';
    } elseif ($num >= 1000000000) {
        $num = round($num / 1073741824, $precision);
        $unit = 'GB';
    } elseif ($num >= 1000000) {
        $num = round($num / 1048576, $precision);
        $unit = 'MB';
    } elseif ($num >= 1000) {
        $num = round($num / 1024, $precision);
        $unit = 'KB';
    } else {
        $unit = 'bytes';
        return number_format($num).' '.$unit;
    }

    return number_format($num, $precision).' '.$unit;
}