<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCompany extends Model
{
    protected $table = 'client_companys';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
