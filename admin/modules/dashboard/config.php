<?php 

$data = array();

// Module infos
$data['module'] = 'dashboard';
$data['module_name'] = 'Dashboard';
$data['module_view'] = 'dashboard';
$data['module_uri'] = '/dashboard';
$data['module_icon'] = 'home';
$data['module_menu_position'] = 0;

// Module Class Name (with namespace)
$data['model'] = null;

// default list of items to index/list
$data['items'] = null;

// Columns to show on index/list
$data['columns'] = array('id', 'name', 'created_at');

// Columns to show on show item
$data['columns'] = array('id', 'name', 'created_at');
//
// $data['items_per_page'] = 10;

// Columns to edit on add/form
$data['columns_add'] = array(
    'name' => array('input_type' => 'text'), 
);

// Columns to edit on edit/form
$data['columns_edit'] = array(
    'name' => array('input_type' => 'text'), 
);

$data['columns_required'] = array(
    'name', 
);

return $data;