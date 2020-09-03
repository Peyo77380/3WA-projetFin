<?php
require ('connect.php');


$sentences = ['Luca mangia la mela',
    'Il gatto sale le scale',
    'Gli studenti sono bravi',
    'Maria ha molte amiche'
];




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
$_SESSION['exercises']['unorderedSentences']['correct'] = [];

foreach($sentences as $sentence) {
    $_SESSION['exercises']['unorderedSentences']['correct'][] = sentenceCutter($sentence);
}


foreach($_SESSION['exercises']['unorderedSentences']['correct'] as $sentence){
    $unorderedSentences[] = sentenceRandomizer ($sentence);
}


function correctUnorderedSentences () {
    $post = $_POST;
    $correctAnswers = $_SESSION['exercises']['unorderedSentences']['correct'];
    $userAnswers = [];
    $note = 0;

    foreach ($post as $answer) {

        $answer = explode(" ", $answer);
        $userAnswers[] = $answer;
    }

    foreach ($userAnswers as $key=>$value) {
        if ($value == $correctAnswers[$key]) {
            $note ++;
            echo "ok";
        } else {
            echo "pas bon";
        }
    }

    echo $note . " / " . count($correctAnswers);
}
