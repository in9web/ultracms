<?php 
namespace Ultra;

class App
{
    /**
     * Helpers loaded
     * @var array
     */
    public static $helpers;

    /**
     * Libraries loaded
     * @var array
     */
    public static $libraries;

    /**
     * Instance of Monolog
     * @var object
     */
    public static $log;

    /**
     * Translations
     * @var array
     */
    public static $lang = array();

    /**
     * Start basic application to use
     * @return boolean Return true or false if is ok
     */
    public function bootstrap()
    {
        /// default error log
        $logger = Config::getConfig('logger');
        
        // start monolog
        // 
        // create a log channel
        static::$log = new \Monolog\Logger($logger['name']);
        static::$log->pushHandler(new \Monolog\Handler\StreamHandler($logger['path'], $logger['path']));
        // static::$log->pushHandler(new Monolog\Handler\FirePHPHandler());
        
        // load required helpers
        App::loadHelper(['core', 'language']);

        // load routes
        Request::loadRoutes();
        
        // start session
        Session::start();
        
        // ini_set('log_errors', 1);               // 1 = php save log to file
        // ini_set('error_log', $logger['path']);  // file to save logs

        // Load language core
        static::getTranslation('core');
    }

    /**
     * Load helpers
     * Created 2016-07-20
     * @author Wallace Silva <contato@wallacesilva.com>
     */
    public static function loadHelper($helper)
    {
        if (is_array($helper) && count($helper) > 0) {
            
            $results = false;

            foreach ($helper as $item)
                $results = static::loadHelper($item);

            return $results;
        }

        if( !is_string($helper) )
            return false;

        if( strlen($helper) < 1 )
            return false;

        if( is_array(static::$helpers) && in_array($helper, static::$helpers) )
            return true;

        if( !file_exists(COREPATH. '/helpers/' .$helper .'.php') )
            return false;

        require_once(COREPATH. '/helpers/' .$helper .'.php');

        if (!isset(static::$helpers))
            static::$helpers = array();

        static::$helpers[] = $helper;

        App::$log->debug('Loaded Helper: '.$helper);

    }

    /**
     * Load libraries
     * Created 2016-07-20
     * @author Wallace Silva <contato@wallacesilva.com>
     */
    public static function loadLibrary($library)
    {
        if (is_array($library) && count($library) > 0) {
            
            $results = false;
            
            foreach ($library as $item)
                $results = static::loadLibrary($item);
            
            return $results;
        }

        if( !is_string($library) )
            return false;

        if( is_array(static::$libraries) && in_array($library, static::$libraries) )
            return true;

        if( !file_exists(SYSPATH. '/libraries/' .$library .'.php') )
            return false;

        require_once(SYSPATH. '/libraries/' .$library .'.php');

        if (!isset(static::$libraries))
            static::$libraries = array();

        static::$libraries[] = $library;

        // auto instanciate
        $class_lib = ucfirst($library);

        App::$log->debug('Loaded Library: '.$library);

        if (!class_exists($class_lib))
            return false;

        return new $class_lib();

    }

    public static function setLang($code=null)
    {
        $code = is_null($code) ? Config::getConfig('language_locale') : $code;
        return Session::setItem('ultra_lang', $code);
    }

    public static function getLang($default=null)
    {
        $default = is_null($default) ? Config::getConfig('language_locale') : $default;
        return Session::getItem('ultra_lang', $default);
    }

    public static function getTranslation($filecode)
    {
        $file = COREPATH.'/languages/'.static::getLang().'/'.$filecode.'.php';

        if (file_exists($file)) {

            $tmp_arr_code = (array) include_once($file);
            static::$lang = array_merge(static::$lang, $tmp_arr_code);

        }
    }

    public static function addTranslation($translations)
    {
        if (is_array($translations))
            static::$lang = array_merge(static::$lang, $translations);
    }
}