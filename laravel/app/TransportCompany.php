<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransportCompany extends Model
{
    protected $table = 'transport_companies';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function orders() 
    {
    	return $this->hasMany('App\Order', 'id','transport_id');
    }
}
