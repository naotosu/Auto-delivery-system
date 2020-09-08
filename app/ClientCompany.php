<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCompany extends Model
{
    protected $table = 'client_companies';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Items()
    {
    	return $this->belognsToMany('Item::class', 'items', 'end_user_id', 'id')
                $this->belognsToMany('Item::class', 'items', 'client_user_id', 'id');
    }
}
