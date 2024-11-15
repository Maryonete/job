<?php

namespace App\Entity;

use PDO;
use Dotenv\Dotenv;
use PDOException;

class Database
{
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
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();

            $dbHost = $_ENV['DB_HOST'] ?? 'localhost';
            $dbName = $_ENV['DB_NAME'] ?? 'job';
            $dbUser = $_ENV['DB_USER'] ?? 'root';
            $dbPassword = $_ENV['DB_PASSWORD'] ?? '';

            try {
                $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8";
                $pdo = new PDO($dsn, $dbUser, $dbPassword);
            } catch (PDOException $e) {
                die('Erreur : ' . $e->getMessage());
            }
            self::$instance = new PDO($dsn, $dbUser, $dbPassword, [
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
