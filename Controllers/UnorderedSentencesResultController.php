<?php


class UnorderedSentencesResultController extends Controller
{

    public $result;
    public $userAnswers = [];
    public $note = 0;
    public $correctAnswers;

    public function __construct($target)
    {
        $this->setConnectedUserFilter();
        $this->setTitle('Correction - Phrases destructurées');
        $this->setDescription('Correction des exercices de phrases destructurées en italien');
        $post = $_POST;

        $this->recievePostForm();
        $this->prepareAnswerForChecking();
        $this->getCorrectAnswer();
        $this->setCorrection();


        parent::__construct($target, $this->result);

    }

    public function prepareAnswerForChecking()
    {

        foreach ($this->postResult as $answer) {
            $answer = explode(" ", $answer);
            $this->userAnswers[] = $answer;
        }

    }

    public function getCorrectAnswer()
    {
        $this->correctAnswers = $_SESSION['exercises']['unorderedSentences']['correct'];
    }

    public function setCorrection()
    {

        foreach ($this->userAnswers as $key => $values) {

            $userAnswer = $values;

            if ($userAnswer == $this->correctAnswers[$key]['sentence']) {
                $this->note++;
                $rating = 'Correct';
            } else {
                $rating = 'Faux';
            }

            $individualCheck =
                ['correctAnswer' => implode(" ", $this->correctAnswers[$key]['sentence']),
                    'userAnswer' => implode(" ", $userAnswer),
                    'rating' => $rating,
                ];

            $this->result['correction'][$key] = $individualCheck;

        }
        $this->result['note'] = $this->note . " / " . count($this->correctAnswers);
    }
}