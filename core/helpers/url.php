<?php 

function base_url($uri=null, $protocol='auto')
{
    // get base url from configs
    $base_url = \Ultra\Config::getConfig('base_url');

    // clear duplicate slashs
    $uri = str_replace('//', '/', $uri);

    return $base_url . ltrim($uri, '/');

    // FIX ME

    $protocol = $_SERVER['REQUEST_SCHEME'];
    $host = $_SERVER['HTTP_HOST'];

    if( $protocol == 'https')
        $protocol = 'https';

    $request_uri = '';
    $req_u = explode('/index.php', $_SERVER['REQUEST_URI']);
    
    if (strlen($req_u[0]) > 0)
        $request_uri = $req_u[0];

    $base_url = $protocol .'://' .$host .$request_uri .'/' .ltrim($url, '/');

    return $base_url;
}

function admin_url($uri=null)
{
    return base_url( '/'.\Ultra\Config::getConfig('admin_dirname').'/' .ltrim($uri, '/') );
}

function assets_url($uri=null)
{
    return base_url( '/'.\Ultra\Config::getConfig('assets_dirname').'/' .ltrim($uri, '/') );
}

function admin_theme_url($uri=null)
{
    return base_url( '/'.\Ultra\Config::getConfig('admin_dirname').'/themes/'.\Ultra\Config::getConfig('admin_theme_name').'/' .ltrim($uri, '/') );
}

function redirect($url)
{
    header('Location: ' .$url);
    die();
}

function redirect_uri($uri='')
{
    redirect(base_url($uri));
}

function admin_redirect_uri($uri='')
{
    redirect_uri('/'.\Ultra\Config::getConfig('admin_dirname').'/'.$uri);
}

function redirect_html($url, $time=0)
{
    echo '<meta http-equiv="refresh" content="' .$time .'; url=' .$url .'">';
    echo '<script>window.location.href="' .$url .'";</script>';
    die();
}

function redirect_uri_html($uri, $time=0)
{
    redirect_html(base_url($uri));
}