<?php

require_once APPLICATION_PATH . '/models/StorageResourceAdapterFactory.php';
require_once APPLICATION_PATH . '/models/StorageSession.php';
require_once APPLICATION_PATH . '/models/StorageAdapterAbstract.php';
require_once APPLICATION_PATH . '/models/StorageOrder.php';

/*
 * Класс Адаптера туриста.
 */

Final class StorageTouristAdapter extends StorageAdapterAbstract {

    //Задаем название таблицы
    protected $_name = 'storage_tourist';
    //Задаем название последовательность, которая генерит id для таблицы модели,
    //т.к. PG не поддерживает автоинкремент,
    //честно говоря не знаю, есть ли в этом необходимость,
    //т.к. данные из последовательности автоматои идут в таблицу
    protected $_sequence = 'storage_tourist_seq';

    /*
     * Метод, получающий данные о туристе в пределах сессии и текущего заказа.
     * $session <StorageSession> - объект сессии хранилища
     * return <Zend_Db_Table_Rowset> - объект с результатом выборки
     */
    function get(StorageSession $session) {
        $order = new StorageOrder();
        return $this->fetchAll(
                        $this->select()
                        ->where('session_id = :sid')
                        ->where('order_id = :oid')
                        ->bind(array(
                            ':sid' => $session->getId(),
                            ':oid' => $order->get($session)->id
                                )
                        )
                        ->order('id DESC')
        );
    }

    /*
     * Метод, записывающий данные о туристе в базу.
     * TODO ВНИМАНИЕ! Данный метод сейчас записывает, также, и данные об услугах, которые заказал турист,
     * Необходимо перенести запись данных об услугах в котроллер!
     * $session <StorageSession> - объект сессии хранилища
     * $set <Array> - массив строчек для добавления в таблицу, ключи должны
     * совпадать с соответсвующими полями в таблице
     * return <Bool> - true - все прошло успешно, false - нет ;)
     */

    public function set(StorageSession $session, $set = array()) {
        //Не передавать пустую сессию
        if (strlen($session->getId()) < 1) {
            return false;
        }
        $orderObj = new StorageOrder();
        $serviceObj = new StorageService();
        $tourist_id = NULL; //ID туриста
        //Устанавливаем order_id
        $set['order_id'] = $orderObj->get($session)->id;

        $service = $set['service'];
        unset($set['service']);
        //Проверяем, есть ли туристы в пределах сессии и заказа
        $get = $this->get($session);
        //Если нет - создаем
        if (count($get) < 1) {
            $tourist_id = $this->_insert($session, $set);
            //Если есть - обновляем
        } else {
            $tourist_id = $this->_update($session, $set);
        }
        //Добавляем сервисы туристу
        //TODO перенести в контроллер
        $params = array(
            'session_id' => $session->getId(),
            'order_id' => $orderObj->get($session)->id,
            'application' => $service['application'],
            'value' => $service['value'],
            'tourist_id' => $tourist_id
        );
        $serviceObj->set($session, $params);
        return true;
    }

    /*
     * Метод апдейтит данные в таблице
     * $session <StorageSession> - объект сессии хранилища
     * $set <Array> - массив, с данными для вставки, ключи должны совпадать с
     * соответствующими полями в таблице
     * return <Array> - массив с primary key измененных строчек в базе
     */

    private function _update($session, $set = array()) {
        $order = new StorageOrder();
        return $this->_db->update($this->_name, $set, array(
            'order_id = ?' => $order->get($session)->id,
            'session_id = ?' => $session->getId()
                )
        );
    }

    /*
     * Метод вставляет данные в таблицу
     * $session <StorageSession> - объект сессии хранилища
     * $set <Array> - массив, с данными для вставки, ключи должны совпадать с
     * соответствующими полями в таблице
     * return <id> - primary key вставленной строчки
     */

    private function _insert($session, $set) {
        $set['session_id'] = $session->getId();
        return $this->_db->insert($this->_name, $set);
    }

}