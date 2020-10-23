<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;

class GoogleSheet
{
    public static function InitializeClient() {

        Log::error('gg1');
        $credentials_path = app_path('google-credentials.json');
        Log::error('gg2');
        $client = new \Google_Client();
        Log::error('gg3');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        Log::error('gg4');
        $client->setAuthConfig($credentials_path);
        Log::error('$client');
        return new \Google_Service_Sheets($client);
    }
}
