<?php

namespace App;

use App\Entity\User;
use App\Entity\Database;
use App\Exception\UserException;

class Auth
{
    public function login(string $username, string $password): ?User
    {
        $pdo = Database::getPDO();
        $statement = $pdo->prepare("SELECT * FROM user WHERE username = :username");
        $statement->execute(['username' => $username]);
        $user = $statement->fetchObject(User::class);
        if ($user === false) {
            throw new UserException('Identifiants invalides');
        }
        if (password_verify($password, $user->getPassword())) {
            $_SESSION['connecte'] = $user->getId();
            return $user;
        } else {
            throw new UserException('Identifiants invalides');
        }
    }
    // public function user(): ?User
    // {
    //     if (!empty($_SESSION['connecte'])) {
    //         $user = (new UserRepository())->findUserById($_SESSION['connecte']);
    //     }
    //     return $user ?? null;
    // }

    // public function requireRole(string ...$role): void
    // {
    //     $user = $this->user();
    //     if (!in_array($user->getRole(), $role)) {
    //         header('location : login.php');
    //         exit;
    //     }
    // }
}
