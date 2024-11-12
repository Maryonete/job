<h1>Dashboard</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        <?php dump($offres) ?>
        <?php foreach ($offres as $offre): ?>
            <tr>
                <td><?= $offre->getId() ?></td>
                <td><?= $offre->getEntreprise() ?></td>
                <td><?php $dd = $offre->getDateCandidature();
                    if ($dd instanceof DateTime) {
                        echo $dd->format('d/m/Y');
                    } else {
                        echo "Date non définie";  // Afficher un message si la date est null
                    }
                    dump($offre->getDateCandidature()) ?></td>

            </tr>
        <?php endforeach ?>
</table>