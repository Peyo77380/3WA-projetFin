<?php

require_once(__DIR__ . '/AdminExercisesController.php');

class AdminUpdateExerciseController extends AdminExercisesController
{
    public function __construct($target)
    {
        $this->setAdminFilter('userConnection');
        $this->recievePostForm();
        var_dump($this->postResult);

        $this->setTitle('Modification d\'exercice');
        $this->setDescription('Page de modification d\'un exercise existant.');


        $exercise = [
            'exerciseName' => $this->postResult['exerciseName'],
            'exerciseId' => $this->postResult['exerciseId'],
            'exerciseContent' => $this->postResult['exerciseContent']
        ];


        parent::__construct($target, $exercise, $this->meta);
    }


}
/*
$exerciseName = $post['exerciseName'];
$values = $post['id'];

$conn  = new Database();
$sentence = $conn->getOne('SELECT * FROM '.$exerciseName.' WHERE id = ?', $values);







$post = $_POST;
$update = postCleaner($post);

$exerciseTranslation = '';
$exerciseContent = $post['exerciseContent'];
$exerciseId = $post['exerciseId'];

if (!isset($post['exerciseName'])) {
    throw new Exception('Pas de nom d\'exercice');
}
if ($post['exerciseName'] == 'unorderedSentences')
{
    $exerciseTranslation = 'Phrases déstructurées';
}
if($post['exerciseName'] == 'madLibs')
{
    $exerciseTranslation = 'Texte à trous';
}


return $display = [
    'dbTableName' => $post['exerciseName'],
    'name' => $exerciseTranslation,
    'content' => $exerciseContent,
    'id' => $exerciseId
];
*/

