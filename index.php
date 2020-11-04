<?php
//démarre la session
require_once('connect.php');

// outils nécessaires à de nombreux controlleurs.
require_once('./tools/utilities.php');

// redirige en fonction de l'url vers les controlleurs et les vues nécessaires.
include('Router.php');
$router = new Router();

?>
