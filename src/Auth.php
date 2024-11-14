<?php

namespace App;

use App\Entity\User;
use App\Entity\Database;
use App\Exception\UserException;

class Auth
{
    public function login(string $email, string $password): ?User
    {
        $pdo = Database::getPDO();
        $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $statement->execute(['email' => $email]);
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
}
