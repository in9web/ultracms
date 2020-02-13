<?php 
namespace Ultra;

class Admin
{
    /**
     * Data to configure admin
     * @var array
     */
    public static $data = array();
    
    /**
     * Menu Admin configs
     * @var array
     */
    public static $menu = array();

    /**
     * Start basic application to use
     * @return boolean Return true or false if is ok
     */
    public static function bootstrap($data=null)
    {
        // load required helpers for admin
        App::loadHelper(['admin', 'url']);

        // Load language core
        App::getTranslation('core');

        // default data
        static::$data['modules_dir'] = 'modules/';

        if (is_array($data) && count($data) > 0)
            static::$data = array_merge(static::$data, $data);

        App::$log->debug('Admin Bootstrap started');
    }

    public static function getRequestModuleName($default='dashboard')
    {
        $module_name = Request::getRoute(0);
        return !empty($module_name) ? $module_name : $default;
    }

    public static function getRequestModuleAction()
    {
        $module_action = Request::getRoute(1);
        return $module_action;
    }

    /**
     * Admin check is user logged
     * @return boolean Return true if user logged or false 
     */
    public static function adminUserLogged()
    {
        if (isset($_SESSION['core_user']['id']) && $_SESSION['core_user']['id'] > 0) {
          
            return true; // user logged
          
        } 
        
        return false; // user logoff
    }
    
    /**
     * Admin do logout
     * @param  string $url_redirect Url to redirect after logout
     * @return void
     */
    public static function adminLogout($url_redirect)
    {
        unset($_SESSION['core_user']);
        redirect($url_redirect);
    }

    public static function adminLoadModules($modules_dir)
    {
        if (!is_dir($modules_dir))
            throw new Exception("Folder modules not found: ".$modules_dir, 1);
            
        $diropen = opendir($modules_dir);

        while ($file = readdir($diropen)) {

            // ignore local positions
            if (in_array($file, array('.', '..')))
                continue;

            // check and load bootstrap module
            if (file_exists($modules_dir.$file."/bootstrap.php")) {
                include_once($modules_dir.$file."/bootstrap.php");
            }

        }

        App::$log->debug('Admin Modules Loaded');
    }

    public static function adminStartModules($module)
    {
        $theme_admin = 'themes/'.\Ultra\Config::getConfig('admin_theme_name');

        $module_file = static::$data['modules_dir'].$module.'/'.$module.'.php';

        if (file_exists($module_file)) {
            
            include_once $module_file;
            App::$log->debug('Admin Module Started - '.$module);

        } else {

            include_once $theme_admin .'/404.php';
            App::$log->debug('Admin Module Not Found - '.$module);
            die();

        }
    }

    /**
     * addModuleTranslation If exists add module translation to default locale
     * @param string $modules_dir Path to module folder  
     */
    public static function addModuleTranslation($modules_dir)
    {
        $file_trans = $modules_dir.'/languages/'.Config::getConfig('language_locale').'.php';
        
        if (file_exists($file_trans)) {

            $translations = include($file_trans);
            App::addTranslation($translations);

        }

    }

    public static function addMenu($name, $uri, $icon_code=null, $position=null, $permission=null)
    {
        $menu = array(
            'name'  => $name,
            'uri'   => $uri,
            'icon'  => $icon_code
        );

        // FIX ME, check user permission to see this item menu, example: https://developer.wordpress.org/reference/functions/add_menu_page/#source
        // $permission

        if (null == $position) {

            static::$menu[] = $menu;

        } elseif(isset(static::$menu[$position])) {

            $position = $position + substr( base_convert( md5( $uri . $name ), 16, 10 ) , -5 ) * 0.00001;

            static::$menu["$position"] = $menu;
            
        } else {
            
            static::$menu[$position] = $menu;

        }

        // on future add feature to submenu items
    }

    public static function getMenu()
    {
        asort(static::$menu);
        return static::$menu;
    }
}