<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCompany extends Model
{
    protected $table = 'client_companies';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function items()
    {
    	return $this->hasMany('App\Item', 'id', 'end_user_id');
                $this->gasMany('App\Item', 'id', 'client_user_id');
    }

    public function orders()
    {
    	return $this->hasMany('App\Order', 'id', 'delivery_user_id');
    }
}
