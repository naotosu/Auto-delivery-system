<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class temporary extends Model
{
	public function item()
	{
		return $this->belongsTo('App\Item', 'item_code', 'item_code');
	}
	
	public function order()
	{
		return $this->belongsTo('App\Order', 'item_code', 'item_code');
	}

	public function clientCompany() 
	{
		return $this->belongsTo('App\ClientCompany', 'delivery_user_id', 'id');
	}
}
