<?php
ob_start(); // Commence à tamponner la sortie
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/styles.css" rel="stylesheet">
    <script src="/assets/sorttable.js"></script>
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet" />
</head>

<body>
    <?php if (!empty($_SESSION['connecte'])): ?>
        <header class="p-3 text-bg-primary">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="/" class="nav-link px-2 text-white">Home</a></li>
                        <li>
                            <a href="<?= generateUrl('admin-initBD') ?>"
                                class=" nav-link px-2 text-white"
                                onclick="if(confirm('Voules-vous vraiment réinitialiser la BD ? ')){return true;} else{return false;}">Init BD</a>
                        </li>
                    </ul>
                    <div class="text-end">
                        <a href="/logout" class="btn btn-outline-light me-2">Déconnexion</a>
                    </div>
                </div>
            </div>
        </header>
    <?php endif ?>
    <div class="container bd-gutter mt-3 my-md-4 bd-layout">

        <?php
        // Récupération des messages flash
        $success = $_SESSION['success'] ?? null;
        $error = $_SESSION['error'] ?? null;

        if (!empty($error)) {
            echo "<div class='alert alert-danger'> $error </div>";
        }
        if (!empty($success)) {
            echo "<div class='alert alert-success'> $success </div>";
        }
        // Nettoyage des messages flash
        unset($_SESSION['success'], $_SESSION['error']);
