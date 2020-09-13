<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function orderItem()
    {
        return $this->hasMany('App\Order', 'order_id');
    }
//以下後ほど確認

    public function clientCompanyEndUsers()
    {
        return $this->belongsTo('App\ClientCompany', 'end_user_id','id');
    }

    public function clientCompanyClientUsers()
    {
        return $this->belongsTo('App\ClientCompany', 'client_user_id','id');
    }

    public function clientCompanyDeliveryUser() 
    {
        return $this->belongsTo('App\ClientCompany', 'delivery_user_id', 'id');
    }

}