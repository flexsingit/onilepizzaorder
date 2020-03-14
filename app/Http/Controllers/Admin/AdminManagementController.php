<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class AdminManagementController extends AdminController {


        /* *************************
        Name :  index 
        Description :index allow to render View Page
        Author : Gyanendra Singh
        @params : N/A
        Return :   Render List page 
    ************************* */

    public function index() {
        
        return $this->renderView("admin_management.list");
    }


        /* *************************
        Name :  List Ajax
        Description : List allow to access some List of data
        @params : Yes
        @params : Yes
        Return :  responce
    ************************* */

    public function listAjax(Request $request) {

        $order = $request->get('order');
       
        $start = $request->get('start');

        $limit = $request->get('length');

        $list = new \App\Model\Admin\Admin();
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
            $action = '<a href="' . \App\Facades\Tools::createdAdminEndUrl('admin_managment/form/' . $row->id) . '" class = "btn-xs btn-info" >Edit</a>';

            $data[] = array(
                $row->id,
                $row->first_name,
                $row->last_name,
                $row->email,
                '<img src="' . $row->image_url . '" style ="height:100px;width:100px;">',
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
        Name :  Change Status 
        Description : Change Status  allow to change  Status
        @params : Yes
        Return : status
    ************************* */

    public function changeStatus ($id) {
        $object = \App\Model\Admin\Admin::find($id);
        return \App\Facades\Tools::changeStatus($object);
    }

    /* *************************
        Name :  Form
        Description :  Form allow to Create & Update Form
        @params : Yes
        Return :  Render form page To Following data
    ************************* */

    public function form($id = 0) {
        $this->setPageTitle('Add/Edit  Admin');

        $model = \App\Model\Admin\Admin::find($id);
        
        if ($id > 0) {
            if (!$model) {
                session()->flash('page_action_flash_error', __('Either record id is missing or requested record does not exist.'));
                request()->flash();
                return redirect(url()->previous());
            }
        } else {
            $model = new \App\Model\Admin\Admin();
        }

        $request = request();
        if ($request->isMethod('POST')) {
            $errors = array();
            $data = $request->post();
            //dd($data);
            $rules = [
                'first_name' => 'required',
                'email' => 'required|email|unique:admins,id,' . $model->id,
                'contact_number_1' => 'required|min:10|max:10|unique:admins,id,' . $model->id,
                'status' => 'required',
                'gender' => 'required',
            ];

            if ($id == 0) {
                $rules['password'] = 'required|min:5';
                $rules['confirm_password'] = 'required|same:password';
            }


            $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);


            if (!$validator->fails()) {
                try {
                    unset($data['_token']);
                    if ($id == 0) {
                        unset($data['confirm_password']);
                        $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
                    }
                    
                    if (($id > 0 && $model->update($data)) || (!$id && $model = $model->create($data))) {
                        if ($request->file('image')) {
                            $model->uploadImage();
                        }
                        
                        
                        if ($id) {
                            session()->put('msg_success', 'Admin Details has been updated successfully');
                            $request->flash();
                            
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('admin_managment/form/'.$model->id));
                            exit;
                        } else {
                            session()->put('msg_success', 'New Admin has been added successfully');
                            return redirect(\App\Facades\Tools::createdAdminEndUrl('admin_managment/form'.$model->id));
                            exit;
                        }
                    } else {
                        session()->put('msg_error', 'New Admin has been added successfully');
                    }
                } catch (Exception $e) {
                    session()->put('msg_error', 'New Admin  has been added successfully');
                }
            } else {
                $this->page_vars['errors'] = $validator->errors();
            }
            $request->flash();
        }
        $this->page_vars['model'] = $model;
//        dd($model->image_url);
        return $this->renderView('admin_management.form');
    }

  
}
