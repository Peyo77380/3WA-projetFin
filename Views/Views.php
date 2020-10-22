<?php

class Views
{
    public function __constructor($request)
    {
        echo 'new view';
        include(layout . phtml);

        include($request . '.phtml');


        include(footer . phtml);

    }
}