<?php
if (empty($_SESSION['connecte'])) {
    redirectTo('login');
}
?>
<h1 class="pb-2 border-bottom d-flex justify-content-between">
    <a href="../recap.xlsx" target="_blank" class="--bs-success mx-4"><i class="fa-solid fa-file-excel "></i></a>
    <?php
    $count = count($offres);
    $s =  $count > 1 ? 's' : '';
    ?>
    Dashboard
    <?= $count ?>
    <?php if (empty($etat)): ?>
        candidature<?= $s ?>
    <?php elseif ($etat === 'refuse'): ?>
        candidature<?= $s ?> refusée<?= $s ?>
    <?php elseif ($etat === 'attente'): ?>
        candidature<?= $s ?> en attente
    <?php elseif ($etat === 'Autre'): ?>
        candidature<?= $s ?> non informatique
    <?php else: ?>
        candidature<?= $s ?> en cours
    <?php endif ?>

    <a href="<?= generateUrl('offre-add') ?>"><i class="fas fa-plus"></i></a>
</h1>

<?php require "../templates/admin/offre/find.php"; ?>
<?php if ($count > 0): ?>
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
                <th scope="col">Lettre motivation</th>
                <th scope="col">réponse</th>
                <th scope="col">Relance</th>
                <th scope="col">Type</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($offres as $offre): ?>

                <?php $url = !empty($offre->getUrl()) ? "<a href={$offre->getUrl()} target='_blank'><i class='fa-solid fa-link'></i></a>" : "" ?>
                <tr <?= $offre->getReponse() === 'NON' ? " class='table-dark'" : ($offre->getReponse() === 'ATT' ? " class='table-success'" : '') ?>>
                    <td><?= $offre->getId() ?></td>
                    <td><?= $offre->getDateCandidature()?->format('d/m/Y') ?></td>
                    <td><?= $offre->getEntreprise() ?></td>
                    <td><?= $offre->getLieu() ?></td>
                    <td><?= $offre->getDescription() ?></td>
                    <td><?= $url ?></td>
                    <td><?= $offre->getContact() ?></td>
                    <td class="text-center"><?= $offre->getLettreMotivation() === 'non' ? '' : "<i class='fa-solid fa-xmark'  style='color:green; font-size:25pt'></i>"  ?></td>
                    <td class="text-center">
                        <?= $offre->getReponse() ?>
                        <?= !empty($offre->getDateReponse()) ? $offre->getDateReponse()->format('d/m/Y') : '' ?></td>
                    <td class="text-center">
                        <?= $offre->getRelance() === 'oui' ?  "<i class='fa-solid fa-check'  style='color:green; font-size:25pt'></i>" : '' ?>

                        <?= !empty($offre->getRelanceAt()) ? $offre->getRelanceAt()->format('d/m/Y') : '' ?></td>


                    <td class="align-middle"><?= $offre->gettype() === 'Informatique' ? '<i class="fa-solid fa-computer"></i>' : '<i class="fa-regular fa-face-frown-open"  style="color:red"></i>' ?></td>
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
<?php else: ?>
    Aucune candidature
<?php endif ?>