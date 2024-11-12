<?php

namespace App\Repository;

use PDO;
use DateTime;
use App\Entity\Offre;
use App\Entity\Database;

class OffreRepo extends Offre
{

    public static function save(Offre $offre): Offre
    {
        $pdo = Database::getPDO();
        if ($offre->getId()) {
            $stmt = $pdo->prepare('UPDATE offre SET 
        dateCandidature=:date_candidature,
        entreprise=:entreprise,
        lieu=:lieu,
        description=:description,
        url=:url,
        contact=:contact,
        suivi=:suivi,
        reponse=:reponse,
        reponse_at=:reponse_at 
        WHERE id = :id');
            $stmt->bindParam(':id', $offre->getId(), PDO::PARAM_INT);
        } else {
            $stmt = $pdo->prepare('INSERT INTO offre
        (dateCandidature, entreprise, lieu, description, url, contact, suivi, reponse, reponse_at)
        VALUES(:date_candidature, :entreprise, :lieu, :description, :url, :contact, :suivi, :reponse, :reponse_at )');
        }
        $dateCandidature =  $offre->getDateCandidature();
        if ($dateCandidature instanceof DateTime) {
            $dateCandidature = $dateCandidature->format('Y-m-d'); // Format SQL standard
        }
        $entreprise = $offre->getEntreprise();
        $lieu = $offre->getLieu();
        $description = $offre->getDescription();
        $url = $offre->getUrl();
        $contact = $offre->getContact();
        $suivi = $offre->getSuivi();
        $reponse = $offre->getReponse();
        $dateReponse = $offre->getDateReponse();
        if ($dateReponse instanceof DateTime) {
            $dateReponse = $dateReponse->format('Y-m-d'); // Format SQL standard
        }

        $stmt->bindParam(':date_candidature', $dateCandidature);
        $stmt->bindParam(':entreprise', $entreprise);
        $stmt->bindParam(':lieu', $lieu);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':suivi', $suivi);
        $stmt->bindParam(':reponse', $reponse);
        $stmt->bindParam(':reponse_at', $dateReponse);
        $stmt->execute();


        if (!$offre->getId()) {
            $offre->setId((int)$pdo->lastInsertId());
        }
        return $offre;
    }
    public function getAllOffres(): array
    {
        $pdo = Database::getPDO();
        $statement = $pdo->prepare("SELECT * FROM offre");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, Offre::class);
    }
}
