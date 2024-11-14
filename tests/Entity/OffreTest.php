<?php

namespace App\Tests;

use App\Entity\Offre;
use PHPUnit\Framework\TestCase;
use DateTime;

class OffreTest extends TestCase
{
    private Offre $offre;

    protected function setUp(): void
    {
        // Initialisation d'une nouvelle instance de la classe Offre avant chaque test
        $this->offre = new Offre();
    }

    public function testSetAndGetId(): void
    {
        // Tester l'attribution et la récupération de l'ID
        $this->offre->setId(1);
        $this->assertEquals(1, $this->offre->getId());
    }

    public function testSetAndGetDateCandidature(): void
    {
        // Tester l'attribution et la récupération de la date de candidature
        $date = new DateTime('2024-01-01');
        $this->offre->setDateCandidature($date);
        $this->assertEquals($date, $this->offre->getDateCandidature());
    }

    public function testSetAndGetEntreprise(): void
    {
        // Tester l'attribution et la récupération du nom de l'entreprise
        $this->offre->setEntreprise('Entreprise Test');
        $this->assertEquals('Entreprise Test', $this->offre->getEntreprise());
    }

    public function testSetAndGetLieu(): void
    {
        // Tester l'attribution et la récupération du lieu
        $this->offre->setLieu('Paris');
        $this->assertEquals('Paris', $this->offre->getLieu());
    }

    public function testSetAndGetDescription(): void
    {
        // Tester l'attribution et la récupération de la description
        $this->offre->setDescription('Description de l\'offre');
        $this->assertEquals('Description de l\'offre', $this->offre->getDescription());
    }

    public function testSetAndGetUrl(): void
    {
        // Tester l'attribution et la récupération de l'URL
        $this->offre->setUrl('http://www.offre-test.com');
        $this->assertEquals('http://www.offre-test.com', $this->offre->getUrl());
    }

    public function testSetAndGetContact(): void
    {
        // Tester l'attribution et la récupération du contact
        $this->offre->setContact('contact@test.com');
        $this->assertEquals('contact@test.com', $this->offre->getContact());
    }

    public function testSetAndGetReponse(): void
    {
        // Tester l'attribution et la récupération de la réponse
        $this->offre->setReponse('Réponse positive');
        $this->assertEquals('Réponse positive', $this->offre->getReponse());
    }

    public function testSetAndGetDateReponse(): void
    {
        // Tester l'attribution et la récupération de la date de réponse
        $dateReponse = new DateTime('2024-02-01');
        $this->offre->setDateReponse($dateReponse);
        $this->assertEquals($dateReponse, $this->offre->getDateReponse());
    }
}
