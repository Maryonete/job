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
            // Charger les variables d'environnement
            if (file_exists(dirname(__DIR__, 2) . '/.env')) {
                $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
                $dotenv->load();
            }

            try {
                $host = $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST');
                $db   = $_ENV['MYSQL_DATABASE'] ?? getenv('MYSQL_DATABASE');
                $user = $_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER');
                $pass = $_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD');
                $port = $_ENV['MYSQLPORT'] ?? getenv('MYSQLPORT');

                // Vérification des variables requises
                if (!$host || !$db || !$user) {
                    throw new \RuntimeException('Configuration de base de données manquante. Vérifiez votre fichier .env');
                }

                $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

                self::$instance = new PDO(
                    $dsn,
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                    ]
                );
            } catch (\PDOException $e) {
                throw new \RuntimeException("Erreur de connexion : " . $e->getMessage());
            }
        }

        return self::$instance;
    }
    public static function setPDO(PDO $pdo): void
    {
        self::$instance = $pdo;
    }
}
