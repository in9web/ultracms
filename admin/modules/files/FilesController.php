<?php 
use Ultra\Admin;
use Ultra\AdminController;
use Ultra\Input;
use Ultra\Request;
use Ultra\Session;

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
    
}