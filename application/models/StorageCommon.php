<?php

require_once APPLICATION_PATH . '/models/StorageSession.php';
require_once APPLICATION_PATH . '/models/StorageCommonAdapter.php';
require_once APPLICATION_PATH . '/models/StorageAbstract.php';

/*
 * Класс, отвечающий за получение "основной" информации из сессии.
 * "Основная" информация - это информация, которая будет использоваться во всех приложениях,
 * вне зависимости от его типа, например,
 * информация о покупателе (бронирующем),
 * это либо информация об агенстве(Менеджере агенства),
 * либо информация о частнике (ФИО, телефон, имейл).
 *
 */

class StorageCommon extends StorageAbstract {}

