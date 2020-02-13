<?php 
use Ultra\Admin;
use Ultra\Session;

// Get Module Configs
$data = require('config.php');

// Configure Translation
Admin::addModuleTranslation(__DIR__);

// Configure admin menu
// name, uri, icon_code=null, position=null, permission=null
// Admin::addMenu($data['module_name'], $data['module_uri'], $data['module_icon'], $data['module_menu_position']);

// Configure
