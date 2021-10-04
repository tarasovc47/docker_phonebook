<?php

namespace system\core;

use PDO;

/**
 * Класс для подключения к БД
 */
class Db
{
    private static $db = null;

    public static function getConnection()
    {
        if (!self::$db) # если экземпляр класса уже создан
        {
            $params = require ROOT . 'config/db.php';
            self::$db = new PDO(
                $params['dsn'],
                $params['user'],
                $params['password'],
                [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
            );
        }
        return self::$db;
    }
    public function __clone() {}
    public function __wakeup() {}
}