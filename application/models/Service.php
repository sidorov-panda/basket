<?php

require_once APPLICATION_PATH . '/models/BasketAbstract.php';

class Service extends BasketAbstract {

    public static $applications = array(
        'cruise'    => 'Круиз',
        'FIT'       => 'Ланта FIT'
    );

    protected $_service = NULL;

    protected function __init__() {
        $this->_service = new StorageService();
    }

    public function get() {
        return $this->_service->get($this->_session);
    }

    public function getByTouristId($id) {
        $id = (int) $id;
        if (!$id || $id < 1) {
            return false;
        }
        return $this->_getAdapter()->getByTouristId($id);
    }

}