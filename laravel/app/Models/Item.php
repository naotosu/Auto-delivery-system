<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    public function orderItems()
    {
    	return $this->hasMany('App\Models\OrderItem', 'item_code', 'item_code');
    }

}
