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
            // Charger les variables d'environnement si le fichier .env existe (en local)
            if (file_exists(__DIR__ . '/../../.env')) {
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
                $dotenv->load();
            }

            // Récupération des variables d'environnement
            $dbHost = $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST') ?? '127.0.0.1';
            $dbPort = $_ENV['MYSQLPORT'] ?? getenv('MYSQLPORT') ?? '3306';
            $dbName = $_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE') ?? 'job';
            $dbUser = $_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER') ?? 'root';
            $dbPassword = $_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD') ?? '';

            // Création de la connexion PDO
            try {
                $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8";
                $pdo = new PDO($dsn, $dbUser, $dbPassword, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }



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
