<?php


class AboutController extends Controller
{
    public function __construct($target, $data = [])
    {
        $this->setTitle('A propos');
        $this->setScript('aboutDisplay');
        parent::__construct($target, $data);
    }
}