<?php

require_once APPLICATION_PATH . '/models/Tourist.php';
require_once APPLICATION_PATH . '/models/Common.php';
require_once APPLICATION_PATH . '/models/Service.php';
require_once APPLICATION_PATH . '/models/Order.php';
require_once APPLICATION_PATH . '/models/Session.php';
require_once APPLICATION_PATH . '/models/StorageService.php';


class IndexController extends Zend_Controller_Action {

    protected $_sessionKey = NULL;

    public function indexAction() {
        $params = $this->_getAllParams();
        $this->_sessionKey = $params['session'];
        
        $s = new Session();
        $t = new Tourist();
        $o = new Order();
        $c = new Common();
        $se = new Service();
        
        //Загружаю сессию
        $s->load($s->getByKey('ololo'));
        //Загружаю заказ
        $o->load($o->getCurrent($s->id)->toArray());
        
        $params = array(
            'session_id = ?' => $s->id,
            'order_id = ?'  => $o->id
        );
        //Получаю туристов
        $tourists = $t->get($params);
        $services = array();
        foreach ($tourists as $k => $v) {
            $services[$v->id] = $se->getByTouristId($v->id);
        }
        $this->view->assign('services', $services);
        $this->view->assign('tourists', $tourists);
    }

}