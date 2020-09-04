<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function orderIndex(Builder $order_index, array $params): Builder
    {
    	//$order_index = order::query();　←このページでは不要？
    	$order_index
    		->where('item_id', $params['item_id'])
    		->andwhereColumn('order_start', '<' 'order_end');
    	$order_indexs = $order_index->get();

    	return $order_indexs;
    }
}