<?php 

$data = array();

// Module infos
$data['module'] = 'users';
$data['module_name'] = 'Users';
$data['module_view'] = 'users';
$data['module_uri'] = '/users';
$data['module_icon'] = 'user';
$data['module_menu_position'] = 99;

// Module Class Name (with namespace)
$data['model'] = '\Ultra\Model\User';

// default list of items to index/list
$data['items'] = null;

// Columns to show on index/list
$data['columns'] = array('id', 'name', 'email', 'created_at');

// Columns to show on show item
$data['columns_show'] = array('id', 'name', 'email', 'created_at');
//
// $data['items_per_page'] = 10;

// Columns to edit on add/form
$data['columns_add'] = array(
    'name' => array('input_type' => 'text'), 
    'email' => array('input_type' => 'text'),
    'password' => array('input_type' => 'password'),
);

// Columns to edit on edit/form
$data['columns_edit'] = array(
    'name' => array('input_type' => 'text'), 
    'email' => array('input_type' => 'text')
);

$data['columns_required'] = array(
    'name', 
    'email'
);

return $data;