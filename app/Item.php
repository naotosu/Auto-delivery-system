<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function orders()
    {
    	return $this->hasMany('Order');
    }

    public function client_companys()
    {
    	return $this->hasMany('ClientCompany');
    }

    public function transport_companys()
    {
    	return $this->hasMany('TransportCompany');
    }
}
