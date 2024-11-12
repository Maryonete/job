<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Exception\ArticleException;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;

class AdminController
{
    // public function editArticle(array $get, ?int $id = null)
    // {
    //     $article = empty($id) ? new Article() : ArticleRepository::findById($id);

    //     if (!empty($get['title'])) {
    //         $article->setTitle(htmlentities($get['title']));
    //     } else {
    //         throw new ArticleException('Titre de l\'article manquant');
    //     }
    //     if (empty($get['categorie'])) {
    //         throw new ArticleException('Catégorie de l\'article manquant');
    //     }
    //     $article->setCategorie(json_encode($get['categorie']));
    //     if (!empty($get['description'])) {
    //         $article->setDescription(htmlentities($get['description']));
    //     } else {
    //         throw new ArticleException('Description de l\'article manquant');
    //     }
    //     ArticleRepository::save($article);
    // }

    // public function editCategorie(array $get, ?int $id = null)
    // {
    //     $categorie = empty($id) ? new Categorie() : CategorieRepository::findById($id);

    //     if (!empty($get['name'])) {
    //         $categorie->setName(htmlentities($get['name']));
    //     } else {
    //         throw new ArticleException('Nom de la catégorie manquant');
    //     }
    //     CategorieRepository::save($categorie);
    // }
}
