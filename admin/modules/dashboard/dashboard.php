<?php 
use Ultra\Assets;
use Ultra\Input;
use Ultra\Model\User;
use Ultra\Library\Authentication;

// Get Module Configs
$data = include_once('config.php');

get_theme_admin('dashboard/index', $data);