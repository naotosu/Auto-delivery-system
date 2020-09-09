<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    public function orders()
    {
    	return $this->hasMany('App\Order', 'item_id', 'item_id');
    }

    public function client_company_end_users()
    {
    	return $this->hasMany('App\ClientCompany', 'end_user_id','id');
    }

    public function client_company_client_users()
    {
        return $this->hasmany('App\ClientCompany', 'client_user_id','id');
    }

}
