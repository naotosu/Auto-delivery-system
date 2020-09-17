<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class temporary extends Model
{
	public function item()
	{
		return $this->belongsTo('App\Models\Item', 'item_code', 'item_code');
	}
	
	public function order()
	{
		return $this->belongsTo('App\Models\Order', 'item_code', 'item_code');
	}

	public function clientCompany() 
	{
		return $this->belongsTo('App\Models\ClientCompany', 'delivery_user_id', 'id');
	}
}
