<?php

//gère la page d'admin des exercices de phrases déstructurées
require_once(__DIR__ . '/AdminExercisesController.php');


class AdminExercisesUnorderedSentencesController extends AdminExercisesController
{
    public function __construct($target)
    {
        $this->setAdminFilter('userConnection');
        $this->setTitle('Admin - Phrases déstructurées');
        $this->setScript('adminExercisesUnorderedSentences');
        $this->setDescription('Page de gestion de l\'exercise de phrases destrucutérées, réservée à certains utilisateurs disposant des droits.');

        $this->exerciseName = 'UnorderedSentences';

        $this->getSentences();

        parent::__construct($target, $this->sentences);
    }


}