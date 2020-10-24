<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;

class GoogleSheet
{
    public static function InitializeClient() {

        Log::error("start InitializeClient");
        try {
            $credentials_path = env('GOOGLE_APPLICATION_CREDENTIALS');
            $client = new \Google_Client();
            $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
            $client->setAuthConfig($credentials_path);
            return new \Google_Service_Sheets($client);
        } catch (\Exception $e) {
            Log::error("InitializeClient error");
            Log::error($e->getMessage());
        }
    }
}
