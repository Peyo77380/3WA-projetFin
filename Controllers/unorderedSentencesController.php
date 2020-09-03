<?php
require ('connect.php');


$sentences = ['Luca mangia la mela',
    'Il gatto sale le scale',
    'Gli studenti sono bravi',
    'Maria ha molte amiche',
    'La bottiglia è sul tavolo',
    'I bambini e gli studenti giocano insieme',
    'L\'hotel si trova vicino al bar',
    'Il computer è acceso ma la luce è spenta',
    'La mia città è molto grande e ha molti monumenti famosi',
    'Voglio chiamare Marta e parlare con lei ma non so se mi può rispondere',

];




function sentenceCutter ($a){
    $sentence = explode(" ", $a);

    $cutSentences = $sentence;
    return $cutSentences;
}

function sentenceRandomizer ($a) {

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
            $rating = 'Correct';
        } else {
            $rating = 'Faux';
        }

        $individualCheck =
            ['correctAnswer' => implode(" ", $correctAnswers[$key]),
            'userAnswer' => implode(" ", $value),
            'rating' => $rating
            ];

        $result['correction'][$key] = $individualCheck;

    }
    $result['note'] = $note . " / " . count($correctAnswers);
    return $result;

}
