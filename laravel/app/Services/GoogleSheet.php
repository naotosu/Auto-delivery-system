<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;

class GoogleSheet
{
    public static function InitializeClient() {

        Log::error("start InitializeClient");
        try {
            if (! env('APP_ENV')) {
                $app_env = env('APP_ENV');
            
                // heroku用
                if ($app_env == 'heroku') {
                    $credentials_path = env('GOOGLE_APPLICATION_CREDENTIALS');
                }

            //ローカル用
            } else {
                $credentials_path = storage_path('app/json/credentials.json');
            }

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
