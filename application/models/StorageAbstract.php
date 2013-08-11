<?php

require_once APPLICATION_PATH . '/models/StorageSessionAdapter.php';
require_once APPLICATION_PATH . '/models/StorageTouristAdapter.php';
require_once APPLICATION_PATH . '/models/StorageServiceAdapter.php';
require_once APPLICATION_PATH . '/models/StorageOrderAdapter.php';

abstract class StorageAbstract {

    //Адаптер хранилища
    protected $_adapter = NULL;

    /*
     * Метод возвращает адаптер
     */
    public function getAdapter() {
        return $this->_adapter;
    }

    /*
     * Конструктор класса, здесь инициализируется адаптер хранилища.
     */

    public function __construct() {
        $className = get_called_class() . 'Adapter';
        $this->_adapter = new $className;
    }

    /*
     * Метод отдает данные из хранилища по сессии
     *
     * <StorageSession> $session - Объект класса сессии хранилища
     * return <Zend_Db_Table_Rowset> Возвращает информацию из хранилища.
     *
     */

    public function get(StorageSession $session) {
        return $this->_adapter->get($session);
    }

    /*
     * <StorageSession> $session - Объект класса сессии хранилища
     * <array> $set - Ассоциативный массив
     */

    public function set(StorageSession $session, $set) {
        return $this->_adapter->set($session, $set);
    }

}