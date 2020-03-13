<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePizzaCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pizza_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pizza_type_id')->unsigned(); 
            $table->foreign('pizza_type_id')->references('id')->on('pizza_types');
            $table->string('image', 255); 
            $table->string('name', 255); 
            $table->string('amount', 55); 
            $table->tinyInteger('status')->default(1)->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pizza_categories');
    }
}
