<?php

interface StorageInterface {

    function get(StorageSession $session);

    function set(StorageSession $session, $set);

    

}