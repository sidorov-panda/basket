<?php

abstract class StorageAdapterAbstract extends Zend_Db_Table_Abstract {

    //Zend адаптер
    protected $_db = NULL;

    public function __construct() {
        //Явно указываем адаптер для этой модели, чтобы была возможность использовать разные адаптеры в разных моделях.
        $adapter = StorageResourceAdapterFactory::factory('Pg');
        Zend_Db_Table_Abstract::setDefaultAdapter($adapter);
        $this->_db = $adapter;
        $this->__init__();
    }

    protected function __init__() {

    }

    abstract function get(StorageSession $session);

    abstract function set(StorageSession $session, $set = array());
}