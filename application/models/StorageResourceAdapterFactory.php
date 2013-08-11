<?php

class StorageResourceAdapterFactory {

    public static function factory($name) {

        require_once APPLICATION_PATH . '/models/StorageResource' . $name . 'Adapter.php';
        $className = 'StorageResource' . $name . 'Adapter';
        return $className::getInstance();
    }

}

