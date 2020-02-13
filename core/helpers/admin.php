<?php 

function admin_err_suc_msg()
{
    echo admin_get_messages('success', '<div class="alert alert-success">', '</div>');
    echo admin_get_messages('error', '<div class="alert alert-danger">', '</div>');
}

function admin_get_messages($type="success", $pre='<p>', $pos='</p>')
{
    $msgs =  \Ultra\Session::getMessage($type);
    $m = '';

    if(is_array($msgs) && count($msgs) > 0) {

        foreach ($msgs as $key => $value) {

            $m .= $pre.$value.$pos;
            
        }

    }

    return $m;
}

// see: core/libraries/Authentication.php
function get_user_session($item=null)
{
    if (strlen($item) > 0 && isset($_SESSION['user'][$item]))
        return $_SESSION['user'][$item];

    if (isset($_SESSION['user']))
        return $_SESSION['user'];

    return false;
  
}