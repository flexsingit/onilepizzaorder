<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class CategoryManagementController extends AdminController {


        /* *************************
        Name :  Get Pizza Type 
        Description :Pizza type allow to render View Page
        Author : Gyanendra Singh
        @params : N/A
        Return :   Render List page 
         ************************* */

    public function getPizzaType() {
        return $this->renderView("pizza.type.list");
    }


    /* *************************
        Name :  Pizza Type Ajax
        Description :Type Order allow to access some Pizza Type List of data
        @params : Yes
        Return :  responce
    ************************* */

    public function pizzaTypeAjax(Request $request) {

        $order = $request->get('order');
       
        $start = $request->get('start');

        $limit = $request->get('length');

        $list = new \App\Model\Pizza\PizzaType();
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
            $action = '<a href="' . \App\Facades\Tools::createdAdminEndUrl('pizza/type/form/' . $row->id) . '" class = "btn-xs btn-info" >Edit</a>';

            $data[] = array(
                $row->id,
                $row->name,
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
        Name :  Order Type
        Description :Pizza Type allow to change Pizza type Status
        @params : Yes
        Return :  status
    ************************* */


    public function changeStatusPizzaType ($id) {
        $object = \App\Model\Pizza\PizzaType::find($id);
        return \App\Facades\Tools::changeStatus($object);
    }


/* *************************
        Name :   Pizza Type Form
        Description :  Pizza Type Form allow to Create & Update Form
        @params : Yes
        Return :  Render form page To Following data
    ************************* */

    public function pizzaTypeForm($id = 0) {
        $this->setPageTitle('Add/Edit  Pizza Type');

        $model = \App\Model\Pizza\PizzaType::find($id);
        
        if ($id > 0) {
            if (!$model) {
                session()->flash('page_action_flash_error', __('Either record id is missing or requested record does not exist.'));
                request()->flash();
                return redirect(url()->previous());
            }
        } else {

            $model = new \App\Model\Pizza\PizzaType();
        }

        $request = request();
  
        if ($request->isMethod('POST')) {

            $errors = array();

            $data = $request->post();
           // dd($data);
            $rules = [
                'name' => 'required',
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
                            
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('pizza/type/form/'.$model->id));
                            exit;
                        } else {
                            session()->put('msg_success', 'New Pizza Type has been added successfully');
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('pizza/type/form'));
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
//        dd($model->image_url);
        return $this->renderView('pizza.type.form');
    }


      /* *************************
        Name :  Get Pizza Category 
        Description :Pizza Order allow to render View Page
        @params : N/A
        Return :   Render List page 
    ************************* */

  public function getPizzaCategory() {
        return $this->renderView("pizza.category.list");
    }


        /* *************************
        Name :  Pizza Category Ajax
        Description :Pizza Category allow to access some Pizza Category List of data
        @params : Yes
        @params : Yes
        Return :  responce
    ************************* */ 

    public function pizzaCategoryAjax(Request $request) {

        $order = $request->get('order');
       
        $start = $request->get('start');

        $limit = $request->get('length');

        $list = new  \App\Model\Pizza\PizzaCategory();
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
            $action = '<a href="' . \App\Facades\Tools::createdAdminEndUrl('pizza/category/form/' . $row->id) . '" class = "btn-xs btn-info" >Edit</a>'." " .
            $action = '<a href="' . \App\Facades\Tools::createdAdminEndUrl('pizza/category/delete/' . $row->id) . '" class = "btn-xs btn-info" >Delete</a>';

            $data[] = array(

                $row->id,
                $row->name,
                 '<img src="' . $row->image_url . '" style ="height:100px;width:100px;">',
                $row->description,
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
        Name :  Pizza Category 
        Description :Pizza Category allow to change Pizza Category Status
        @params : Yes
        Return : status
    ************************* */

    public function changeStatusPizzaCategory ($id) {
        $object = \App\Model\Pizza\PizzaCategory::find($id);
        return \App\Facades\Tools::changeStatus($object);
    }

     /* *************************
        Name :  Pizza Category Form
        Description :Pizza Category Form allow to Create & Update Form
        @params : Yes
        Return :  Render form page To Following data
    ************************* */

    public function pizzaCategoryForm($id = 0) {
        $this->setPageTitle('Add/Edit  Pizza Category');

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

        return $this->renderView('pizza.category.form');
    }


    public function deletePizzaCategory($id=0){

    if($id != 0){
      // Delete
      \App\Model\Pizza\PizzaCategory::deleteData($id);

      Session()->flash('message','Delete successfully.');
    }
     return $this->renderView('pizza.category.list');
  }



            /* *************************
        Name :  Get Pizza Amount 
        Description :Pizza Amount allow to render View Page
        @params : N/A
        Return :   Render List page 
    ************************* */

 public function getPizzaAmount() {
        return $this->renderView("pizza.amount.list");
    }


        /* *************************
        Name :  Pizza Amount Ajax
        Description :Pizza amount allow to access some Pizza amount List of data
        @params : Yes
        @params : Yes
        Return :  responce
    ************************* */

    public function pizzaAmountAjax(Request $request) {

        $order = $request->get('order');
       
        $start = $request->get('start');

        $limit = $request->get('length');

        $list =  \App\Model\Pizza\PizzaAmount::with(['pizza_name','pizza_size']);
        $totalData = $list->count();

        $totalFiltered = $list->count();
        $list = $list->skip($start)->take($limit);
        $list = $list->orderBy('id', 'ASC')->get();

        $data = array();
        foreach ($list as $row) {

       /* if(isset($row->pizza_name)){
            $pizza_name = $row->pizza_name->name;
        }else{
            $pizza_name = " ";
        }*/

            if ($row->status == 1) {
                $status = '<center><i id="status_' . $row->id . '" class="fa fa-check btn-xs btn-success" style="cursor:pointer;" onclick ="ChangeStatus(' . $row->id . ')"></i></center>';
            } else {
                $status = '<center><i id="status_' . $row->id . '" class="fa fa-close btn-xs btn-danger" style="cursor:pointer;" onclick ="ChangeStatus(' . $row->id . ')"></i></center>';
            }
            $action = '<a href="' . \App\Facades\Tools::createdAdminEndUrl('pizza/amount/form/' . $row->id) . '" class = "btn-xs btn-info" >Edit</a>';

            $data[] = array(

                $row->id,
                 $row->pizza_name['name'],
                $row->pizza_size->name,
                $row->amount,
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
        Name :  Pizza Amount 
        Description :Pizza amount allow to change Pizza amount Status
        @params : Yes
        Return : status
    ************************* */

    public function changeStatusPizzaAmount ($id) {
        $object = \App\Model\Pizza\PizzaAmount::find($id);
        return \App\Facades\Tools::changeStatus($object);
    }

 /* *************************
        Name :  Pizza Amount Form
        Description :Pizza Amount Form allow to Create & Update Form
        @params : Yes
        Return :  Render form page To Following data
    ************************* */ 
    public function pizzaAmountForm($id = 0) {
        $this->setPageTitle('Add/Edit  Pizza Amount');

        $model = \App\Model\Pizza\PizzaAmount::find($id);
        
        if ($id > 0) {
            if (!$model) {
                session()->flash('page_action_flash_error', __('Either record id is missing or requested record does not exist.'));
                request()->flash();
                return redirect(url()->previous());
            }
        } else {

            $model = new \App\Model\Pizza\PizzaAmount();
        }

        $request = request();
  
        if ($request->isMethod('POST')) {

            $errors = array();

            $data = $request->post();
           //dd($data);
            $rules = [
                'pizza_category_id' => 'required',
                'pizza_type_id' => 'required',
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
                            session()->put('msg_success', 'Pizza Amount has been updated successfully');
                            $request->flash();
                            
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('pizza/amount/form/'.$model->id));
                            exit;
                        } else {
                            session()->put('msg_success', 'New Pizza Amount has been added successfully');
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('pizza/amount/form'));
                            exit;
                        }
                    } else {
                        session()->put('msg_error', 'New Pizza Amount has been added successfully');
                    }
                } catch (Exception $e) {
                    session()->put('msg_error', 'New Pizza Amount  has been added successfully');
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
//        dd($model->image_url);
        return $this->renderView('pizza.amount.form');
    }


}
