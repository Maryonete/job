<form action="" method="post">
    <div class="row g-3 align-items-center mb-5">
        <!-- Colonne contenant les boutons -->
        <div class="col-12 col-md-8 d-flex flex-column flex-md-row justify-content-between">
            <a href="<?= generateUrl('admin-dashboard') ?>" class="btn btn-primary mb-2 mb-md-0 w-100 w-md-auto me-md-2">Toutes les candidatures</a>
            <a href="<?= generateUrl('admin-dashboard', ['etat' => 'encours']) ?>" class="btn btn-info mb-2 mb-md-0 w-100 w-md-auto me-md-2">Candidatures en cours</a>
            <a href="<?= generateUrl('admin-dashboard', ['etat' => 'refuse']) ?>" class="btn btn-danger mb-2 mb-md-0 w-100 w-md-auto me-md-2">Candidatures refusées</a>
            <a href="<?= generateUrl('admin-dashboard', ['etat' => 'attente']) ?>" class="btn btn-success mb-2 mb-md-0 w-100 w-md-auto me-md-2">Candidatures en attente</a>
        </div>

        <!-- Colonne pour le champ de recherche -->
        <div class="col-12 col-md-4">
            <input type="text" name="find" id="btnFind" placeholder="Rechercher entreprise, lieu, contact" class="form-control">
        </div>
    </div>
</form>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputFind = document.getElementById('btnFind');
        const tableBody = document.querySelector('table tbody');

        inputFind.addEventListener("keyup", async (e) => {
            const searchValue = e.target.value;
            try {
                const response = await fetch(`/api/admin/find/${encodeURIComponent(searchValue)}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const offres = await response.json();
                updateTable(offres);
            } catch (error) {
                console.error('Erreur:', error);
            }
        });

        async function updateTable(offres) {
            // Récupérer la référence au corps du tableau
            const tableBody = document.querySelector("table tbody");

            // Vérifier si le corps du tableau existe
            if (!tableBody) {
                console.error("Table body not found!");
                return;
            }

            // Vider le corps du tableau actuel avant de le mettre à jour
            tableBody.innerHTML = "";

            // Remplir le tableau avec les nouvelles offres
            offres.forEach(offre => {
                // Créer une nouvelle ligne pour chaque offre
                const row = document.createElement("tr");

                // Appliquer la classe 'table-dark' si la réponse est 'NON'
                if (offre.reponse === "NON") {
                    row.classList.add("table-dark");
                }
                console.log(offre);
                // Ajouter les cellules de la ligne
                row.innerHTML = `
            <td>${offre.id}</td>
            <td> ${new Date(offre.dateCandidature.date).toLocaleDateString()}</td>
            <td>${offre.entreprise}</td>
            <td>${offre.lieu}</td>
            <td>${offre.description}</td>
            <td><a href="${offre.url}" target="_blank"><i class='fa-solid fa-link'></i></a></td>
            <td>${offre.contact}</td>
            <td>${offre.reponse}</td>
            <td>${offre.reponse_at ? new Date(offre.reponse_at.date).toLocaleDateString() : ''}</td>
            <td><a href="/offre/edit/${offre.id}" title="Mise à jour">
                    <i class="fa-solid fa-pen"></i>
                </a>
            </td>
            <td><a href="/offre/delete/${offre.id}"
                    title="Supprimer"
                    onclick="return confirm('Voulez-vous vraiment supprimer cette candidature ?');">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
        `;

                // Ajouter la nouvelle ligne au corps du tableau
                tableBody.appendChild(row);
            });
        }

    });
</script>