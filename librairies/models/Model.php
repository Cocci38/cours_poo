<?php

namespace Models;


abstract class Model {

    // Fonctionne avec toutes les tables

    protected $pdo;
    protected $table;

    public function __construct()
    {
        $this->pdo = \Database::getPdo();
    }

    // Affiche un item d'une table

    public function find(int $id){
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        // On exécute la requête en précisant le paramètre :article_id 
        $query->execute(['id' => $id]);
        // On fouille le résultat pour en extraire les données réelles de l'article
        $item = $query->fetch();
        return $item;
    }

    // Supprimer un item de n'importe quelle table

function delete(int $id) :void
{
    $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
    $query->execute(['id' => $id]);
}

/**
 * Retourne la liste des articles classés par date de création
 * @return array
 */

public function findAll(?string $order = "") : array
{
    $sql = "SELECT * FROM {$this->table}";

    if($order){
        $sql .= " ORDER BY " . $order;
    }
    $resultats = $this->pdo->query($sql);
    // On fouille le résultat pour en extraire les données réelles
    $articles = $resultats->fetchAll();

    return $articles;
}
}


?>