<?php

require_once APPLICATION_PATH . '/models/StorageAbstract.php';

class StorageSession extends StorageAbstract {

    //Ключ сессии
    private $_key = NULL;
    //Переменна, хранящая подгруженную сессию
    private $_session = NULL;

    public function __construct($key) {
        parent::__construct();
        $this->_load($key);
    }

    private function _load($key = '') {
        $this->_key = $key;
        $get = $this->get($this);
        if (!$get || empty($get)) {
            $this->set($this);
        }

        $this->_session = $this->get($this);
        return ;
    }

    private function _isLoaded() {
        if (isset($this->_session) && is_object($this->_session)) {
            return true;
        }
        return false;
    }

    public function getId() {
        if ($this->_isLoaded()) {
            return $this->_session->id;
        }
    }

    public function getKey() {
        return $this->_key;
    }

    public function set(StorageSession $session, $set = array()) {
        $set['key'] = $this->getKey();
        return $this->_adapter->set($session, $set);
    }

}