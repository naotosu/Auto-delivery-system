<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function clientCompanyEndUser()
    {
        return $this->belongsTo('App\Models\ClientCompany', 'end_user_id', 'id');
    }

    public function clientCompanyClientUser()
    {
        return $this->belongsTo('App\Models\ClientCompany', 'client_user_id', 'id');
    }

    public function clientCompanyDeliveryUser() 
    {
        return $this->belongsTo('App\Models\ClientCompany', 'delivery_user_id', 'id');
    }

    public function transportCompany() 
    {
        return $this->belongsTo('App\Models\TransportCompany', 'transport_id', 'id');
    }

}