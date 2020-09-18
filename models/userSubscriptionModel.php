<?php
require('./params/database.php');

class userSubscriptionModel
{
    public function getCountries () {
        $filehandle = fopen("./resources/sql-pays.csv", 'r');

        while( ($row = fgetcsv($filehandle, 0, ",")) !== FALSE)
        {
            $countries[] = [
                'countryName' => $row[4],
                'countryCode' => $row[3],
            ];
        };

        return $countries;
    }
}