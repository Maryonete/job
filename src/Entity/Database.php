<?php

namespace App\Entity;

use PDO;

class Database
{
    const DB_FILE = "../config/db_file.php";



    /**
     * @var PDO|null Instance unique de PDO
     */
    private static ?PDO $instance = null;

    /**
     * Constructeur privé pour empêcher l'instanciation directe
     */
    private function __construct() {}

    /**
     * Empêche le clonage de l'instance
     */
    private function __clone() {}

    /**
     * Retourne l'instance unique de PDO
     * @return PDO
     */
    public static function getPDO(): PDO
    {

        if (self::$instance === null) {
            // Détecter l'environnement (local ou production)
            if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {
                // Environnement local
                $config = require __DIR__ . '/../../config/config.local.php';
            } else {
                // Environnement live
                $config = require __DIR__ . '/../../config/config.live.php';
            }

            $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8";
            self::$instance = new PDO($dsn, $config['db_user'], $config['db_password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        return self::$instance;
    }
    public static function setPDO(PDO $pdo): void
    {
        self::$instance = $pdo;
    }
}
