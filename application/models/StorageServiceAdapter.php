<?php

require_once APPLICATION_PATH . '/models/StorageAdapterAbstract.php';
require_once APPLICATION_PATH . '/models/StorageOrder.php';

final class StorageServiceAdapter extends StorageAdapterAbstract {

    //Задаем название таблицы
    protected $_name = 'storage_service';
    //Задаем название последовательность, которая генерит id для таблицы модели,
    //т.к. PG не поддерживает автоинкремент,
    //честно говоря не знаю, есть ли в этом необходимость,
    //т.к. данные из последовательности автоматои идут в таблицу
    protected $_sequence = 'storage_service_seq';

    //$order->get($session)->id

    public function getById(array $ids) {
        return $this->fetchAll(
                        $this->select()
                        ->where('id IN (:ids)')
                        ->bind(
                                array(
                                    ':ids' => implode(', ', $ids),
                                )
                        )
                        ->order('id DESC')
        );
    }

    public function get(StorageSession $session) {
        //$order = new StorageOrder();
        return $this->fetchAll(
                        $this->select()
                        ->where('session_id = :sid')
                        ->where('order_id = :oid')
                        //->where('tourist_id IN (:tids)')
                        ->bind(array(
                            ':sid' => $session->getId(),
                            ':oid' => $this->order_id,
                                )
                        )
                        ->order('id DESC')
        );
    }

    public function getByTourist() {

    }

    function set(StorageSession $session, $set = array()) {
        //Не передавать пустую сессию
        if (strlen($session->getKey()) < 1) {
            return false;
        }
        $o = new StorageOrder();
        $set['order_id'] = $o->get($session)->id;
        $get = $this->get($session);
        if (empty($get) || !is_object($get)) {
            $this->_insert($session->getId(), $set);
        } else {
            $this->_update($session->getId(), $set);
        }
        return;
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