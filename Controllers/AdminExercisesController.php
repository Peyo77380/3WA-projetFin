<?php

abstract class AdminExercisesController extends Controller
{
    public $sentences;
    public $exerciseName;


    public function __construct($target)
    {

        parent::__construct($target, $this->sentences);
    }
}