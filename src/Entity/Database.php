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
            $config = self::parseConfigFile(self::DB_FILE);
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
            self::$instance = new PDO($dsn, $config['user'], $config['password'], [
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


    private static function  parseConfigFile($filename)
    {
        $config = [];
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Supprimer les espaces en début et fin de ligne
            $line = trim($line);

            // Ignorer les lignes de commentaire
            if (strpos($line, ';') === 0) continue;

            // Découper la ligne en clé/valeur
            list($key, $value) = explode('=', $line, 2);

            // Nettoyer les retours à la ligne
            $config[trim($key)] = trim($value);
        }

        return $config;
    }
}
