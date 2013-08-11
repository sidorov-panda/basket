<?php

require_once APPLICATION_PATH . '/models/StorageAdapterAbstract.php';

class StorageSessionAdapter extends StorageAdapterAbstract {

    //Задаем название таблицы
    protected $_name = 'storage_session';
    //Задаем название последовательность, которая генерит id для таблицы модели,
    //т.к. PG не поддерживает автоинкремент,
    //честно говоря не знаю, есть ли в этом необходимость,
    //т.к. данные из последовательности автоматои идут в таблицу
    protected $_sequence = 'storage_session_seq';


    function get(StorageSession $session) {

        return $this->fetchRow(
                        $this->select()
                        ->where('key = :key')
                        ->bind(array(':key' => $session->getKey()))
                        ->order('id DESC')
                        ->limit(1)
        );
    }

    function set(StorageSession $session, $set = array()) {
        //Не передавать пустую сессию
        if (strlen($session->getKey()) < 1) {
            return false;
        }

        $get = $this->get($session);
        if (empty($get) && !is_object($get)) {
            $this->_insert($session->getKey(), $set);
        } else {
            $this->_update($session->getKey(), $set);
        }
        return ;
    }

    private function _update($sessionKey, $set = array()) {
        $where = $this->_db->quoteInto('key = ?', $sessionKey);
        return $this->_db->update($this->_name, $set, $where);
    }

    private function _insert($sessionKey, $set) {
        $set['key'] = $sessionKey;
        return $this->_db->insert($this->_name, $set);
    }

}