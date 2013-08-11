<?php

require_once APPLICATION_PATH . '/models/StorageResourceAdapterFactory.php';
require_once APPLICATION_PATH . '/models/StorageSession.php';
require_once APPLICATION_PATH . '/models/StorageAdapterAbstract.php';


/*
 * Класс, отвечающий за доступ к данным для хранилища StorageCommon.
 * В конструкторе явно устанавливаем адаптер, с которым работает эта часть хранилища.
 */

Final class StorageCommonAdapter extends StorageAdapterAbstract {

    //Задаем название таблицы
    protected $_name = 'storage_common';
    //Задаем название последовательность, которая генерит id для таблицы модели, т.к. PG не поддерживает автоинкремент,
    //честно говоря не знаю, есть ли в этом необходимость, т.к. данные из последовательности автоматои идут в таблицу
    protected $_sequence = 'storage_common_seq';

    public function get(StorageSession $session) {
        return $this->fetchAll(
                                $this->select()
                                ->where('session_id = :sid')
                                ->bind(array(':sid' => $session->getId()))
                                ->order('id DESC')
        );
    }

    public function set(StorageSession $session, $set = array()) {
        //Не передавать пустую сессию
        if (strlen($session->getKey()) < 1) {
            return false;
        }
        $get = $this->get($session);
        if (count($get) < 1) {
            $this->_insert($session->getId(), $set);
        } else {
            $this->_update($session->getId(), $set);
        }
    }

    private function _update($sessionId, $set = array()) {
        $where = $this->_db->quoteInto('session_id = ?', $sessionId);
        $this->_db->update($this->_name, $set, $where);
    }

    private function _insert($sessionId, $set) {
        $set['session_id'] = $sessionId;
        $this->_db->insert($this->_name, $set);
    }

}