<?php

use App\Auth;
use App\Exception\UserException;
use App\Repository\OffreRepo;

require "../vendor/autoload.php";




// Initialisation du routeur
$router = new AltoRouter();
$router->setBasePath('');
$api = false;

// echo (password_hash("!v?ENBDBw4PT", PASSWORD_DEFAULT));

// Routes API
$router->map('GET', '/api/admin/find/[*:q]', function ($q) {
    $data = (new OffreRepo)->getAllOffresByKeyWord($q);
    echo json_encode($data);
}, 'api-find');

$router->map('GET', '/', function () {
    require_once "../templates/login.php";
}, 'login');
$router->map('GET', '/logout', function () {
    require_once "../templates/logout.php";
}, 'logout');

$router->map('GET|POST', '/initBD', function () {
    require_once "../templates/admin/initBD.php";
    // redirectTo('admin-dashboard');
}, 'admin-initBD');
$router->map('GET', '/admin/[encours|refuse|attente|Autre:etat]?', function ($etat = null) {
    $offreRepro = new OffreRepo;
    $offres = $offreRepro->getAllOffres($etat);
    $offreRepro->getAllOffresXLS();
    require_once "../templates/admin/dashboard.php";
}, 'admin-dashboard');


$router->map('GET', '/offre/add', function () {
    require_once "../templates/admin/offre/edit.php";
}, 'offre-add');


$router->map('GET', '/offre/edit/[i:id]', function ($id) {
    $offre = OffreRepo::getOffreById($id);
    require_once "../templates/admin/offre/edit.php";
}, 'offre_edit');
$router->map('GET', '/offre/delete/[i:id]', function ($id) {
    OffreRepo::deleteOffreById($id);
    redirectTo('admin-dashboard');
}, 'offre_delete');

$router->map('POST', '/offre/[i:id]?', function ($id = null) {
    try {
        OffreRepo::editOffre($_POST, $id);
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    } finally {
        redirectTo('admin-dashboard');
    }
}, 'offre_edit_save');



$router->map('POST', '/', function () {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        try {
            $user = (new Auth())->login($_POST['email'], $_POST['password']);

            if ($user) {
                redirectTo('admin-dashboard');
            }
        } catch (UserException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirectTo('login');
        }
    }
}, 'login-submit');

// Gestion des routes
$match = $router->match();



$api = false;
if ($match === false) {
    // Page non trouvée
    header('HTTP/1.0 404 Not Found');
    echo 'Page non trouvée';
} else {
    session_start();

    // Vérification si la route correspond à une API
    if ($match['name'] === 'api-find') {
        // Autoriser les requêtes CORS si nécessaire
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');
        $api = true;
    } else {
        // Charger le header normal si ce n'est pas une API
        require_once "../templates/partials/_header.php";
    }

    // Appel du handler correspondant à la route
    call_user_func_array($match['target'], $match['params']);
}

if ($api === false) {

    require_once "../templates/partials/_footer.php";
}
