<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;

class PizzaOrder extends Model {

  protected $fillable = ['first_name','last_name','contact_number','address','status'];

     public static function deleteData($id){
   
               return  \App\Model\Order\PizzaOrder::where('id', '=', $id)->delete();
   
  }

  

}
