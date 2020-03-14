<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class OrderManagementController extends AdminController {

      

        /* *************************
        Name :  Get Pizza Order 
        Description :Pizza Order allow to render View Page
        Author : Gyanendra Singh
        @params : N/A
        Return :   Render List page 
    ************************* */

    public function getPizzaOrder() {
        return $this->renderView("pizza.order.list");
    }


        /* *************************
        Name :  Pizza Order Ajax
        Description :Pizza Order allow to access some Pizza Order List of data
        @params : Yes
        @params : Yes
        Return :  responce
    ************************* */

    public function pizzaOrderAjax(Request $request) {

        $order = $request->get('order');
       
        $start = $request->get('start');

        $limit = $request->get('length');

        $list =new  \App\Model\Order\PizzaOrder();
        $totalData = $list->count();

        $totalFiltered = $list->count();
        $list = $list->skip($start)->take($limit);
        $list = $list->orderBy('id', 'ASC')->get();

        $data = array();
        foreach ($list as $row) {
            if ($row->status == 1) {
                $status = '<center><i id="status_' . $row->id . '" class="fa fa-check btn-xs btn-success" style="cursor:pointer;" onclick ="ChangeStatus(' . $row->id . ')"></i></center>';
            } else {
                $status = '<center><i id="status_' . $row->id . '" class="fa fa-close btn-xs btn-danger" style="cursor:pointer;" onclick ="ChangeStatus(' . $row->id . ')"></i></center>';
            }
            $action = '<a href="' . \App\Facades\Tools::createdAdminEndUrl('pizza/order/form/' . $row->id) . '" class = "btn-xs btn-info" >Edit</a>';

            $data[] = array(
                $row->id,
                $row->first_name,
                $row->last_name,
                 $row->contact_number,
                  $row->address,
                $status,
                \App\Facades\Tools::getFormattedDateMonthName($row->created_at),
                $action,
            );
        }

        $json_data = array(
            "draw" => intval($request->get('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return response()->json($json_data, 200);
    }

     /* *************************
        Name :  Pizza Order 
        Description :Pizza Order allow to change Pizza Order Status
        @params : Yes
        Return : status
    ************************* */

    public function changeStatusPizzaOrder ($id) {
        $object = \App\Model\Order\PizzaOrder::find($id);
        return \App\Facades\Tools::changeStatus($object);
    }


    /* *************************
        Name :  Pizza Order Form
        Description :Pizza Order Form allow to Create & Update Form
        @params : Yes
        Return :  Render form page To Following data
    ************************* */

    public function pizzaOrderForm($id = 0) {
        $this->setPageTitle('Add/Edit  Pizza Order');

        $model = \App\Model\Order\PizzaOrder::find($id);
        
        if ($id > 0) {
            if (!$model) {
                session()->flash('page_action_flash_error', __('Either record id is missing or requested record does not exist.'));
                request()->flash();
                return redirect(url()->previous());
            }
        } else {

            $model = new \App\Model\Order\PizzaOrder();
        }

        $request = request();
  
        if ($request->isMethod('POST')) {

            $errors = array();

            $data = $request->post();
           // dd($data);
            $rules = [
                 'first_name' => 'required',
                 'last_name' => 'required',
                  'contact_number' => 'required|min:11|numeric',
                   'address' => 'required',
                     'status' => 'required',
                
            ];

           


            $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
 
                   

            if (!$validator->fails()) {
                try {
                    unset($data['_token']);
                   
                    if (($id > 0 && $model->update($data)) || (!$id && $model = $model->create($data))) {
                     
                        
                        if ($id) {
                            session()->put('msg_success', 'Pizza Type has been updated successfully');
                            $request->flash();
                            
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('pizza/order/form/'.$model->id));
                            exit;
                        } else {
                            session()->put('msg_success', 'New Pizza Type has been added successfully');
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('pizza/order/form'));
                            exit;
                        }
                    } else {
                        session()->put('msg_error', 'New Pizza Type has been added successfully');
                    }
                } catch (Exception $e) {
                    session()->put('msg_error', 'New Pizza Type  has been added successfully');
                }
            } else {
                $this->page_vars['errors'] = $validator->errors();
            }
            $request->flash();
        }  

       $pizza_type = \App\Model\Pizza\PizzaType::pluck('name','id')->all();

         $pizza_category = \App\Model\Pizza\PizzaCategory::pluck('name','id')->all();

      

         $this->page_vars['pizza_type'] = $pizza_type;

        $this->page_vars['pizza_category'] = $pizza_category;

        $this->page_vars['model'] = $model;

        return $this->renderView('pizza.order.form');
    }


        /* *************************
        Name :  Get Order Item
        Description :Pizza Order allow to render View Page
        @params : N/A
        Return :   Render List page 
    ************************* */
   

    public function getOrderItem() {
        return $this->renderView("pizza.order_item.list");
    }


        /* *************************
        Name :  Order Item Ajax
        Description :Pizza Order allow to access some Pizza Order List of data
        @params : Yes
        @params : Yes
        Return :  responce
    ************************* */

    public function orderItemAjax(Request $request) {

        $order = $request->get('order');
       
        $start = $request->get('start');

        $limit = $request->get('length');

        $list =  \App\Model\Order\OrderItem::with(['pizza_name','pizza_size','pizza_order']);
        $totalData = $list->count();

        $totalFiltered = $list->count();
        $list = $list->skip($start)->take($limit);
        $list = $list->orderBy('id', 'ASC')->get();

        $data = array();
        foreach ($list as $row) {

            if ($row->status == 1) {
                $status = '<center><i id="status_' . $row->id . '" class="fa fa-check btn-xs btn-success" style="cursor:pointer;" onclick ="ChangeStatus(' . $row->id . ')"></i></center>';
            } else {
                $status = '<center><i id="status_' . $row->id . '" class="fa fa-close btn-xs btn-danger" style="cursor:pointer;" onclick ="ChangeStatus(' . $row->id . ')"></i></center>';
            }
            $action = '<a href="' . \App\Facades\Tools::createdAdminEndUrl('pizza/order/item/form/' . $row->id) . '" class = "btn-xs btn-info" >Edit</a>'." " .
            $action = '<a href="' . \App\Facades\Tools::createdAdminEndUrl('pizza/order/item/delete/' . $row->id) . '" class = "btn-xs btn-info" >Delete</a>';


            $data[] = array(

                $row->id,
                $row->pizza_order->first_name,
                $row->pizza_name->name,
                $row->pizza_size->name,
             //   $row->amount,
                $row->quantity,
                $status,
                \App\Facades\Tools::getFormattedDateMonthName($row->created_at),
                $action,
            );
        }

        $json_data = array(
            "draw" => intval($request->get('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return response()->json($json_data, 200);
    }

      /* *************************
        Name :  Order Item
        Description :Pizza Order allow to change Pizza Order Status
        @params : Yes
        Return :  status
    ************************* */

    public function changeStatusOrderItem ($id) {
        $object = \App\Model\Order\OrderItem::find($id);
        return \App\Facades\Tools::changeStatus($object);
    }


/* *************************
        Name :  Order Item Form
        Description : Order Item Form allow to Create & Update Form
        @params : Yes
        Return :  Render form page To Following data
    ************************* */


    public function orderItemForm($id = 0) {
        $this->setPageTitle('Add/Edit Order Item');

        $model = \App\Model\Order\OrderItem::find($id);
        
        if ($id > 0) {
            if (!$model) {
                session()->flash('page_action_flash_error', __('Either record id is missing or requested record does not exist.'));
                request()->flash();
                return redirect(url()->previous());
            }
        } else {

            $model = new \App\Model\Order\OrderItem();
        }

        $request = request();
  
        if ($request->isMethod('POST')) {

            $errors = array();

            $data = $request->post();
           //dd($data);
            $rules = [

                'pizza_order_id' => 'required',
                'pizza_category_id' => 'required',
                'pizza_type_id' => 'required',
                'quantity' => 'required',
               // 'amount' => 'required',
                'status' => 'required',
                
            ];


            $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
 
                   

            if (!$validator->fails()) {
                try {
                    unset($data['_token']);
                  
                    if (($id > 0 && $model->update($data)) || (!$id && $model = $model->create($data))) {
                     
                     if ($request->file('image')) {
                            $model->uploadImage();
                        }
                        
                        if ($id) {
                            session()->put('msg_success', 'Pizza Category has been updated successfully');
                            $request->flash();
                            
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('pizza/order/item/form/'.$model->id));
                            exit;
                        } else {
                            session()->put('msg_success', 'New Pizza Type has been added successfully');
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('pizza/order/item/form'));
                            exit;
                        }
                    } else {
                        session()->put('msg_error', 'New Pizza Category has been added successfully');
                    }
                } catch (Exception $e) {
                    session()->put('msg_error', 'New Pizza Category  has been added successfully');
                }
            } else {
                $this->page_vars['errors'] = $validator->errors();
            }
            $request->flash();
        }

         $pizza_order = \App\Model\Order\PizzaOrder::pluck('first_name','id')->all();


         $pizza_type = \App\Model\Pizza\PizzaType::pluck('name','id')->all();

         $pizza_category = \App\Model\Pizza\PizzaCategory::pluck('name','id')->all();

        $this->page_vars['pizza_order'] = $pizza_order;

         $this->page_vars['pizza_type'] = $pizza_type;

        $this->page_vars['pizza_category'] = $pizza_category;
       
        $this->page_vars['model'] = $model;

        return $this->renderView('pizza.order_item.form');
    }

public function deleteItem($id=0){

    if($id != 0){
      // Delete
      \App\Model\Order\OrderItem::deleteData($id);

      Session()->flash('message','Delete successfully.');
    }
     return $this->renderView('pizza.order_item.list');
  }

}
