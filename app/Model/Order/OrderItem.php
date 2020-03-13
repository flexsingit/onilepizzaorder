<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {

    protected $fillable = ['pizza_order_id', 'pizza_amount_id', 'amount','quantity','status'];



        public  function orders(){

        return $this->hasOne(\App\Model\Order\PizzaOrder::class,'id','pizza_order_id');

             }

         public  function pizza_details(){

         return $this->hasOne(\App\Model\Pizza\PizzaAmount::class,'id','pizza_amount_id');

             }

}
