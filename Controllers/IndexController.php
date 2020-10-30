<?php

class IndexController extends Controller
{
    public function __construct($target)
    {
        $this->setTitle('Bienvenue');
        $this->setDescription(
            'Lasciatemi parlare est un projet de site pour une professeur d\'italien, 
            qui permet de mettre en ligne des exercices librement accessibles, ainsi que 
            de prendre contact avec la professeur.');
        $this->setScript('splitScreen');
        parent::__construct($target);

    }
}