<?php

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testSetAndGetId(): void
    {
        // Tester l'attribution et la récupération de l'ID
        $this->user->setId(1);
        $this->assertEquals(1, $this->user->getId());
    }
    public function testSetAndGetEmail(): void
    {
        $this->user->setEmail('test@free.fr');
        $this->assertEquals('test@free.fr', $this->user->getEmail());
    }
    public function testSetAndGetPassword(): void
    {
        $this->user->setPassword('xxxxx');
        $this->assertEquals('xxxxx', $this->user->getPassword());
    }
    public function testSetAndGetUsername(): void
    {
        $this->user->setUsername('xxxxx');
        $this->assertEquals('xxxxx', $this->user->getUsername());
    }
}
