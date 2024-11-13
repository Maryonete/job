<?php

use App\Auth;
use App\Entity\Offre;
use App\Exception\UserException;
use App\Repository\OffreRepo;

require "../vendor/autoload.php";

// Initialisation du routeur
$router = new AltoRouter();
$router->setBasePath('');


$router->map('GET', '/', function () {
    require_once "../templates/login.php";
}, 'login');
$router->map('GET', '/logout', function () {
    require_once "../templates/logout.php";
}, 'logout');

$router->map('GET', '/initBD', function () {
    require_once "../templates/admin/initBD.php";
}, 'admin-initBD');

$router->map('GET', '/admin/[encours|refuse:etat]?', function ($etat = null) {
    $offres = (new OffreRepo)->getAllOffres($etat);
    require_once "../templates/admin/dashboard.php";
}, 'admin-dashboard');


require_once "../templates/partials/_header.php";


$router->map('GET', '/offre/add', function () {
    require_once "../templates/admin/offre/edit.php";
}, 'offre-add');


$router->map('GET', '/offre/[i:id]', function ($id) {
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
// // ARTICLE
// $router->map('GET', '/admin/articles/add', function () {
//     $categories =  CategorieRepository::findAll();
//     require_once "../templates/admin/edit.php";
// }, 'articles-add-form');

// $router->map('GET', '/admin/articles/update/[i:id]', function ($id) {
//     $categories =  CategorieRepository::findAll();
//     $article =  ArticleRepository::findById($id);
//     require_once "../templates/admin/edit.php";
// }, 'articles-update');


// $router->map('GET', '/admin/articles/delete/[i:id]', function ($id) {
//     ArticleRepository::delete($id);
//     redirectTo('admin-dashboard');
// }, 'article-delete');
// // CATEGORIES
// $router->map('GET', '/admin/categories', function () {
//     $categories =  CategorieRepository::findAll();
//     require_once "../templates/admin/categorie_list.php";
// }, 'categorie-list');

// $router->map('GET', '/admin/categories/add', function () {
//     require_once "../templates/admin/categorie_edit.php";
// }, 'categorie-add-form');



// $router->map('POST', '/admin/articles/edit/[i:id]?', function ($id = null) use ($router) {
//     try {
//         $adminController = new AdminController();
//         $adminController->editArticle($_POST, $id);
//         $_SESSION['success'] = empty($id) ? "L'article a été ajouté avec succès !" : "L'article a été mis à jour avec succès !";
//         // Redirection vers la liste des articles
//         redirectTo('admin-dashboard');
//     } catch (ArticleException $e) {
//         $_SESSION['error'] = $e->getMessage();
//         redirectTo('articles-add-form');
//     }
// }, 'article-edit-submit');
// $router->map('POST', '/admin/categorie/edit/[i:id]?', function ($id = null) use ($router) {
//     try {
//         $adminController = new AdminController();
//         $adminController->editCategorie($_POST, $id);
//         $_SESSION['success'] = empty($id) ? "Categorie a été ajouté avec succès !" : "La catégorie a été mise à jour avec succès !";
//         // Redirection vers la liste des articles
//         redirectTo('admin-dashboard');
//     } catch (ArticleException $e) {
//         $_SESSION['error'] = $e->getMessage();
//         redirectTo('categorie-add-form');
//     }
// }, 'categorie-edit-submit');


// Gestion des routes
$match = $router->match();




if ($match === false) {
    // Page non trouvée
    header('HTTP/1.0 404 Not Found');
    echo 'Page non trouvée';
} else {
    // Appel du handler correspondant
    call_user_func_array($match['target'], $match['params']);
}

require_once "../templates/partials/_footer.php";
