<?php 
use Ultra\Admin;
use Ultra\Config;
use Ultra\Request;

?>
<!DOCTYPE html>
<html lang="<?php echo Config::getConfig('language_code') ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title><?php echo ULTRANAME; ?></title> 
<?php
    echo get_assets_css();
    echo get_assets_js();
?>
    <link rel="stylesheet" href="<?php echo admin_theme_url('/assets/css/style.css') ?>">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>
    <script>
        jQuery(document).ready(function($){
            $('.input_bsfile').each(function(){
                var ipt = $(this)
                var ibtn = $('<button>');

                ipt.hide();
                ipt.change(function(){
                    if ($(this).val().length > 0) {
                        ibtn.addClass('btn-success').removeClass('btn-default');
                        ibtn.next('.btn_file_infos').html($(this).val());
                    } else {
                        ibtn.addClass('btn-default').removeClass('btn-success');
                        ibtn.next('.btn_file_infos').html('');
                    }
                });
                
                ibtn.addClass('btn btn-default');
                ibtn.attr('type', 'button');
                ibtn.html('<?php t('Choose file') ?>');
                ibtn.click(function(e){
                    ipt.click();
                });

                $(this).after(ibtn);
                $(ibtn).before('<br>')
                $(ibtn).after('<small class="btn_file_infos"></small>');
            });
        });
    </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php echo ULTRANAME ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php /*<!-- <li><a href="#">Dashboard</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Help</a></li> --> */?>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="glyphicon glyphicon-user"></i>
                        <?php echo get_user_session('name'); ?> 
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo admin_url('/users/profile') ?>"><?php t('Profile') ?></a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo admin_url('/auth/logout') ?>"><?php t('Logout') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <?php 
                    $active = '';
                    if (ltrim(Request::getCurrentUri(), '/') == '')
                        $active = 'active';
                ?>
                <li class="<?php echo $active; ?>">
                    <a href="<?php echo admin_url() ?>">
                        <i class="glyphicon glyphicon-home"></i>
                        <?php t('Dashboard') ?> <span class="sr-only">(current)</span>
                    </a>
                </li>

                <?php foreach (Admin::getMenu() as $menu_position => $menu): ?>
                    <?php 
                        $active = '';
                        if (strpos(Request::getCurrentUri(), $menu['uri']) !== false){
                            $active = "active";
                        }
                        $icon = 'cog';

                        if (!is_null($menu['icon'])) {
                            $icon = $menu['icon'];
                        }
                    ?>
                    <li class="<?php echo $active; ?>"><a href="<?php echo admin_url($menu['uri']) ?>"><i class="glyphicon glyphicon-<?php echo $icon; ?>"></i> <?php t($menu['name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php /* 
            <!-- <ul class="nav nav-sidebar">
                <li><a href="">Nav item</a></li>
                <li><a href="">Nav item again</a></li>
                <li><a href="">One more nav</a></li>
                <li><a href="">Another nav item</a></li>
                <li><a href="">More navigation</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="">Nav item again</a></li>
                <li><a href="">One more nav</a></li>
                <li><a href="">Another nav item</a></li>
            </ul> -->
            */ ?>
        </div>
    
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
