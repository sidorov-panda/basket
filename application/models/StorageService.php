<?php

require_once APPLICATION_PATH . '/models/StorageAbstract.php';

final class StorageService extends StorageAbstract {

    protected $_id = NULL;
    protected $_data = NULL;

    public function __construct($id = NULL) {
        parent::__construct();
        if (intval($id) > 0) {
            $this->_id = $id;
            $this->_load();
        }
    }

    //public function gets

    public function getById($ids) {
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        return $this->getAdapter()->getById($ids);
    }

    public function getBySession(StorageSession $session) {
        return $this->get($session);
    }

    public function _load() {
        $this->getById($this->_id);
    }

}