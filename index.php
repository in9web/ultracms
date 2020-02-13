<?php 
/*
 * Bootstrap application
 */
require_once('core/bootstrap.php');

// Auto maintenance mode
// dont affect the console commands
if (file_exists('maintenance.php')) {
    include('maintenance.php');
    die();
}

// FIX ME // add slim or silex ?
$home_theme = 'themes/default/';

$page = 'index';
if (isset($_GET['p']) && strlen($_GET['p']) > 0 )
    $page = $_GET['p'];

$file_theme_page = $home_theme .$page .'.php';
if (!file_exists($file_theme_page))
    $file_theme_page = $home_theme .'index.php';

include($file_theme_page);
