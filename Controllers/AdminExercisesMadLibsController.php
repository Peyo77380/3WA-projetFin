<?php

// gère l'affichage de la page d'admin des textes à trous
require_once(__DIR__ . '/AdminExercisesController.php');

class AdminExercisesMadLibsController extends AdminExercisesController
{
    public function __construct($target)
    {
        $this->setAdminFilter('userConnection');
        $this->setTitle('Admin Textes à trous');
        $this->setScript('adminExercisesMadLibs');
        $this->setScript('adminExercisesMadLibsNewExercise');
        $this->setDescription('Page de gestion de l\'exercise de textes à trous, réservée à certains utilisateurs disposant des droits.');

        $this->exerciseName = 'madLibs';

        $this->getSentences();
        
        parent::__construct($target, $this->sentences);
    }


}