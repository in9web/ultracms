<?php 
use Ultra\App;
use Ultra\Config;

// error logs
ini_set("log_errors", "on");
ini_set("error_log", "../storage/log/php_error.log");

/*
 * Load COMPOSER autoload to use external libraries and components
 */
if ( file_exists(dirname(__DIR__).'/vendor/autoload.php') )
    require_once dirname(__DIR__).'/vendor/autoload.php';

/*
 * Load DotEnv
 */
if (class_exists('Dotenv\Dotenv') && file_exists(dirname(__DIR__).'/.env')){
    $dotenv = Dotenv\Dotenv::create(dirname(__DIR__));
    $dotenv->load();
}

// load Class config
require_once(__DIR__.'/Config.php');

/*
 * Load Config File
 */
require_once(dirname(__DIR__).'/config.php');

// Display php errors
if (Config::getConfig('display_errors') == true) {
    
    ini_set('display_errors', 'on');

} else {

    ini_set('display_errors', 'off');

}

$app = new \Ultra\App;

$app->bootstrap();

// Load database
if (Config::getConfig('db')['autoload'] === true) {

    // Load Database/Eloquent
    $capsule = new \Illuminate\Database\Capsule\Manager; // use Illuminate\Database\Capsule\Manager as Capsule;

    $dbname = Config::getConfig('db')['database'];
    
    if (file_exists(BASEPATH.'/'.Config::getConfig('db')['database'])) 
        $dbname = BASEPATH.'/'.Config::getConfig('db')['database'];

    $capsule->addConnection([
        'driver'    => Config::getConfig('db')['dbdriver'],
        'host'      => Config::getConfig('db')['hostname'],
        'database'  => $dbname,
        'username'  => Config::getConfig('db')['username'],
        'password'  => Config::getConfig('db')['password'],
        'charset'   => Config::getConfig('db')['char_set'],
        'collation' => Config::getConfig('db')['dbcollat'],
        'prefix'    => Config::getConfig('db')['dbprefix'],
    ]);

    // Set the event dispatcher used by Eloquent models... (optional)
    // use Illuminate\Events\Dispatcher;
    // use Illuminate\Container\Container;
    $events = new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container);

    $events->listen('illuminate.query', function($query, $bindings, $time, $name)
    {
        // Format binding data for sql insertion
        foreach ($bindings as $i => $binding) {

            if ($binding instanceof \DateTime) {

                $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');

            } else if (is_string($binding)) {

                $bindings[$i] = "'$binding'";

            }

        }       

        // Insert bindings into query
        $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
        $query = vsprintf($query, $bindings);

        App::$log->info('SQL QUERY: '.$query);

    });

    $capsule->setEventDispatcher($events);

    // Make this Capsule instance available globally via static methods... (optional)
    $capsule->setAsGlobal();

    // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
    $capsule->bootEloquent();
}

// return App
return $app;