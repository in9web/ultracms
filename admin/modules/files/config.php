<?php 

$data = array();

// Module infos
$data['module']         = 'files';
$data['module_name']    = 'Files';
$data['module_view']    = 'files';
$data['module_uri']     = '/files';
$data['module_icon']    = 'file';
$data['module_menu_position'] = 90;

// Module Class Name (with namespace)
$data['model'] = '\Ultra\Model\File';

// default list of items to index/list
$data['items'] = null;

// Columns to show on index/list
$data['columns'] = array('id', 'description', 'created_at');

// Columns to show on show item
$data['columns_show'] = array('id', 'description', 'created_at');
//
// $data['items_per_page'] = 10;

// Columns to edit on add/form
$data['columns_add'] = array(
    'description' => array('input_type' => 'text'),
    'userfile' => array('input_type' => 'file'),
);

// Columns to edit on edit/form
$data['columns_edit'] = array(
    'description' => array('input_type' => 'text'),
);

$data['columns_required'] = array(
    'description', 
);

return $data;

/*
/storage/uploads/filem-name-2015.jpg original size
/storage/uploads/thumbnail/filem-name-2015.jpg 150x150
/storage/uploads/medium/filem-name-2015.jpg 300x300
/storage/uploads/large/filem-name-2015.jpg 640x640
 */