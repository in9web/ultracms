<?php 
use Ultra\Config;

/* Load DotEnv */
if (class_exists('Dotenv\Dotenv') && file_exists(__DIR__.'/.env')){
    $dotenv = Dotenv\Dotenv::create(__DIR__);
    $dotenv->load();
}


/**
 * Default configurations
 */
define('BASEPATH',      dirname(__FILE__));
define('ABSPATH',       BASEPATH); // fallback
define('COREDIRNAME',   'core');
define('COREPATH',      BASEPATH .'/' .COREDIRNAME);
define('STORAGEPATH',   BASEPATH .'/storage');
define('LOGPATH',       STORAGEPATH .'/logs');
define('CACHEPATH',     STORAGEPATH .'/cache');
define('ADMIN_PATH',    BASEPATH . '/admin');
define('ULTRANAME',     'UltraCMS');

// default names
Config::setConfig('admin_dirname',  Config::env('ADMIN_DIRNAME', 'admin'));
Config::setConfig('assets_dirname', Config::env('ASSETS_DIRNAME', 'assets'));
Config::setConfig('admin_theme_name',Config::env('ADMIN_THEME_NAME', 'default'));
Config::setConfig('theme_name',     Config::env('THEME_NAME', 'default'));

// Paths configs
Config::setConfig('base_path',      dirname(__FILE__));
Config::setConfig('core_path',      dirname(__FILE__).'/core');
Config::setConfig('storage_path',   dirname(__FILE__).'/storage');
Config::setConfig('log_path',       dirname(__FILE__).'/logs');
Config::setConfig('cache_path',     dirname(__FILE__).'/cache');
Config::setConfig('assets_path',    dirname(__FILE__).'/'.Config::getConfig('assets_dirname'));
Config::setConfig('admin_path',     dirname(__FILE__).'/'.Config::getConfig('admin_dirname'));

// Url configs
Config::setConfig('base_url',       Config::env('BASE_URL', '/'));
Config::setConfig('storage_url',    Config::env('STORAGE_URL', '/storage/'));
Config::setConfig('admin_base_url', Config::getConfig('base_url').'/'.Config::getConfig('admin_dirname'));
Config::setConfig('assets_url',     Config::getConfig('base_url').'/'.Config::getConfig('assets_dirname'));

// Locale configs
Config::setConfig('language',       Config::env('LANGUAGE', 'portuguese'));
Config::setConfig('language_code',  Config::env('LANGUAGE_CODE', 'pt-BR'));
Config::setConfig('language_locale',Config::env('LANGUAGE_LOCALE', 'pt_BR'));
Config::setConfig('locale_date_fmt',Config::env('LOCALE_DATE_FMT', 'd/m/Y'));
Config::setConfig('locale_time_fmt',Config::env('LOCALE_TIME_FMT', 'H:i'));

// Debug
Config::setConfig('debug',          Config::env('APP_DEBUG', false));

// Display php erros
Config::setConfig('display_errors', Config::env('APP_DISPLAY_ERRORS', false));

// Encryption Key. Session, CRSF, ...
Config::setConfig('encryption_key', Config::env('APP_KEY', 'in9forever'));

// Monolog
Config::setConfig('logger', array(
    'name'  => 'coreapp', 
    'level' => Config::env('APP_LOG_LEVEL', 300), // 300:WARNING, see https://github.com/Seldaek/monolog/blob/master/doc/01-usage.md#log-levels
    'path'  => LOGPATH . '/' . date('Y-m-d_H-i').'.log'
));

// Database connection configurations 
Config::setConfig('db', array(
    'autoload' => Config::env('DB_AUTOLOAD', false),
    'dsn'      => '',
    'hostname' => Config::env('DB_HOST', 'localhost'),
    'username' => Config::env('DB_USER', 'root'),
    'password' => Config::env('DB_PASS', ''),
    'database' => Config::env('DB_NAME', STORAGEPATH.'/database.sqlite'),
    'dbdriver' => Config::env('DB_CONNECTION', 'sqlite'),
    'dbprefix' => Config::env('DB_PREFIX', ''),
    'pconnect' => Config::env('DB_PCONNECT', FALSE),
    'db_debug' => Config::env('DB_DEBUG', true),
    'cache_on' => Config::env('DB_CACHE_ON', FALSE),
    'cachedir' => Config::env('DB_CACHEDIR', ''),
    'char_set' => Config::env('DB_CHARSET', 'utf8'),
    'dbcollat' => Config::env('DB_COLLATION', 'utf8_general_ci')
));

// Send Mail Configurations, see PHPMailer docs, https://phpmailer.github.io/PHPMailer/
Config::setConfig('mail', array(
    'protocol'      => Config::env('MAIL_PROTOCOL',     'mail'), # mail(php), smtp, sendmail, // PHPMailer
    'mailtype'      => Config::env('MAILTYPE',          'text'), # or html
));

// SMTP Configurations
Config::setConfig('smtp', array(
    'SMTP_CRYPTO'   => Config::env('SMTP_CRYPTO',   'ssl'), # tls
    'SMTP_HOST'     => Config::env('SMTP_HOST',     'smtp.mailgun.org'), # smtp.mandrillapp.com 
    'SMTP_USER'     => Config::env('SMTP_USER',     ''), # 
    'SMTP_PASS'     => Config::env('SMTP_PASS',     ''), 
    'SMTP_PORT'     => Config::env('SMTP_PORT',     '465'),
    'SMTP_TIMEOUT'  => Config::env('SMTP_TIMEOUT',  '5'),
    'SMTP_CHARSET'  => Config::env('SMTP_CHARSET',  'utf-8'),
    'SMTP_MAILTYPE' => Config::env('MAILTYPE',      'text'), # or html
));

// Auth required admin
Config::setConfig('admin_auth_required', Config::env('ADMIN_AUTH_REQUIRED', true));

// Uplaod files config
Config::setConfig('upload_allowed_types', Config::env('UPLOAD_ALLOWED_TYPES', ''));

if (!function_exists('env')) {
    function env($item, $default=null) 
    {
        return Ultra\Config::env($item, $default);
    }
}
