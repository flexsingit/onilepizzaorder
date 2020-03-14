<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

//Route::get('/', function () {
//    return view('welcome');
//});
Route::match(['get', 'post'], '/', 'Admin\LoginController@login');

Route::group(['prefix' => 'admin', 'middleware' => array('web', 'adminauth')], function() {

    //--------------------------- Admin Login or Logout Section --------------------------//

    Route::get('/', 'Admin\LoginController@login');
    Route::match(['get', 'post'], '/login', 'Admin\LoginController@login');
    Route::get('/logout', 'Admin\LoginController@logout');

    //***************************************************

    // --------------------------   Dashboard section -------------------------- //

   Route::get('dashboard', 'Admin\DashboardController@index');

    // ---------------    Admin Managment section   ------------------- //
    Route::group(['prefix' => 'admin_managment'], function() {

        Route::get('list', 'Admin\AdminManagementController@index');
        Route::get('list/ajax', 'Admin\AdminManagementController@listAjax');
        Route::get('change/status/{id}', 'Admin\AdminManagementController@changeStatus');
        Route::match(['get', 'post'], 'form/{id?}', 'Admin\AdminManagementController@form');
        
        });

// -----------------   pizza items  ---------------------------- //

Route::group(['prefix' => 'pizza'], function() {

            Route::group(['prefix' => 'type'], function() {
                Route::get('list', 'Admin\CategoryManagementController@getPizzaType');
                Route::get('list/ajax', 'Admin\CategoryManagementController@pizzaTypeAjax');
                Route::get('change/status/{id}', 'Admin\CategoryManagementController@changeStatusPizzaType');
                Route::match(['get', 'post'], 'form/{id?}', 'Admin\CategoryManagementController@pizzaTypeForm');
            });

            Route::group(['prefix' => 'category'], function() {
                Route::get('list', 'Admin\CategoryManagementController@getPizzaCategory');
                Route::get('list/ajax', 'Admin\CategoryManagementController@pizzaCategoryAjax');
                Route::get('change/status/{id}', 'Admin\CategoryManagementController@changeStatusPizzaCategory');
                Route::match(['get', 'post'], 'form/{id?}', 'Admin\CategoryManagementController@pizzaCategoryForm');
                Route::get('/delete/{id}', 'Admin\CategoryManagementController@deletePizzaCategory');
            });

            Route::group(['prefix' => 'amount'], function(){
              Route::get('list','Admin\CategoryManagementController@getPizzaAmount');
             Route::get('list/ajax', 'Admin\CategoryManagementController@pizzaAmountAjax');
                Route::get('change/status/{id}', 'Admin\CategoryManagementController@changeStatusPizzaAmount');
                Route::match(['get', 'post'], 'form/{id?}', 'Admin\CategoryManagementController@pizzaAmountForm');
            });
 // ---------------------------   rder pizza   -----------------------------------//

            Route::group(['prefix' => 'order'], function() {
           
                Route::get('list', 'Admin\OrderManagementController@getPizzaOrder');
                Route::get('list/ajax', 'Admin\OrderManagementController@pizzaOrderAjax');
                Route::get('change/status/{id}', 'Admin\OrderManagementController@changeStatusPizzaOrder');
                Route::match(['get', 'post'], 'form/{id?}', 'Admin\OrderManagementController@pizzaOrderForm');
          

            Route::group(['prefix' => 'item'], function() {
                Route::get('list', 'Admin\OrderManagementController@getOrderItem');
                Route::get('list/ajax', 'Admin\OrderManagementController@orderItemAjax');
                Route::get('change/status/{id}', 'Admin\OrderManagementController@changeStatusOrderItem');
                Route::match(['get', 'post'], 'form/{id?}', 'Admin\OrderManagementController@orderItemForm');
                Route::get('/delete/{id}', 'Admin\OrderManagementController@deleteItem');
            });

         

        });


    });

});

