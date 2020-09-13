<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    public function orderItems()
    {
    	return $this->hasMany('App\OrderItem', 'item_code', 'item_code');
    }

}
