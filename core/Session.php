<?php 
namespace Ultra;

class Session
{
    /**
     * Flash key
     * @var string
     */
    public static $flash_key = 'ultra_flash';

    /**
     * Local to storage infos from session
     * @var object
     */
    public static $storage;

    /**
     * Items from previews request
     * @var array
     */
    public static $fromPrevious = [];

    /**
     * Start session with infos
     * @return void
     */
    public static function start()
    {
        // redefine path to save sessions
        session_save_path(\storage_path('/sessions'));

        // start php session
        session_start();

        // get session var
        static::$storage =& $_SESSION;

        // Load messages from previous request
        if (isset(static::$storage[static::$flash_key]) && is_array(static::$storage[static::$flash_key])) {
            static::$fromPrevious = static::$storage[static::$flash_key];
        }
        
        // clear flash messages from session
        static::$storage[static::$flash_key] = [];
    }

    public static function setItem($name, $data)
    {
        $_SESSION[$name] = $data;
    }

    /**
     * Get item stored on session
     * @param  string $name    Name to item saved on session
     * @param  string $default Default to return if item is empty
     * @return string          Content of item stored
     */
    public static function getItem($name, $default=null)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : $default;
    }

    /**
     * Clear item of Session. this not clear all session, only the item
     * @param  string $name Name of field on session
     * @return void         Dont return anythng
     */
    public static function clearItem($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * Add flash message to session on next request this is cleared
     * @param string $key       Key to store values
     * @param string $message   Message to add
     */
    public static function addFlashMessage($key, $message)
    {
        //Create Array for this key
        if (!isset(static::$storage[static::$flash_key][$key])) {
            static::$storage[static::$flash_key][$key] = array();
        }

        static::$storage[static::$flash_key][$key][] = $message;
    }

    /**
     * Get flash messages
     * @return array Messages to show for current request
     */
    public static function getFlashMessages()
    {
        return static::$fromPrevious;
    }

    /**
     * Get Flash Message
     * @param string $key The key to get the message from
     * @return mixed|null Returns the message
     */
    public static function getMessage($key, $default=null)
    {
        //If the key exists then return all messages or null
        return (isset(static::$fromPrevious[$key])) ? static::$fromPrevious[$key] : $default;
    }
}