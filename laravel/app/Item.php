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
    	return $this->hasMany('Order::class', 'item_id', 'item_id');
    }

    public function client_company()
    {
    	return $this->belognsToMany('ClientCompany::class', 'client_companies','end_user_id','id')
                $this->belognsToMany('ClientCompany::class', 'client_companies','client_user_id','id');
    }

}
