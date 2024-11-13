<?php

namespace App\Repository;

use PDO;
use DateTime;
use App\Entity\Offre;
use App\Entity\Database;
use App\Exception\OffreException;

class OffreRepo extends Offre
{
    public static function deleteOffreById(int $id): void
    {
        try {
            $pdo = Database::getPDO();
            $statement = $pdo->prepare("DELETE FROM offre WHERE id=?");
            $statement->execute([$id]);
            $_SESSION['success'] = "Offre {$id} supprimée";
        } catch (OffreException $e) {
            $_SESSION['error'] = "Erreur suppression offre {$id}";
        }
    }
    public static function editOffre(array $post, ?int $id = null): Offre
    {
        $offre = empty($id) ? new Offre : OffreRepo::getOffreById($id);
        if (!empty($post['dateCandidature'])) {
            $offre->setDateCandidature(
                !empty($post['dateCandidature']) ? DateTime::createFromFormat('Y-m-d', $post['dateCandidature']) : null
            );
        } else {
            $_SESSION['error'] = 'Date de candidature manquante';
        }
        if (!empty($post['entreprise'])) {
            $offre->setEntreprise(htmlentities($post['entreprise']));
        } else {
            $_SESSION['error'] = 'Entreprise manquante';
        }
        if (!empty($post['lieu'])) {
            $offre->setLieu(htmlentities($post['lieu']));
        } else {
            $_SESSION['error'] = 'lieu manquante';
        }

        $offre->setDescription($post['description'] ?? '');
        $offre->setUrl($post['url'] ?? '');
        $offre->setContact($post['contact'] ?? '');
        $offre->setReponse($post['reponse'] ?? '');
        $offre->setDateReponse(
            !empty($post['reponse_at']) ? DateTime::createFromFormat('Y-m-d', $post['reponse_at']) : null
        );
        return self::save($offre);
    }

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
                reponse=:reponse,
                reponse_at=:reponse_at 
                WHERE id = :id');
            $id = $offre->getId();
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            $stmt = $pdo->prepare('INSERT INTO offre
        (dateCandidature, entreprise, lieu, description, url, contact,  reponse, reponse_at)
        VALUES(:date_candidature, :entreprise, :lieu, :description, :url, :contact,  :reponse, :reponse_at )');
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
        $stmt->bindParam(':reponse', $reponse);
        $stmt->bindParam(':reponse_at', $dateReponse);
        $stmt->execute();


        if (!$offre->getId()) {
            $offre->setId((int)$pdo->lastInsertId());
        }
        return $offre;
    }
    public function getAllOffres(?string $etat = null): array
    {
        $pdo = Database::getPDO();
        $query = "SELECT * FROM offre ";
        $query .= !empty($etat) && $etat === "encours" ? " WHERE reponse <> 'NON' " : '';
        $query .= !empty($etat) && $etat === "refuse" ? " WHERE reponse = 'NON' " : '';
        $query .= "ORDER BY dateCandidature DESC";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $offresData = $statement->fetchAll(PDO::FETCH_ASSOC);
        $offres = [];
        foreach ($offresData as $data) {
            $offre = new Offre();
            $offre->setId($data['id'] ?? null);
            // Hydratation manuelle
            $offre->setDateCandidature(
                !empty($data['dateCandidature']) ? DateTime::createFromFormat('Y-m-d', $data['dateCandidature']) : null
            );
            $offre->setEntreprise($data['entreprise'] ?? null);
            $offre->setLieu($data['lieu'] ?? null);
            $offre->setDescription($data['description'] ?? null);
            $offre->setUrl($data['url'] ?? null);
            $offre->setContact($data['contact'] ?? null);
            $offre->setReponse($data['reponse'] ?? null);
            $offre->setDateReponse(
                !empty($data['reponse_at']) ? DateTime::createFromFormat('Y-m-d', $data['reponse_at']) : null
            );

            $offres[] = $offre;
        }

        return $offres;
    }
    public static function getOffreById(int $id): Offre
    {
        $pdo = Database::getPDO();
        $statement = $pdo->prepare("SELECT * FROM offre where id= ?");
        $statement->execute([$id]);
        $data = $statement->fetch();


        $offre = new Offre();
        $offre->setId($data['id'] ?? null);
        // Hydratation manuelle
        $offre->setDateCandidature(
            !empty($data['dateCandidature']) ? DateTime::createFromFormat('Y-m-d', $data['dateCandidature']) : null
        );
        $offre->setEntreprise($data['entreprise'] ?? null);
        $offre->setLieu($data['lieu'] ?? null);
        $offre->setDescription($data['description'] ?? null);
        $offre->setUrl($data['url'] ?? null);
        $offre->setContact($data['contact'] ?? null);
        $offre->setReponse($data['reponse'] ?? null);
        $offre->setDateReponse(
            !empty($data['reponse_at']) ? DateTime::createFromFormat('Y-m-d', $data['reponse_at']) : null
        );

        return $offre;
    }
}
