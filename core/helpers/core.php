<?php 

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