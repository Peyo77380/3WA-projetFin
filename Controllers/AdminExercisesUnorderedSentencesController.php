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

        require_once('./models/ExercisesModel.php');
        $connection = new ExercisesModel();
        $connection->setTableName($this->exerciseName);
        $connection->setGetterQuery();
        $pdoResult = $connection->launchDBRequest();

        $this->sentences = decode($pdoResult);

        parent::__construct($target, $this->sentences);
    }


}