<?php 
use Ultra\Admin;
use Ultra\AdminController;
use Ultra\Input;
use Ultra\Request;
use Ultra\Session;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class FilesController extends AdminController
{
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

            $col = 'userfile';

            if (isset($_FILES[$col]['error']) && !is_array($_FILES[$col]['error']) && $_FILES[$col]['error'] == 0) {
                
                $description = Input::post('description', '');
                $item = $this->doFileUpload($col, $description, true);

                //if ($item->save()) {
                if (isset($item->id) && (int)$item->id > 0 ) {
                
                    Session::addFlashMessage('success', _t('Saved with success'));

                } else {

                    Session::addFlashMessage('error', _t('Error on save this item'));
                }

                admin_redirect_uri('/'.$module);

            } else{

                Session::addFlashMessage('error', _t('Error on upload of file'));
                admin_redirect_uri('/'.$module);

            }

        }

        get_theme_admin($module_view.'/form', $data);

    }

    public function delete($id)
    {
        $data = &$this->data;
        $module = $data['module'];
        $model = $data['model'];

        $id = (int) Request::getRoute(2);

        $filedb = $model::find($id);

        if (empty($filedb)) {

            Session::addFlashMessage('error', _t('Error on remove this item'));
            admin_redirect_uri('/'.$module);

        }

        $adapter = new Local(STORAGEPATH);
        $filesystem = new Filesystem($adapter);
        
        $filesystem->delete($filedb->full_path);

        if ($filedb->delete()) {

            Session::addFlashMessage('success', _t('Removed with success'));

        } else {
            
            Session::addFlashMessage('error', _t('Error on remove this item'));
            
        }

        admin_redirect_uri('/'.$module);

    }
    
}