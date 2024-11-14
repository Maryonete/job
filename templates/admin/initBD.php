<?php
//lecture intégrale d'un fichier

//lecture d'un fichier ligne par ligne

use App\Entity\Database;
use App\Entity\Offre;
use App\Repository\OffreRepo;

$pdo = Database::getPDO();
$statement = $pdo->prepare("TRUNCATE TABLE offre");
$statement->execute();


$fic = fopen("../datas/recherches.csv", "r");
$i = 1; //Compteur de ligne
while (!feof($fic)) {

    $ligne = fgets($fic, 1024);
    $offreCSV = explode(';', $ligne);
    if (empty($offreCSV[0])) {
        continue;
    }


    if ($i > 1) {
        $date = DateTime::createFromFormat('d/m/Y', $offreCSV[0]);
        if ($date !== false) {
            $offreCSV[0] = $date->format('Y-m-d');
        } else {
            continue;
        }
        $offreCSV[7] = str_replace(["\r", "\n"], '', $offreCSV[7]);
        $dateReponse = DateTime::createFromFormat('d/m/Y', $offreCSV[7]);
        if ($dateReponse !== false) {
            $dateReponse->format('Y-m-d');
        } else {
            $dateReponse = null;
        }
        $offre = new Offre();
        $offre->setDateCandidature($date)
            ->setEntreprise($offreCSV[1])
            ->setDescription($offreCSV[2])
            ->setLieu($offreCSV[3])
            ->setUrl($offreCSV[4])
            ->setContact($offreCSV[5])
            ->setReponse($offreCSV[6])
            ->setDateReponse($dateReponse);
        OffreRepo::save($offre);
    }
    $i++;
}
fclose($fic);
?>

<h1>Initialisation BD</h1>