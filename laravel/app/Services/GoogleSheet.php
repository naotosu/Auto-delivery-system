<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;

class GoogleSheet
{
    public static function InitializeClient() {

        Log::error("start InitializeClient");
        try {
            $credentials_path = path(env('GOOGLE_APPLICATION_CREDENTIALS'));
            Log::error($credentials_path);
            Log::error('gg2');
            $client = new \Google_Client();
            Log::error('gg3');
            $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
            Log::error('gg4');
            $client->setAuthConfig($credentials_path);
            Log::error($client);
            return new \Google_Service_Sheets($client);
        } catch (\Exception $e) {
            Log::error("InitializeClient error");
            Log::error($e->getMessage());
        }
    }
}
