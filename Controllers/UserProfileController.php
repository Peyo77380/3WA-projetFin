<?php


class UserProfileController extends Controller
{
    public function __construct($target, $data = [])
    {
        $this->setTitle('Votre profil');

        $this->setDescription('Votre profil - Lasciatemi Parlare');
        $this->setScript('userProfile');

        $knownlanguages = explode("/", $_SESSION['connectedUser']['knownlanguages']);
        $formattedLanguages = [];
        foreach ($knownlanguages as $knownlanguage) {
            $exploded = explode("-", $knownlanguage);
            if ($exploded[0] !== "" && isset($exploded[0])) {
                $formattedLanguages[$exploded[0]] = $exploded[1];
            }
        }

        parent::__construct($target, $formattedLanguages);
    }
}