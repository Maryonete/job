<?php
//lecture intégrale d'un fichier
//lecture d'un fichier ligne par ligne

use App\Entity\Database;
use App\Entity\Offre;
use App\Repository\OffreRepo;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    initBD();
}
function initBD()
{
    // Vérifie si le fichier est bien uploadé
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $filePath = $_FILES['file']['tmp_name']; // Chemin temporaire du fichier

        try {
            $pdo = Database::getPDO();
            $statement = $pdo->prepare("TRUNCATE TABLE offre");
            $statement->execute();
            $spreadsheet = IOFactory::load($filePath);

            // Sélectionner la première feuille
            $worksheet = $spreadsheet->getActiveSheet();

            $highestRow = $worksheet->getHighestRow();

            for ($i = 1; $i <= $highestRow; $i++) {
                $offreCSV = [];
                for ($col = 'A'; $col <= 'J'; $col++) {
                    $offreCSV[] = $worksheet->getCell($col . $i)->getValue();
                }

                // Votre code existant
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
                        ->setDescription($offreCSV[2]  ?? '')
                        ->setLieu($offreCSV[3]  ?? '')
                        ->setUrl($offreCSV[4]  ?? '')
                        ->setContact($offreCSV[5] ?? '')
                        ->setReponse($offreCSV[6]  ?? '')
                        ->setDateReponse($dateReponse)
                        ->setLettreMotivation($offreCSV[8])
                        ->setType($offreCSV[9]);
                    OffreRepo::save($offre);
                }
            }
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
            redirectTo('admin-dashboard');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Initialisation BD</h1>
            <p class="col-md-8 fs-4">
                <label for="avatar">Sélection du fichier au format XLSX :</label>
                <input type="file" id="file" name="file" accept=".xlsx" />
            </p>
            <input type="submit" class="btn btn-primary btn-lg" value="Mise à jour" />
        </div>
    </div>
</form>