<?php

namespace App\Entity;

use PDO;

class Database
{
    // const DB_FILE = "../../config/db_file";

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


            $dsn = sprintf(
                'mysql:dbname=%s;host=%s',
                'job',
                'localhost'
            );
            self::$instance = new \PDO($dsn, 'root', '', [
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
