<?php


class UnorderedSentencesModel
{
    public function __construct {
        //replace by a sql query to database
        $sentences = [
            'Luca mangia la mela',
            'Il gatto sale le scale',
            'Gli studenti sono bravi',
            'Maria ha molte amiche'
        ];

        return $sentences;
    }


}