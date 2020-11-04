<?php

// gère les connections avec les fichiers comportant des infos nécessaires à la "fiche profil"

class userSubscriptionModel
{
    public function getCountry($iso)
    {
        // récupère le nom d'un pays en fonction d'un code iso.
        $filehandle = fopen("./resources/sql-pays.csv", 'r');
        $country = [];

        while (($row = fgetcsv($filehandle, 0, ",")) !== FALSE) {
            if ($row[3] == $iso) {
                $country = [
                    'countryName' => $row[4],
                    'countryCode' => $row[3],
                ];
                break;
            }
        }

        return $country;
    }

    public function getCountries()
    {
        // récupère la liste des pays (nom et code iso)
        $filehandle = fopen("./resources/sql-pays.csv", 'r');

        while (($row = fgetcsv($filehandle, 0, ",")) !== FALSE) {
            $countries[] = [
                'countryName' => $row[4],
                'countryCode' => $row[3],
            ];
        }

        return $countries;
    }


    public function getLanguages () {
        // récupère la liste des langues. (nom et code iso)
        $filehandle = fopen("./resources/sql-Lang-iso_639-2.csv", 'r');

        while( ($row = fgetcsv($filehandle, 0, ";")) !== FALSE)
        {
            $languages[] = [
                'languageName' => ucfirst($row[2]),
                'languageCode' => $row[0],
            ];
        }

        return $languages;
    }

    public function getLanguage ($iso) {
        // récupère le nom d'une langue en fonction du code iso'
        $filehandle = fopen("./resources/sql-Lang-iso_639-2.csv", 'r');
        $language = [];

        while( ($row = fgetcsv($filehandle, 0, ";")) !== FALSE )
        {
            if ($row[0] == $iso)
            {

                $language['languageName'] = ucfirst($row[2]);
                $language['languageCode'] = $row[0];

                break;
            }


        }

        return $language;

    }
}