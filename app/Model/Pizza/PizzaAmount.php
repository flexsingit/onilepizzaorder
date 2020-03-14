<?php

namespace App\Model\Pizza;

use Illuminate\Database\Eloquent\Model;

class PizzaAmount extends Model {

    protected $fillable = ['pizza_category_id', 'pizza_type_id', 'amount'];

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

}
