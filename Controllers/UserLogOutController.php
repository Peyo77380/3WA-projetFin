<?php

// detruit toute la session en cours et renvoie à l'index.

session_destroy();

header('Location: ../Index');