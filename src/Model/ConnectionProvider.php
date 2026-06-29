<?php

namespace App\Model;

class ConnectionProvider
{
    private const PATH_CONF = './config.ini';

    private static function connectConfig(): array {
        if (!file_exists(self::PATH_CONF)) {
            throw new RuntimeException('The ' . PATH_CONF . ' does not exist');
        }

        $config = parse_ini_file(self::PATH_CONF);

        $requiredKeysConf = ['host', 'dbname', 'user', 'password'];
        foreach ($requiredKeysConf as $key) {
            if (!isset($config[$key])) {
                throw new RuntimeException("The $key field is missing in the config.");
            }
        }
        return $config;
    }

    public static function connectDatabase(): \PDO
    {
        $config = ConnectionProvider::connectConfig();
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';';
        $user = $config['user'];
        $password = $config['password'];
        $option = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];

        return new \PDO($dsn, $user, $password, $option);
    }
}