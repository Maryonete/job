<?php

namespace App\Repository;

use PDO;
use DateTime;
use App\Entity\Offre;
use App\Entity\Database;
use App\Exception\OffreException;
use XLSXWriter;

class OffreRepo extends Offre
{
    /**
     * Supression d'une candidature par son id
     *
     * @param integer $id
     * @return void
     */
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
    /**
     * Edition d'une offre par son id
     *
     * @param array $post
     * @param integer|null $id
     * @return Offre
     */
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
        // dd($post);
        $offre->setDescription($post['description'] ?? '');
        $offre->setUrl($post['url'] ?? '');
        $offre->setContact($post['contact'] ?? '');
        $offre->setReponse($post['reponse'] ?? '');
        $offre->setLettreMotivation($post['lettreMotivation'] ?? 'non');
        $offre->setType($post['type'] ?? 'Informatique');

        $offre->setDateReponse(
            !empty($post['reponse_at']) ? DateTime::createFromFormat('Y-m-d', $post['reponse_at']) : null
        );
        return self::save($offre);
    }
    /**
     * Enregistre une nouvelle candidature
     *
     * @param Offre $offre
     * @return Offre
     */
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
                reponse_at=:reponse_at,
                lettreMotivation=:lettreMotivation,
                type=:type
                WHERE id = :id');
            $id = $offre->getId();
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            $stmt = $pdo->prepare('INSERT INTO offre
        (date_candidature, entreprise, lieu, description, url, contact,  reponse, reponse_at, lettre_motivation, type)
        VALUES(:date_candidature, :entreprise, :lieu, :description, :url, :contact,  :reponse, :reponse_at, :lettreMotivation, :type )');
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
        $lettreMotivation = $offre->getLettreMotivation();
        $type = $offre->getType();
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
        $stmt->bindParam(':lettreMotivation', $lettreMotivation);
        $stmt->bindParam(':type', $type);


        $stmt->execute();


        if (!$offre->getId()) {
            $offre->setId((int)$pdo->lastInsertId());
        }
        return $offre;
    }
    /**
     * retourne liste d'offre en fonction d'une recherche
     *
     * @param string $q
     * @return array
     */
    public function getAllOffresByKeyWord(string $q): array
    {
        $pdo = Database::getPDO();
        $query = "SELECT id FROM offre
            where entreprise like :key
            or lieu like :key
            or contact like :key";
        $statement = $pdo->prepare($query);

        $keyword = "%$q%";
        $statement->bindParam('key', $keyword, PDO::PARAM_STR);
        $statement->execute();
        $listOffres =  $statement->fetchAll();
        $offres = [];
        foreach ($listOffres as $offre) {
            $offres[] = $this->getOffreById($offre['id'])->jsonSerialize();
        }

        return $offres;
    }
    public function getAllOffresXLS(): void
    {
        $pdo = Database::getPDO();
        $query = "SELECT * FROM offre ";
        $statement = $pdo->prepare($query);
        $statement->execute();


        // HEADER
        $header = array(
            'date' => 'string',
            'entreprise' => 'string',
            'description' => 'string',
            'lieu' => 'string',
            'url' => 'string',
            'contact' => 'string',
            'reponse' => 'string',
            'reponse_at' => 'string',
            'lettreMotivation' => 'string',
            'type' => 'string',
        );
        $styles1 = array('font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'fill' => '#eee', 'halign' => 'center', 'border' => 'left,right,top,bottom');
        $datas = $statement->fetchAll(PDO::FETCH_ASSOC);

        $writer = new XLSXWriter();
        $writer->writeSheetHeader('Sheet1', $header, $styles1);
        $offres = [];
        foreach ($datas as $data) {
            // Créer l'objet DateTime pour la date de candidature
            $dateCand = DateTime::createFromFormat('Y-m-d', $data['date_candidature']);
            // Vérifier si la création a réussi
            $formattedDate = $dateCand !== false ? $dateCand->format('d/m/Y') : '';

            // Créer l'objet DateTime pour la date de réponse
            $dateReponse = !empty($data['reponse_at']) ? DateTime::createFromFormat('Y-m-d', $data['reponse_at']) : null;
            // Vérifier si la date de réponse est valide
            $formattedDateReponse = $dateReponse !== null && $dateReponse !== false ? $dateReponse->format('d/m/Y') : '';

            // Traitement des autres données
            $data['lettre_motivation'] = $data['lettre_motivation'] ? $data['lettre_motivation'] : 'non';
            $data['type'] = $data['type'] ? $data['type'] : 'Informatique';

            // Ajouter les données formatées au tableau $offres
            $offres[] = [
                'date' => $formattedDate,
                'entreprise' => $data['entreprise'],
                'description' => $data['description'],
                'lieu' => $data['lieu'],
                'url' => $data['url'],
                'contact' => $data['contact'],
                'reponse' => $data['reponse'],
                'reponse_at' => $formattedDateReponse,
                'lettre_motivation' => $data['lettre_motivation'],
                'type' => $data['type'],
            ];
        }

        $writer->writeSheet($offres);
        $writer->writeToFile('recap.xlsx');
    }
    /**
     * retourne la liste de toutes les candidatures
     *
     * @param string|null $etat
     * @return array
     */
    public function getAllOffres(?string $etat = null): array
    {
        $pdo = Database::getPDO();
        $query = "SELECT * FROM offre ";
        $query .= !empty($etat) && $etat === "encours" ? " WHERE reponse = '' " : '';
        $query .= !empty($etat) && $etat === "refuse" ? " WHERE reponse = 'NON' " : '';
        $query .= !empty($etat) && $etat === "attente" ? " WHERE reponse = 'ATT' " : '';
        $query .= !empty($etat) && $etat === "Autre" ? " WHERE type = 'Autre' " : '';


        $query .= "ORDER BY date_candidature DESC";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $offresData = $statement->fetchAll(PDO::FETCH_ASSOC);
        $offres = [];
        foreach ($offresData as $data) {
            $offre = new Offre();
            $offre->setId($data['id'] ?? null);
            // Hydratation manuelle
            // dd($data['date_candidature']);
            $dateCandidature = DateTime::createFromFormat('Y-m-d H:i:s', $data['date_candidature']);
            $offre->setDateCandidature($dateCandidature !== false ? $dateCandidature : null);


            $offre->setEntreprise($data['entreprise'] ?? null);
            $offre->setLieu($data['lieu'] ?? null);
            $offre->setDescription($data['description'] ?? null);
            $offre->setUrl($data['url'] ?? null);
            $offre->setContact($data['contact'] ?? null);
            $offre->setReponse($data['reponse'] ?? null);
            $offre->setLettreMotivation($data['lettreMotivation'] ?? 'non');
            $offre->setType($data['type'] ?? 'Informatique');

            $dateReponse = !empty($data['reponse_at']) ? DateTime::createFromFormat('Y-m-d H:i:s', $data['reponse_at']) : null;



            $offre->setDateReponse($dateReponse !== false ? $dateReponse : null);


            $offres[] = $offre;
        }

        return $offres;
    }
    /**
     * retourne lune candidature en focntion de son id
     *
     * @param integer $id
     * @return Offre
     */
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
            !empty($data['date_candidature']) ? DateTime::createFromFormat('Y-m-d H:i:s', $data['date_candidature']) : null
        );
        $offre->setEntreprise($data['entreprise'] ?? null);
        $offre->setLieu($data['lieu'] ?? null);
        $offre->setDescription($data['description'] ?? null);
        $offre->setUrl($data['url'] ?? null);
        $offre->setContact($data['contact'] ?? null);
        $offre->setReponse($data['reponse'] ?? null);

        if ($data['lettreMotivation'] === '0') {
            $data['lettreMotivation'] = 'non';
        }
        if ($data['type'] === '') {
            $data['type'] = 'Informatique';
        }
        $offre->setLettreMotivation($data['lettreMotivation']);
        $offre->setType($data['type']);

        $offre->setDateReponse(
            !empty($data['reponse_at']) ? DateTime::createFromFormat('Y-m-d H:i:s', $data['reponse_at']) : null
        );
        return $offre;
    }
}
