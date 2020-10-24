<?php

require_once(__DIR__ . '/AdminExercisesController.php');


class AdminExercisesUnorderedSentencesController extends AdminExercisesController
{
    public function __construct($target)
    {
        $this->setTitle('Admin - Phrases déstructurées');
        $this->setScript('adminExercisesUnorderedSentences');
        $this->setDescription('Page de gestion de l\'exercise de phrases destrucutérées, réservée à certains utilisateurs disposant des droits.');
        $this->exerciseName = 'UnorderedSentences';
        parent::__construct($target);
    }


}