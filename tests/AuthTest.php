<?php

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    // public function getBuilder(): \App\QueryBuilder
    // {
    //     $pdo = new PDO("sqlite::memory:");
    //     $pdo->query('CREATE TABLE offre (
    //         id INT AUTO_INCREMENT PRIMARY KEY,
    //         dateCandidature DATE,
    //         entreprise VARCHAR(100),
    //         lieu VARCHAR(100),
    //         description TEXT,
    //         url VARCHAR(255),
    //         contact VARCHAR(100),
    //         reponse TEXT,
    //         reponse_at DATE
    //     );');



    //     for ($i = 1; $i <= 10; $i++) {
    //         $pdo->exec("INSERT INTO
    //         offre (dateCandidature, entreprise, lieu, description)
    //         VALUES ('2024-10-0$i', 'entreprise $i', 'lieu $i', 'description $i');");
    //     }
    //     return new \App\QueryBuilder($pdo);
    // }
    private PDO $pdo;

    public function setUp(): void
    {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->query('CREATE TABLE IF NOT EXISTS `user` (
            `id` INTEGER NOT NULL primary key autoincrement,
            `email` TEXT,
            `username` TEXT,
            `password` TEXT
        ) ;');
        $this->pdo->exec("INSERT INTO `user` (`username`, `email`, `password`) 
        VALUES ('admin', 'admin@test.com', '$2y$10\$Jh6L/yHFf5X3vSxsSont8.gaNvVHo0JpPT.6r68IeHlBj1BUsLy76')");
    }
    public function testlogin(): void
    {
        $email = 'admin@test.com';
        $password = 'test';
        $statement = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");
        $statement->execute(['email' => $email]);
        $user = $statement->fetchObject(User::class);

        $this->assertEquals(true, password_verify($password, $user->getPassword()));
    }
}
