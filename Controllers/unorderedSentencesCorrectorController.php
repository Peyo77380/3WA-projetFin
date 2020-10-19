<?php


Class unorderedSentencesCorrectorController
{

    public $result;

    public function __construct ()
    {

        var_dump($_SESSION);

        $post = $_POST;
        $correctAnswers = $_SESSION['exercises']['unorderedSentences']['correct'];
        $userAnswers = [];
        $note = 0;


        foreach ($post as $answer) {
            $answer = explode(" ", $answer);
            $userAnswers[] = $answer;
        }


        foreach ($userAnswers as $key => $value) {

            if ($value == $correctAnswers[$key]) {
                $note++;
                $rating = 'Correct';
            } else {
                $rating = 'Faux';
            }

            $individualCheck =
                ['correctAnswer' => implode(" ", $correctAnswers[$key]['sentence']),
                    'userAnswer' => implode(" ", $value),
                    'rating' => $rating
                ];

            $this->result['correction'][$key] = $individualCheck;

        }
        $this->result['note'] = $note . " / " . count($correctAnswers);


        return $this->result;

    }
}