<?php

namespace Controllers;

class Article extends Controller
{
    protected $modelName = \Models\Article::class;

    public function index()
    {
        // Montrer la liste
        /**
         * 2. Récupération des articles
         */
        // On utilisera ici la méthode query (pas besoin de préparation car aucune variable n'entre en jeu)
        // On fouille le résultat pour en extraire les données réelles
        $articles = $this->model->findAll("created_at DESC");

        /**
         * 3. Affichage
         */
        $pageTitle = "Accueil";

        \Renderer::render('articles/index', compact('pageTitle', 'articles'));
    }

    public function show()
    {
        //Montrer un article
        $commentModel = new \Models\Comment();
        /**
         * 1. Récupération du param "id" et vérification de celui-ci
         */
        // On part du principe qu'on ne possède pas de param "id"
        $article_id = null;

        // Mais si il y'en a un et que c'est un nombre entier, alors c'est cool
        if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
            $article_id = $_GET['id'];
        }

        // On peut désormais décider : erreur ou pas ?!
        if (!$article_id) {
            die("Vous devez préciser un paramètre `id` dans l'URL !");
        }

        /**
         * 2. Connexion à la base de données avec PDO
         * Attention, on précise ici deux options :
         * - Le mode d'erreur : le mode exception permet à PDO de nous prévenir violament quand on fait une connerie ;-)
         * - Le mode d'exploitation : FETCH_ASSOC veut dire qu'on exploitera les données sous la forme de tableaux associatifs
         * 
         * PS : Vous remarquez que ce sont les mêmes lignes que pour l'index.php ?!
         */

        /**
         * 3. Récupération de l'article en question
         * On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur : Ne faites
         * jamais confiance à ce connard d'utilisateur ! :D
         */
        /*$query = $pdo->prepare("SELECT * FROM articles WHERE id = :article_id");

        // On exécute la requête en précisant le paramètre :article_id 
        $query->execute(['article_id' => $article_id]);

        // On fouille le résultat pour en extraire les données réelles de l'article
        $article = $query->fetch();*/
        $article = $this->model->find($article_id);
        /**
         * 4. Récupération des commentaires de l'article en question
         * Pareil, toujours une requête préparée pour sécuriser la donnée filée par l'utilisateur (cet enfoiré en puissance !)
         */
        /*$query = $pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id");
        $query->execute(['article_id' => $article_id]);
        $commentaires = $query->fetchAll();*/
        $commentaires = $commentModel->findAllWithArticle($article_id);
        /**
         * 5. On affiche 
         */
        $pageTitle = $article['title'];

        \Renderer::render('articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));

        //compact('pageTitle', 'article')
        //['pageTitle' => $pageTitle, 'article' => $article]
    }

    public function delete()
    {
        // Supprimer un article
        /**
         * 1. On vérifie que le GET possède bien un paramètre "id" (delete.php?id=202) et que c'est bien un nombre
         */
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ?! Tu n'as pas précisé l'id de l'article !");
        }
        $id = $_GET['id'];
        /**
         * 3. Vérification que l'article existe bel et bien
         */
        $article = $this->model->find($id);
        if (!$article) {
            die("L'article $id n'existe pas, vous ne pouvez donc pas le supprimer !");
        }
        /**
         * 4. Réelle suppression de l'article
         */
        $this->model->delete($id);
        /**
         * 5. Redirection vers la page d'accueil
         */

        \Http::redirect('index.php');

    }
}




?>