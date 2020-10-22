<?php

class IndexController extends Controller
{
    public function __construct($target)
    {
        echo "arrivé sur controlleur index";
        parent::__construct($target);

    }
}