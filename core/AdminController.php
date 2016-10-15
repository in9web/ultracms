<?php 
namespace Ultra;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Stringy\StaticStringy as S;

class AdminController
{
    /**
     * Data to controller/view
     * @var array
     */
    public $data = array();

    public function __construct($data=array())
    {
        $this->data = array(
            'items_per_page'    => 10,
            'module_view'       => 'basic'
        );

        if (is_array($data) && count($data) > 0) {

            $this->data = array_merge($this->data, $data);

        }

        App::$log->debug('Admin Controller Created');

    }

    public function doFileUpload($uploadname, $description='', $return_model=false)
    {
        $adapter = new Local(STORAGEPATH);
        $filesystem = new Filesystem($adapter);
        
        $filename  = clear_filename($_FILES[$uploadname]['name']);
        $file_path = STORAGEPATH.'/uploads/'.$filename;

        $stream = fopen($_FILES[$uploadname]['tmp_name'], 'r+');
        $filesystem->writeStream($file_path, $stream);
        fclose($stream);

        $imgs_mimes = array(
            'image/x-png', 'image/png',
            'image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg', 'image/jpeg',
            'image/gif'
        );
        
        $file_data = array(
            'filename' => $filename,
            'full_path'=> $file_path,
            'file_dir' => STORAGEPATH.'/uploads/',
            'filesize' => $filesystem->getSize($file_path),
            'fullurl'  => base_url('storage/uploads/'.$filename),
            'is_image' => (bool) in_array($filesystem->getMimetype($file_path), $imgs_mimes),
            'mimetype' => $filesystem->getMimetype($file_path),
        );

        // save to database        
        $file = new \Ultra\Model\File;
        $file->description  = $description;
        $file->filename     = $file_data['filename'];
        $file->filetype     = $file_data['mimetype'];
        $file->filesize     = $file_data['filesize'];
        $file->full_url     = $file_data['fullurl'];
        $file->full_path    = $file_data['full_path'];
        $file->is_image     = ($file_data['is_image']) ? 'yes': 'no';
        $file->user_id      = get_user_session('id');
        $file->save();

        return ($return_model) ? $file : $file_data;

    }

    public function index()
    {
        $data = &$this->data;
        $module = $data['module'];
        $module_view = $data['module_view'];
        $model = $data['model'];
        $items_per_page = $data['items_per_page'];

        $page = Request::getRoute(3, 1); // default 1
        $total_items = $model::where('id', '>', 0)->count();
        $start = ($page - 1) * $items_per_page;

        $data['items'] = $model::where('id', '>', 0)->skip($start)->take($items_per_page)->get();
        $data['total_items'] = $total_items;
        $data['items_per_page'] = $items_per_page;
        $data['page'] = $page;

        get_theme_admin($module_view.'/index', $data);
    }

    public function show($id)
    {
        $data = &$this->data;
        $module = $data['module'];
        $module_view = $data['module_view'];
        $model = $data['model'];

        $item = $model::find($id);

        $data['item'] = $item;

        get_theme_admin($module_view.'/show', $data);
    }

    public function add()
    {
        $data = &$this->data;
        $module = $data['module'];
        $module_view = $data['module_view'];
        $model = $data['model'];

        $data['item'] = new $model;

        if (Input::isPost()) {

            //$item = User::create(Input::post());
            $item = $data['item'];

            foreach ($data['columns_add'] as $col => $col_opt) {
                
                // ignore id, if exists
                if ($col=='id') continue;

                if ($col_opt['input_type'] == 'file') {
                    
                    if (isset($_FILES[$col]['error']) && !is_array($_FILES[$col]['error']) && $_FILES[$col]['error'] == 0) {

                        $file = $this->doFileUpload($col);
                        $item->$col = $file['fullurl'];
                        
                    }

                } else {

                    $item->$col = Input::post($col, $item->$col);

                }

            }

            if ($item->save()) {
            
                Session::addFlashMessage('success', _t('Saved with success'));

            } else {

                Session::addFlashMessage('error', _t('Error on save this item'));
            }

            admin_redirect_uri('/'.$module);

        }

        get_theme_admin($module_view.'/form', $data);

    }

    public function edit($id)
    {
        $data = &$this->data;
        $module = $data['module'];
        $module_view = $data['module_view'];
        $model = $data['model'];

        // $id = (int) Request::getRoute(2);

        $item = $model::find($id);

        if (Input::isPost()) {

            foreach ($data['columns_edit'] as $col => $col_opt) {
                
                // ignore id, if exists. Security
                if ($col=='id') continue;

                if ($col_opt['input_type'] == 'file') {
                    
                    if (isset($_FILES[$col]['error']) && !is_array($_FILES[$col]['error']) && $_FILES[$col]['error'] == 0) {

                        $file = $this->doFileUpload($col);
                        $item->$col = $file['fullurl'];
                        
                    }

                } else {

                    $item->$col = Input::post($col, $item->$col);

                }
            }

            if ($item->save()) {
            
                Session::addFlashMessage('success', _t('Saved with success'));

            } else {

                Session::addFlashMessage('error', _t('Error on save this item'));
            }


            admin_redirect_uri('/'.$module);

        }

        $data['item'] = $item;

        get_theme_admin($module_view.'/form', $data);
    }
    
    public function delete($id)
    {
        $data = &$this->data;
        $module = $data['module'];
        $model = $data['model'];

        $id = (int) Request::getRoute(2);

        if ($model::destroy($id)) {
            
            Session::addFlashMessage('success', _t('Removed with success'));

        } else {

            Session::addFlashMessage('error', _t('Error on remove this item'));
        }

        admin_redirect_uri('/'.$module);

    }

}