<?php
// lance automatiquement la session si elle n'est pas déjà en place.
if(!isset($_SESSION))
{
    session_start();
}

?>
