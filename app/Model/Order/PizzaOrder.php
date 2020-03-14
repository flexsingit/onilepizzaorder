<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;

class PizzaOrder extends Model {

  protected $fillable = ['first_name','last_name','contact_number','address','status'];



}
