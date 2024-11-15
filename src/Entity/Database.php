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
            try {
                // Récupérer les variables d'environnement (soit de .env en local, soit de Railway en prod)
                $host = $_SERVER['MYSQLHOST'] ?? $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST');
                $db   = $_SERVER['MYSQLDATABASE'] ?? $_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE');
                $user = $_SERVER['MYSQLUSER'] ?? $_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER');
                $pass = $_SERVER['MYSQLPASSWORD'] ?? $_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD');
                $port = $_SERVER['MYSQLPORT'] ?? $_ENV['MYSQLPORT'] ?? getenv('MYSQLPORT') ?? '3306';

                // Vérification des variables requises
                if (!$host || !$db || !$user) {
                    throw new \RuntimeException('Configuration de base de données manquante.');
                }

                // Construction du DSN
                $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

                // Création de l'instance PDO
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
                // Log l'erreur de manière sécurisée (ne pas exposer les détails en production)
                error_log("Erreur de connexion à la base de données : " . $e->getMessage());
                throw new \RuntimeException("Impossible de se connecter à la base de données. Veuillez contacter l'administrateur.");
            }
        }

        return self::$instance;
    }

    // Méthode utile pour le débogage (à utiliser uniquement en développement)
    public static function debugEnvironment(): void
    {
        if ($_ENV['APP_ENV'] ?? getenv('APP_ENV') === 'development') {
            echo "<pre>";
            echo "Variables d'environnement de la base de données :\n";
            echo "MYSQLHOST: " . ($_SERVER['MYSQLHOST'] ?? $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST') ?? 'non défini') . "\n";
            echo "MYSQLDATABASE: " . ($_SERVER['MYSQLDATABASE'] ?? $_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE') ?? 'non défini') . "\n";
            echo "MYSQLUSER: " . ($_SERVER['MYSQLUSER'] ?? $_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER') ?? 'non défini') . "\n";
            echo "MYSQLPORT: " . ($_SERVER['MYSQLPORT'] ?? $_ENV['MYSQLPORT'] ?? getenv('MYSQLPORT') ?? 'non défini') . "\n";
            echo "</pre>";
        }
    }
    public static function setPDO(PDO $pdo): void
    {
        self::$instance = $pdo;
    }
}
