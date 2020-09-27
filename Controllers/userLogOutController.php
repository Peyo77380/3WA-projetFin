<?php

require('../connect.php');

session_destroy();

header('Location: ../index.phtml');