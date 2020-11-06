<?php

// gère la correction des exercices de textes à trous.
class madLibsResultController extends Controller
{
    // texte complet, y compris les mots des trous, indiqués entre **
    public $madLibsText;

    // liste des mots correspondant aux trous, dans l'ordre d'apparition dans le texte
    public $madLibsWords;
    public $madLibsAnswers;
    public $madLibsExercise;
    public $note;
    public $correctionList;

    public function __construct($target)
    {
        $this->setConnectedUserFilter('userConnection');
        $this->setTitle('Correction - Texte à trous');
        $this->setDescription('Correction des exercices de textes à trous en italien');
        
        $this->recievePostForm();
        $this->getAnswers();
        $this->setNote();
        $this->setCorrection();
        $this->clearSession();

        $data = [
            'correctionList' => $this->correctionList,
            'madLibsExercise' => $this->madLibsExercise,
            'note' => $this->note,
        ];

        parent::__construct($target, $data);
    }


    public function getAnswers()
    {

        //récupère les réponses et les infos stockées par le controlleur précédant dans la $_SESSION
        
        if(isset($_SESSION['exercises']['text']) && isset($_SESSION['exercises']['words']) && isset($_SESSION['exercises']['exercise'])) {
            $this->madLibsText = $_SESSION['exercises']['text'];
            $this->madLibsWords = $_SESSION['exercises']['words'];
            $this->madLibsExercise = $_SESSION['exercises']['exercise'];
        } else {
            throw new Exception(json_encode(
                [
                    'message' => 'noAnswer',
                    'origin' => 'madLibs',
                ]));
            return;
        }
        

        $words = [];
        // mets en forme la réponse de l'élève pour la correction.
        foreach ($this->postResult as $index => $word) {
            if ($word === '') {
                $word = '//empty//';
            }

            $wordpos = strpos($index, 'word');
            $exerciseId = substr($index, 2, $wordpos - 2);

            $words[$exerciseId][] = $word;
        }

        $this->madLibsAnswers = $words;

    }

    public function setNote ()
    {
        // calcule la note sur la comparaison de la réponse et des éléments récupérés de la session.
        $this->note = 0;
        $totalCount = 0;
        foreach ($this->madLibsWords as $exerciseId => $words) {
            $totalCount += count($this->madLibsWords[$exerciseId]);

            for ($i = 0; $i < count($words); $i++) {

                if ($words[$i] === filter_var(html_entity_decode(htmlspecialchars_decode($this->madLibsAnswers[$exerciseId][$i])), FILTER_SANITIZE_STRING)) {
                    $this->note++;

                } else {
                    break;
                }
            }
        }

        $this->note = $this->note . "/" . $totalCount;
    }

    public function setCorrection ()
    {
        // prépare les infos sous forme de listes pour renvoyer vers la vue et afficher ensuite sous forme de tableau.
        $correction = [];

        foreach ($this->madLibsWords as $exerciseId => $words) {

            for ($i = 0; $i < count($words); $i++) {
                $correctWord = $words[$i];
                $userAnswer = filter_var(html_entity_decode(htmlspecialchars_decode($this->madLibsAnswers[$exerciseId][$i])), FILTER_SANITIZE_STRING);;
                $correct = FALSE;
                if ($correctWord === $userAnswer) {
                    $correct = TRUE;
                }

                $correction[$exerciseId][] = [
                    'correctWord' => $correctWord,
                    'answer' => $userAnswer,
                    'correction' => $correct,
                ];
            }


        }

        $this->correctionList = $correction;
    }

    public function clearSession () {
        unset($_SESSION['exercises']);
    }
}