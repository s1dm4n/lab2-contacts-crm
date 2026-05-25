<?php
/**
 * Конфигурация подключения к БД MySQL
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'contacts_db');

/**
 * Получение соединения с БД
 */
function getDB() {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die('Ошибка: ' . $e->getMessage());
    }
}

/**
 * Инициализация БД и таблицы
 */
function initDB() {
    $pdo = getDB();
    
    // Создаём БД
    $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $pdo->exec('USE `' . DB_NAME . '`');
    
    // Создаём таблицу контактов
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `contacts` (
            `id`         INT AUTO_INCREMENT PRIMARY KEY,
            `surname`    VARCHAR(100)  NOT NULL,
            `name`       VARCHAR(100)  NOT NULL,
            `lastname`   VARCHAR(100),
            `gender`     ENUM('мужской','женский'),
            `birthdate`  DATE,
            `phone`      VARCHAR(20),
            `address`    TEXT,
            `email`      VARCHAR(150),
            `comment`    TEXT,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
}

/**
 * Получение соединения с БД (после инициализации)
 */
function getDBConnection() {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die('Ошибка БД: ' . $e->getMessage());
    }
}
