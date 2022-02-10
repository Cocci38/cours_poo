<?php

spl_autoload_register(function ($className)
{
    // className = Controllers\Article
    // require = libraries/Controllers/Article.php;
    $className = str_replace("\\", "/", $className);

    require_once("librairies/$className.php");
});



?>