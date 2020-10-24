<?php

class IndexController extends Controller
{
    public function __construct($target)
    {
        $this->setTitle('Bienvenue');
        parent::__construct($target);

    }
}