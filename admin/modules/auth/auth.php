<?php 
use Ultra\Admin;
use Ultra\Assets;
use Ultra\Input;
use Ultra\Model\User;
use Ultra\Library\Authentication;

$action = Admin::getRequestModuleAction();

if ($action == 'logout') {
    
    // do logout and redirect
    Authentication::logout();

}

if (Input::post('do_login') == 'login') {

    // try do login and redirect
    Authentication::login(Input::post('email'), Input::post('password'));
    
} elseif (Input::post('do_login') == 'login_recover') {

    // try send email and redirect
    Authentication::forgotPassword(Input::post('email'));
    
}

get_theme_admin('login');