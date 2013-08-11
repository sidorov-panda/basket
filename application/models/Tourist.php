<?php

require_once APPLICATION_PATH . '/models/BasketAbstract.php';

//require_once APPLICATION_PATH . '/models/StorageTourist.php';
//require_once APPLICATION_PATH . '/models/StorageSession.php';
//require_once APPLICATION_PATH . '/models/StorageService.php';

class Tourist extends BasketAbstract {

    public function getBySessionId($sid) {
        if (!intval($sid) || intval($sid) < 1) {
            return false;
        }
        $sid = (int)$sid;
        return $this->_getAdapter()->getBySessionId($sid);
    }

    public function get(array $params) {
        if (count($params) < 1) {
            return false;
        }
        return $this->_getAdapter()->get($params);
    }

}