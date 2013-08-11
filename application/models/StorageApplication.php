<?php

class StorageApplication {

    public static $instance = NULL;

    public static function getInstance() {
        if (!empty(self::$Instance) || !(self::$instance instanceof self)) {
            self::$instance = new self;
        } else {
            return self::$instance;
        }
    }

    private function __clone() {
        return false;
    }



}