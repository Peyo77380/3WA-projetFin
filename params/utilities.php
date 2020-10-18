<?php

function clean($string)
{
    return htmlspecialchars(htmlentities($string));
}

function postCleaner($post)
{
    $rebuildPost = [];

    foreach ($post as $key => $value) {
        // <script>
        $cleanValue = clean($value);
        $cleanKey = clean($key);


        $rebuildPost[$cleanKey] = $cleanValue;


    }

    return $rebuildPost;

}

