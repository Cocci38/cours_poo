<?php

require_once ('librairies\models\Model.php');

class Comment extends Model{

    //Pour récupérer tous les commentaires

public function findAllWithArticle(int $article_id) : array
{
    $query = $this->pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id");
    $query->execute(['article_id' => $article_id]);
    $commentaires = $query->fetchAll();

    return $commentaires;
}
// Trouver un commentaire

public function find(int $id)
{
    $query = $this->pdo->prepare('SELECT * FROM comments WHERE id = :id');
    $query->execute(['id' => $id]);
    $comment = $query->fetch();

    return $comment;
}

// Supprimer un commentaire

public function delete(int $id) : void 
{
    $query = $this->pdo->prepare('DELETE FROM comments WHERE id = :id');
    $query->execute(['id' => $id]);
}

// Insérer un commentaire

public function insert(string $author, string $content, int $article_id) : void
{
    $query = $this->pdo->prepare('INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()');
    $query->execute(compact('author', 'content', 'article_id'));
}
}





?>