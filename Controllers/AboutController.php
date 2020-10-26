<?php


class AboutController extends Controller
{
    public function __construct($target, $data = [])
    {
        $this->setTitle('A propos');
        $this->setScript('aboutDisplay');
        $this->setDescription('Page de présentation du site Lasciatemi Parlare');
        parent::__construct($target, $data);
    }
}