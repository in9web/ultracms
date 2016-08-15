<?php 
namespace Ultra;

class Config
{
    /**
     * Application Configs
     * @var array
     */
    public static $configs = array();
    
    public static function setConfig($name, $data)
    {
        static::$configs[$name] = $data;
    }

    public static function getConfig($name, $default=null)
    {
        if (isset(static::$configs[$name])) 
            return static::$configs[$name];

        return $default;
    }

    public static function getConfigs()
    {
        return static::$configs;
    }

    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public static function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) return static::value($default);

        switch (strtolower($value))
        {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return null;
        }
        
        if (strlen($value) > 1 && substr($value, 0, 1) == '"' && substr($value, -1) == '"') {
            return substr($value, 1, -1);
        }

        return $value;
    }

    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public static function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }

}