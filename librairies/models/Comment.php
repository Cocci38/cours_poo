<?php

namespace Models;


class Comment extends Model{

    // Trouver un commentaire et Supprimer un commentaire
    protected $table = "comments";

    //Pour récupérer tous les commentaires

public function findAllWithArticle(int $article_id) : array
{
    $query = $this->pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id");
    $query->execute(['article_id' => $article_id]);
    $commentaires = $query->fetchAll();

    return $commentaires;
}

// Insérer un commentaire

public function insert(string $author, string $content, int $article_id) : void
{
    $query = $this->pdo->prepare('INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()');
    $query->execute(compact('author', 'content', 'article_id'));
}
}





?>