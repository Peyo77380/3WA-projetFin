<?php

require_once(__DIR__ . '/AdminExercisesController.php');


class AdminExercisesUnorderedSentencesController extends AdminExercisesController
{
    public function __construct($target)
    {
        $this->exerciseName = 'UnorderedSentences';
        parent::__construct($target);
    }


}