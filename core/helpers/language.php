<?php 

use \Ultra\App;

function _t($text)
{
    if (isset(App::$lang[$text])) {
    
        return App::$lang[$text];
    
    } else {
    
        return $text;

    }

}

function t($text)
{
    echo _t($text);
}