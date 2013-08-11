<?php

require_once 'Zend/Db/Adapter/Pdo/Pgsql.php';

//TODO переписать класс, поменять название
class StorageResourcePgAdapter {

    private $_adapter = NULL;
    public static $instance = NULL;

    public static function getInstance() {
        if (!isset(self::$instance)
                || !(self::$instance instanceof Zend_Db_Adapter_Pdo_Pgsql)
        ) {
            $self = new self;
            return $self->_adapter;
        } else {
            return self::$instance;
        }
    }

    private function __construct() {
        $configPath = CONFIG_PATH . 'storages.ini';
        $options['nestSeparator'] = '.';
        $config = new Zend_Config_Ini($configPath,
                        'BasketStorage',
                        $options);

        $host = $config->BasketStorage->storage->host;
        $port = $config->BasketStorage->storage->port;
        $username = $config->BasketStorage->storage->username;
        $password = $config->BasketStorage->storage->password;
        $dbname = $config->BasketStorage->storage->dbname;

        $params = array(
            'host' => $host,
            'username' => $username,
            'password' => $password,
            'dbname' => $dbname,
            'port' => $port,
            'profiler' => true
        );
        $this->_adapter = Zend_Db::factory('PDO_PGSQL', $params);
    }

    private function  __clone() {
        return false;
    }

}

