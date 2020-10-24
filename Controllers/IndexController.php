<?php

class IndexController extends Controller
{
    public function __construct($target)
    {
        $this->setTitle('Bienvenue');
        $this->setDescription(
            'Parliamo est un projet de site pour une professeur d\'italien, 
            qui permet de mettre en ligne des exercices librement accessibles, ainsi que 
            de prendre contact avec la professeur.');
        parent::__construct($target);

    }
}