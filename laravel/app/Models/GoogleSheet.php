<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleSheet extends Model
{
    public static function OrderItem() {

        $credentials_path = storage_path('app/json/credentials.json');
        $client = new \Google_Client();
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentials_path);
        return new \Google_Service_Sheets($client);
    }
}
