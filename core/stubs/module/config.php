<?php 

$data = array();

// Module infos
$data['module']         = 'dummy_slug';
$data['module_name']    = 'dummy_name';
$data['module_view']    = 'dummy_view';
$data['module_uri']     = '/dummy_uri';
$data['module_icon']    = 'dummy_icon';
$data['module_menu_position'] = dummy_position;

// Module Class Name (with namespace)
$data['model'] = '\Ultra\Model\dummy_model_name';

// default list of items to index/list
$data['items'] = null;

// Columns to show on index/list
$data['columns'] = array('id', 'name', 'created_at');

// Columns to show on show item
$data['columns_show'] = array('id', 'name', 'created_at');
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