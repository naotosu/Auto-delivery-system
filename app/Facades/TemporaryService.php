<?php

namespace App\Facades;

use Illuminate\Database\Eloquent\Model;

class TemporaryService extends Model
{
    protected static function getFacadeAccessor() {
    	return 'TemporaryService';
    }
}
