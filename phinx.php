<?php
require_once('config.php');

return array(
    "paths"         => array(
        "migrations"    => COREPATH."/database/migrations",
        "seeds"         => COREPATH."/database/seeds"
    ),
    "environments"  => array(
        "default_migration_table"   => "phinxlog",
        "default_database"          => "defauldb",
        "defauldb" => array(
            "adapter"   => env('DB_CONNECTION', "sqlite"),
            "host"      => env("DB_HOST", "localhost"),
            "name"      => env("DB_NAME", STORAGEPATH."/database.sqlite"),
            "user"      => env("DB_USER", "root"),
            "pass"      => env("DB_PASS", ''),
            "port"      => env("DB_PORT", ''),
            "charset"   => env("DB_CHARSET", 'utf8'),
            /*"name"      => "dev_db",
            "connection" => $pdo_instance*/
        )
    )
);