<?php

namespace Models;

require_once('librairies\models\Model.php');

class Article extends Model{

    /* Affiche un article, supprimer un article et Retourne la liste des articles classés par date de création grace à la classe Model*/
    protected $table = "articles";
}

?>