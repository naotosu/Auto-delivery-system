<?php

namespace App\Services;

class GoogleSheet
{
    public static function InitializeClient() {

        $credentials_path = storage_path('app/google-credentials.json');
        $client = new \Google_Client();
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentials_path);
        return new \Google_Service_Sheets($client);
    }
}
