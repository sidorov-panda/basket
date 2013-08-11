<?php

require_once APPLICATION_PATH . '/models/StorageCommon.php';
require_once APPLICATION_PATH . '/models/StorageTourist.php';
require_once APPLICATION_PATH . '/models/StorageService.php';
require_once APPLICATION_PATH . '/models/StorageResourceAdapterFactory.php';

//TODO Сделать автолоад, перенести Storage в отдельную папку
class StorageController extends Zend_Controller_Action {

    private $_sessionName = NULL;
    private $_format = 'json';

    public function init() {
        $_REQUEST = array(
            'common' => array(
                'customer_name' => 'Vasya',
                'customer_surname' => 'Fedotov',
                'customer_email' => 'vasta@fedotov.ru',
                'customer_phone' => '+79991112233'
            ),
            'tourist' => array(
                array(
                    'first_name' => 'Pavel',
                    'last_name' => 'Sol',
                    'patronym' => 'Valeryevich',
                    'service' => array(
                        'application' => 'cruise',
                        'value' => '{
                                service_name: "Круиз",
                                service_info: [
                                    {
                                        service_name: "Маршрут",
                                        service_value: "Круиз по средиземному морю"

                                    },
                                    {
                                        service_name: "Круизная компания",
                                        service_value: "RCC"
                                    },
                                    {
                                        service_name: "Лайнер",
                                        service_value: "Royal liner 2000 superset 700"

                                    },
                                    {
                                        service_name: "Дата отправления",
                                        service_value: "12.09.2011"
                                    }
                                ]
                                service_additional: [
                                    {
                                        service_name: "Юбилей свадьбы",
                                        service_value: ""
                                    }
                                ]
                            }'
                    )
                ),
                array(
                    'first_name' => 'Ekaterina',
                    'last_name' => 'Sol',
                    'patronym' => 'Valeryevich',
                    'service' => array(
                        'application' => 'cruise',
                        'value' => '{
                                service_name: "Круиз",
                                service_info: [
                                    {
                                        service_name: "Маршрут",
                                        service_value: "Круиз по средиземному морю"

                                    },
                                    {
                                        service_name: "Круизная компания",
                                        service_value: "RCC"
                                    },
                                    {
                                        service_name: "Лайнер",
                                        service_value: "Royal liner 2000 superset 700"

                                    },
                                    {
                                        service_name: "Дата отправления",
                                        service_value: "12.09.2011"
                                    }
                                ],
                                service_additional: [
                                    {
                                        service_name: "Юбилей свадьбы",
                                        service_value: ""
                                    }
                                ]
                            }'
                    )
                )
            )
        );
        $this->_format = $this->_getParam("format");
        $this->_sessionName = $this->_getParam("session");
    }

    private function _parseRequest() {

        //var_dump($_REQUEST);

        $commonSet = $_REQUEST['common'];

        $touristSet = $_REQUEST['tourist'];
        return array(
            'common' => $commonSet,
            'tourist' => $touristSet,
        );
    }

    public function setAction() {
        $a = new StorageCommon();
        $b = new StorageTourist();

        $session = new StorageSession($this->getSessionName());
        $sets = $this->_parseRequest();


        $a->set($session, $sets['common']);
        if (is_array($sets['tourist'])) {
            foreach ($sets['tourist'] as $k => $v) {
                $b->set($session, $v);
            }
        }
        //$c->set($session, $sets['service']);
        //$request = new Zend_Http_Request();
        //var_dump($request->ololo);
    }

    private function _generateAnswer($arr = array()) {
        return Zend_Json::encode($arr);
    }

    public function getAction() {
        $a = new StorageCommon();
        $session = new StorageSession($this->getSessionName());


        $b = new StorageTourist();
        $b->get($session);
        $c = new StorageService();
        $c->get($session);
        $arr = array(
            'common' => $a->get($session)->toArray(),
            'tourist' => $b->get($session)->toArray(),
        );
        var_dump($this->_generateAnswer($arr));
        return $this->_generateAnswer($arr);
    }

    public function indexAction() {
        return false;
    }

    private function getSessionName() {
        if (!isset($this->_sessionName) || strlen($this->_sessionName) < 1) {
            return false;
        }
        return $this->_sessionName;
    }

}

