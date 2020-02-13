<?php 
use Ultra\Admin;
use Ultra\AdminController;
use Ultra\Input;
use Ultra\Request;
use Ultra\Session;
// Add your model here

// Get Module Configs
$data = require('config.php');

class DummyController extends AdminController
{
    
}

$controller = new DummyController($data);

$action = Admin::getRequestModuleAction();

if ($action=='add') {
    
    $controller->add();

} elseif ($action=='edit') {

    $controller->edit((int) Request::getRoute(2));

} elseif ($action=='show') {

    $controller->show((int) Request::getRoute(2));

} else {

    $controller->index();
}