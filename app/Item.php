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
    	return $this->hasMany('App\Order', 'item_id', 'item_id');
    }

    public function client_company()
    {
    	return $this->belongsTo('App\ClientCompany', 'end_user_id','id');
                $this->belongsTo('App\ClientCompany', 'client_user_id','id');
    }

}
