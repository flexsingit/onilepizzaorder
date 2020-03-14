<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {

    protected $fillable = ['pizza_order_id', 'pizza_category_id', 'pizza_type_id', 'amount','quantity','status'];


        /* *************************
        Name :   Pizza Name 
        Description :One to One Relation With Piza Name
        Author : Gyanendra Singh
        @params : N/A
        Return : data

       ************************* */

        public  function pizza_name(){
        return $this->hasOne(\App\Model\Pizza\PizzaCategory::class,'id','pizza_category_id');
             }

        /* *************************
        Name :   Pizza Size 
        Description :One to One Relation With Piza Size
        @params : N/A
        Return : data
        ************************* */

             public  function pizza_size(){
             return $this->hasOne(\App\Model\Pizza\PizzaType::class,'id','pizza_type_id');
             }

        /* *************************
         Name :   Pizza Order 
         Description :One to One Relation With Piza Order
         @params : N/A
         Return : data
        ************************* */
              
           public  function pizza_order(){
             return $this->hasOne(\App\Model\Order\PizzaOrder::class,'id','pizza_order_id');
             }


             public static function deleteData($id){
   
               return  \App\Model\Order\OrderItem::where('id', '=', $id)->delete();
   
  }

}
