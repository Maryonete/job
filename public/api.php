<?php
// api.php
require "../vendor/autoload.php";

use App\Repository\OffreRepo;

// Autoriser les requêtes CORS si nécessaire
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

// Initialisation du routeur pour l'API
$router = new AltoRouter();
$router->setBasePath('/api');

// Route de test
$router->map('GET', '/a', function () {
    echo json_encode(['message' => 'API is working']);
    exit;
}, 'api-home');

// Routes API
$router->map('GET', '/admin/find/[*:q]', function ($q) {
    $data = (new OffreRepo)->getAllOffresByKeyWord($q);
    echo json_encode($data);
    exit;
}, 'api-find');

// Gestion des routes API
$match = $router->match();
if ($match === false) {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
} else {
    call_user_func_array($match['target'], $match['params']);
}
