<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {

    protected $fillable = ['pizza_order_id', 'pizza_category_id', 'pizza_type_id', 'amount','quantity','status'];


   /* One to One Relation With Piza Name*/

        public  function pizza_name(){
        return $this->hasOne(\App\Model\Pizza\PizzaCategory::class,'id','pizza_category_id');
             }

       /* One to One Relation With Piza Size*/

             public  function pizza_size(){
             return $this->hasOne(\App\Model\Pizza\PizzaType::class,'id','pizza_type_id');
             }

              /* One to One Relation With Piza Order*/

           public  function pizza_order(){
             return $this->hasOne(\App\Model\Order\PizzaOrder::class,'id','pizza_order_id');
             }

}
