<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogTestController extends Controller
{
    public function index()
    {
        \Log::info('ログ出力テスト');
        return 'log test';
    }
}
