<?php
require ('connect.php');

$correctAnswer = $_SESSION['exercises']['unorderedSentences']['correct'];
$userAnswer = explode(" ", $_POST['answer']);

$result = checkAnswer($userAnswer, $correctAnswer);


function checkAnswer ($userAnswer, $correctAnswer) {
    try {
        if (!$userAnswer || $userAnswer[0] == "")
        {
            throw new Exception("Vous n'avez pas répondu. Recommencez.");
        }

        if(count($userAnswer) < count($correctAnswer)){
            throw new Exception("On dirait que vous avez oublié une partie de la phrase.");
        }

        if(count($userAnswer) > count($correctAnswer)){
            throw new Exception("Vous avez mis trop de mots!");
        }

        if ($userAnswer != $correctAnswer){
            $string = implode(" ", $userAnswer);
            throw new Exception("Il doit y avoir une erreur. Vous avez répondu " . $string . ". Réessayez.");
        }


        if ($userAnswer == $correctAnswer) {
            echo 'BRAVO';
            $_SESSION['error']['message'] = "";
            $_SESSION['roundCount'] = 0;
        }

    }
    catch (Exception $exception) {
        $_SESSION['error']['message'] = $exception->getMessage();



        header('Location:  unorderedSentences.phtml');
        return $_SESSION['roundCount'] += 1;
    }

}



