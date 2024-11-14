<h1 class="pb-2 border-bottom d-flex justify-content-between">
    <a href="../recap.xlsx" target="_blank" class="--bs-success"><i class="fa-solid fa-file-excel "></i></a>
    <?php $count = count($offres); ?>
    Dashboard
    <?= empty($etat) ? $count . " candidatures" : ($etat === 'refuse' ? $count . " candidatures refusées" : $count . " candidatures en cours") ?>
    <a href="<?= generateUrl('offre-add') ?>"><i class="fas fa-plus"></i></a>
</h1>

<?php require "../templates/admin/offre/find.php"; ?>
<table class="table table-striped sortable">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Date Candidature</th>
            <th scope="col">Entreprise</th>
            <th scope="col">Lieu</th>
            <th scope="col">Poste</th>
            <th scope="col">URL</th>
            <th scope="col">contact</th>
            <th scope="col">réponse</th>
            <th scope="col">réponse date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($offres as $offre): ?>
            <?php $url = !empty($offre->getUrl()) ? "<a href={$offre->getUrl()} target='_blank'><i class='fa-solid fa-link'></i></a>" : "" ?>
            <tr <?= $offre->getReponse() === 'NON' ? " class='table-dark'" : '' ?>>
                <td><?= $offre->getId() ?></td>
                <td><?= $offre->getDateCandidature()->format('d/m/Y') ?></td>
                <td><?= $offre->getEntreprise() ?></td>
                <td><?= $offre->getLieu() ?></td>
                <td><?= $offre->getDescription() ?></td>
                <td><?= $url ?></td>
                <td><?= $offre->getContact() ?></td>
                <td><?= $offre->getReponse() ?></td>
                <td><?= !empty($offre->getDateReponse()) ? $offre->getDateReponse()->format('d/m/Y') : '' ?></td>
                <td><a href="<?= generateUrl('offre_edit', ['id' => $offre->getId()]) ?>" title="Mise à jour">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                </td>
                <td><a href="<?= generateUrl('offre_delete', ['id' => $offre->getId()]) ?>"
                        title="Delete"
                        onclick="if(confirm('Voules-vous vraiment supprimer cette candidature ? ')){return true;} else{return false;}">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
</table>