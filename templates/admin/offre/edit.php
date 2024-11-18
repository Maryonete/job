<a href=<?= generateUrl('admin-dashboard') ?> class="btn btn-primary"><i class="fa-solid fa-circle-arrow-left"></i></a>

<?php if (!empty($offre)): ?>
    <h1>Mise à jour de l'offre</h1>
    <h2 class="mb-4"><?= $offre->getDescription() ?> N°<?= $offre->getId() ?></h2>
<?php else: ?>
    <h2 class="mb-4">
        <h1>Nouvelle candidature à une offre d'emploi</h1>
    </h2>
<?php endif ?>


<form action="<?= generateUrl('offre_edit_save', ['id' => !empty($offre) ? $offre->getId() : '']) ?>" method="post">
    <div class="mb-3 row">
        <label for="staticDateCandidature" class="col-sm-2 col-form-label">Date de candidature</label>
        <div class="col-sm-2">
            <input type="date"
                class="form-control-plaintext"
                name="dateCandidature"
                value="<?= !empty($offre) ? $offre->getDateCandidature()->format('Y-m-d') : '' ?>">
        </div>

        <label for="staticLettreMotivation" class="col-sm-2 col-form-label">Lettre de motivation </label>

        <div class="col-sm-2">
            <select name="lettreMotivation">
                <option value="">--</option>
                <option value="oui" <?= !empty($offre) && $offre->getLettreMotivation() === 'oui' ? 'selected' : '' ?>>Oui</option>
                <option value="non" <?= !empty($offre) && $offre->getLettreMotivation() !== 'oui' ? 'selected' : '' ?>>Non</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="inputType" class="col-sm-2 col-form-label">Type</label>
        <div class="col-sm-2">
            <select name="type">
                <option value="">--</option>
                <option value="Informatique" <?= !empty($offre) && $offre->gettype() === 'Informatique' ? 'selected' : '' ?>>Informatique</option>
                <option value="Autre" <?= !empty($offre) && $offre->gettype() !== 'Informatique' ? 'selected' : '' ?>>Autre</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="inputPoste" class="col-sm-2 col-form-label">Poste</label>
        <div class="col-sm-7">
            <input type="text"
                class="form-control"
                name="description"
                id="inputPoste"
                value="<?= !empty($offre) ? $offre->getDescription() : '' ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="inputEntreprise" class="col-sm-2 col-form-label">Entreprise</label>
        <div class="col-sm-5">
            <input type="text"
                class="form-control"
                id="inputEntreprise"
                name="entreprise"
                value="<?= !empty($offre) ? $offre->getEntreprise() : '' ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="inputLieu" class="col-sm-2 col-form-label">Lieu</label>
        <div class="col-sm-5">
            <input type="text"
                class="form-control"
                name="lieu"
                id="inputLieu"
                value="<?= !empty($offre) ? $offre->getLieu() : '' ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="inputURL" class="col-sm-2 col-form-label">URL</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="url" id="inputURL" style="height: 100px"><?= !empty($offre) ? $offre->getUrl() : '' ?></textarea>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="inputContact" class="col-sm-2 col-form-label">Contact</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="contact" id="inputContact" style="height: 100px"><?= !empty($offre) ? $offre->getContact() : '' ?></textarea>
        </div>
    </div>



    <div class="mb-3 row">
        <label for="staticReponse" class="col-sm-2 col-form-label">Réponse</label>
        <div class="col-sm-2">
            <input type="date"
                class="form-control-plaintext"
                name="reponse_at"
                value="<?= !empty($offre) && !empty($offre->getDateReponse()) ? $offre->getDateReponse()->format('Y-m-d') : '' ?>">
        </div>
        <div class="col-sm-2">
            <select name="reponse">
                <option value="">--</option>
                <option value="NON" <?= !empty($offre) && $offre->getReponse() === 'NON' ? 'selected' : '' ?>>NON</option>
                <option value="ATT">En attente</option>
                <option value="cat">Pas encore arrive</option>
            </select>

        </div>
    </div>




    <div class="my-3 row">
        <div class="col-sm-8 text-center">
            <input type="submit" value="Enregistrer" class="btn btn-primary">
        </div>
    </div>
</form>