<?php
use Ultra\Admin;
use Ultra\App;
use Ultra\Assets;
use Ultra\Config;
use Ultra\Request;
use Ultra\Model\User;
use Ultra\Library\Authentication as Auth;

/*
 * Bootstrap application
 */
require_once('../core/bootstrap.php');

$modules_dir = dirname(__FILE__)."/modules/";

Admin::bootstrap(array('modules_dir' => $modules_dir));

// App::loadLibrary('admin');

// get Bootstrap from modules
Admin::adminLoadModules($modules_dir);

// getModule
$module = Admin::getRequestModuleName();

// check is auth required and user logged
if (Config::getConfig('admin_auth_required') && !Auth::check() && $module != 'auth') {

    admin_redirect_uri('/auth');

}

Admin::adminStartModules($module);

// DIRETÓRIO DOS MÓDULOS
$modules_dir = dirname(__FILE__)."/modules/";
$diropen = opendir($modules_dir);

// is auth load before
if(isset($_GET['module']) && $_GET['module'] == 'auth'){
    $auth_load = $modules_dir .$_GET['module'] .'/' .$_GET['module'] .'.php';
    if (file_exists($auth_load) ){
        include($auth_load);            
    }
    die();
}

// CRIA MENU COM OS MÓDULOS
// $menu = admin_get_menu();



// load configs modules
if( false ){            
    while($file = readdir($diropen)){

        // verifica se existe arquivo de configuração dentro da pasta do módulo
        if( substr($file,0, 2) != '__' && file_exists($modules_dir.$file."/config.php"))
            include $modules_dir.$file."/config.php";

    }
}

