<?php
require ('connect.php');


$sentences = 'Luca mangia la mela';
    /*'Il gatto sale le scale',
    'Gli studenti sono bravi',
    'Maria ha molte amiche'*/




function sentenceCutter ($a){
    $cutSentences = [];
    $sentence = explode(" ", $a);

    $cutSentences = $sentence;
    return $cutSentences;
}

function sentenceRandomizer ($a) {

    $unorderedSentences = [];

    shuffle($a);
    $unorderedSentences = $a;

    return $unorderedSentences;
}

$_SESSION['exercises']['unorderedSentences']['correct'] = sentenceCutter($sentences);

if(!isset($_SESSION['roundCount'])){
    $_SESSION['roundCount'] = 0;
};

$unorderedSentences = sentenceRandomizer ($_SESSION['exercises']['unorderedSentences']['correct']);

