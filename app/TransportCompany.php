<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransportCompany extends Model
{
    protected $table = 'transport_companys';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
