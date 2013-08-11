<?php

define('CONFIG_PATH', APPLICATION_PATH . '/configs/');

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    function init() {
        echo 11;
        $resource = $bootstrap->getPluginResource('db');
        $db = $resource->getDbAdapter();
    }

}

