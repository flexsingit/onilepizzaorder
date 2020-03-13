<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class OrderManagementController extends AdminController {

    public function getPizzaOrder() {
        return $this->renderView("pizza.order.list");
    }

    public function pizzaOrderAjax(Request $request) {

        $order = $request->get('order');
       
        $start = $request->get('start');

        $limit = $request->get('length');

        $list =  \App\Model\Order\PizzaOrder::with('users');
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
                $row->users->first_name ." ".$row->users->last_name,
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

    public function changeStatusPizzaType ($id) {
        $object = \App\Model\Order\PizzaOrder::find($id);
        return \App\Facades\Tools::changeStatus($object);
    }

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
                'user_id' => 'required',
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


        $this->page_vars['model'] = $model;

        return $this->renderView('pizza.order.form');
    }

    

  public function getOrderItem() {
        return $this->renderView("pizza.order_item.list");
    }

    public function orderItemAjax(Request $request) {

        $order = $request->get('order');
       
        $start = $request->get('start');

        $limit = $request->get('length');

        $list =  \App\Model\Order\OrderItem::with(['orders' => function($q){
        $q->with('users');
        },'pizza_details' => function($qq){
        $qq->with(['pizza_name','pizza_size']);
        }]);
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
            $action = '<a href="' . \App\Facades\Tools::createdAdminEndUrl('pizza/order/item/form/' . $row->id) . '" class = "btn-xs btn-info" >Edit</a>';

            $data[] = array(

                $row->id,
                $row->orders->users->first_name . " " . $row->orders->users->first_name,
                $row->pizza_details->pizza_name->name,
                $row->pizza_details->pizza_size->name,
                $row->amount,
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

    public function changeStatusOrderItem ($id) {
        $object = \App\Model\Pizza\PizzaCategory::find($id);
        return \App\Facades\Tools::changeStatus($object);
    }

    public function orderItemForm($id = 0) {
        $this->setPageTitle('Add/Edit Order Item');

        $model = \App\Model\Pizza\PizzaCategory::find($id);
        
        if ($id > 0) {
            if (!$model) {
                session()->flash('page_action_flash_error', __('Either record id is missing or requested record does not exist.'));
                request()->flash();
                return redirect(url()->previous());
            }
        } else {

            $model = new \App\Model\Pizza\PizzaCategory();
        }

        $request = request();
  
        if ($request->isMethod('POST')) {

            $errors = array();

            $data = $request->post();
           //dd($data);
            $rules = [

                'name' => 'required|unique:pizza_categories,name,' . $model->id,
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
                            
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('pizza/category/form/'.$model->id));
                            exit;
                        } else {
                            session()->put('msg_success', 'New Pizza Type has been added successfully');
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('pizza/category/form'));
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
       
        $this->page_vars['model'] = $model;

        return $this->renderView('pizza.order_item.form');
    }



}
