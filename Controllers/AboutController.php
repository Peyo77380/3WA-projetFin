<?php


class AboutController extends Controller
{
    public function __construct($data)
    {
        parent::__construct($data);
        echo "arrivé sur about controller $data";
    }
}