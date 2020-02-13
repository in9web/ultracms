<?php 
use Ultra\Admin;
use Ultra\AdminController;
use Ultra\Input;
use Ultra\Model\User;
use Ultra\Request;
use Ultra\Session;

// Get Module Configs
$data = require('config.php');

// include_once('UserController.php');

class UserController extends AdminController
{
    public function profile()
    {
        $id = (int) get_user_session('id');
        $this->edit($id);
    }

    public function password($id)
    {
        $data = &$this->data;
        $module = $data['module'];
        $model = $data['model'];
        $data['columns_add'] = array();
        $data['columns_add'] = array(
            'password' => array('input_type' => 'password'), 
            'password_confirm' => array('input_type' => 'password')
        );

        $item = $model::find($id);

        if (Input::isPost()) {

            if (Input::post('password') != Input::post('password_confirm')) {

                Session::addFlashMessage('error', _t('Password dont match'));
                admin_redirect_uri('/'.$module.'/password/'.$id);

            }

            $item->password = Input::post('password');

            if ($item->save()) {
            
                Session::addFlashMessage('success', _t('Saved with success'));

            } else {

                Session::addFlashMessage('error', _t('Error on save this item'));
            }

            admin_redirect_uri('/'.$module);

        }

        $data['item'] = $item;

        get_theme_admin($module.'/form', $data);
    }
}

$uc = new UserController($data);

$action = Admin::getRequestModuleAction();

if ($action=='add') {
    
    $uc->add();

} elseif ($action=='edit') {

    $uc->edit((int) Request::getRoute(2));

} elseif ($action=='password') {
    
    $uc->password((int) Request::getRoute(2));

} elseif ($action=='profile') {

    $uc->profile();

} elseif ($action=='delete') {
    
    $uc->delete((int) Request::getRoute(2));

} elseif ($action=='show') {

    $uc->show((int) Request::getRoute(2));

} else {

    $uc->index();
}