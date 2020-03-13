<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;

class PizzaOrder extends Model {

    protected $fillable = ['user_id','status'];


  public  function users(){

        return $this->hasOne(\App\Model\User\User::class,'id','user_id');

             }

}
