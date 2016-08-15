<?php 
namespace Ultra;

class Request
{
    /**
     * Routes 
     * @var array
     */
    public static $routes;

    public static function getCurrentUri()
    {
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
        
        if (strstr($uri, '?')) 
            $uri = substr($uri, 0, strpos($uri, '?'));
        
        $uri = '/' . trim($uri, '/');
        
        //return str_replace('//', '/', $uri);
        return $uri;
    }

    public static function loadRoutes()
    {
        $base_url = static::getCurrentUri();

        static::$routes = $routes = array();
        $routes = explode('/', $base_url);

        foreach($routes as $route) {
            if (trim($route) != '')
                array_push(static::$routes, trim($route));
        }
    }

    public static function getRoutes()
    {
        return static::$routes;
    }

    /**
     * Get a route on object array
     * @param  integer $item    Id to route
     * @param  mixed $default Return this value if not existe route
     * @return string          Return item or default
     */
    public static function getRoute($item, $default=null)
    {
        return isset(static::$routes[$item]) ? static::$routes[$item] : $default;
    }
}