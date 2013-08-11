<?php

require_once APPLICATION_PATH . '/models/StorageAdapterAbstract.php';

Final class StorageOrderAdapter extends StorageAdapterAbstract {

    //Задаем название таблицы
    protected $_name = 'storage_order';
    //Задаем название последовательность, которая генерит id для таблицы модели, т.к. PG не поддерживает автоинкремент,
    //честно говоря не знаю, есть ли в этом необходимость, т.к. данные из последовательности автоматои идут в таблицу
    protected $_sequence = 'storage_order_seq';

    function get(StorageSession $session) {

        $row = $this->fetchRow(
                                $this->select()
                                ->where('session_id = :sid')
                                ->where('annuled != TRUE')
                                ->bind(array(':sid' => $session->getId()))
                                ->order('id DESC')
                                ->limit(1)
        );
        if (empty($row) || !is_object($row)) {
            $this->_insert($session->getId(), array());
            return $this->get($session);
        }
        return $row;
    }

    function set(StorageSession $session, $set = array()) {
        
        //Не передавать пустую сессию
        if (strlen($session->getId()) < 1) {
            return false;
        }
        $set['annuled'] = 'FALSE';
        $set['session_id'] = $session->getId();
        $get = $this->get($session);
        if (!empty($get) || !is_object($get)) {
            $this->_insert($session->getId(), $set);
        } else {
            $this->_update($session->getId(), $set);
        }
    }

    private function _update($sessionId, $set = array()) {
        $where = $this->_db->quoteInto('session_id = ?', $sessionId);
        return $this->_db->update($this->_name, $set, $where);
    }

    private function _insert($sessionId, $set) {
        $set['session_id'] = $sessionId;
        return $this->_db->insert($this->_name, $set);
    }

}