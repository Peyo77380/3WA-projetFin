<?php

// affiche les corrections des exercices de phrases destructurées.
class UnorderedSentencesResultController extends Controller
{

    public $result;
    public $userAnswers = [];
    public $note = 0;
    public $correctAnswers;

    public function __construct($target)
    {
        $this->setConnectedUserFilter('userConnection');
        $this->setTitle('Correction - Phrases destructurées');
        $this->setDescription('Correction des exercices de phrases destructurées en italien');

        $this->recievePostForm();
        $this->prepareAnswerForChecking();
        $this->getCorrectAnswer();
        $this->setCorrection();


        parent::__construct($target, $this->result);

        $this->clearSession();

    }

    public function prepareAnswerForChecking()
    {
        // découpe les strings renvoyées par les inputs de l'exercice.
        foreach ($this->postResult as $answer) {
            $answer = explode(" ", $answer);
            $this->userAnswers[] = $answer;
        }

    }

    public function getCorrectAnswer()
    {
        // récupère les infos stockées par le controlleur précédent en $_SESSION
        $this->correctAnswers = $_SESSION['exercises']['unorderedSentences']['correct'];
    }

    public function setCorrection()
    {
        // compare les éléments du post et les éléments stokés en session

        foreach ($this->userAnswers as $key => $values) {

            $userAnswer = [];
            foreach ($values as $exercise) {
                $userAnswer[] = html_entity_decode(htmlspecialchars_decode($exercise));
            }
            $answer = implode(" ", $this->correctAnswers[$key]['sentence']);
            $givenAnswer = implode(" ", $userAnswer);

            // augmente la note si bonne réponse
            // indique si la réponse est correcte ou non.
            if ($givenAnswer == $answer) {
                $this->note++;
                $rating = 'Correct';
            } else {
                $rating = 'Faux';
            }

            // retourne une liste pour chaque réponse contenant les infos à afficher sur la vue.
            $individualCheck =
                ['correctAnswer' => $answer,
                    'userAnswer' => $givenAnswer,
                    'rating' => $rating,
                ];

            $this->result['correction'][$key] = $individualCheck;

        }
        $this->result['note'] = $this->note . " / " . count($this->correctAnswers);
    }

    public function clearSession()
    {
        unset($_SESSION['exercises']);
    }
}