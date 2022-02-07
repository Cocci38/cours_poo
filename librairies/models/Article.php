<?php

require_once('librairies\models\Model.php');

class Article extends Model{

    /* Affiche un article et  Supprimer un article et Retourne la liste des articles classés par date de création grace à Model*/
    protected $table = "articles";
}



?>