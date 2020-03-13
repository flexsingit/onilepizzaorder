<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class AdminManagementController extends AdminController {

    public function index() {

        $filters = array(
            array('name' => 'name', 'label' => 'Name', 'type' => 'text'),
            array('name' => 'id', 'label' => 'Id', 'type' => 'text'),
            array('name' => 'email', 'label' => 'Email', 'type' => 'text'),
            array('name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => \App\Facades\Tools::getStatusesText()),
        );
        $this->setListFilter($filters);

        return $this->renderView("admin_management.list");
    }

    public function listAjax(Request $request) {

        $search_text = $request->get('search')['value'];
        $dt_columns = $request->get('columns');
        //dd($dt_columns);
        $order = $request->get('order');
        $custom_filter = $request->get('custom_filter');
        $start = $request->get('start');
//        dd($custom_filter);
        $limit = $request->get('length');

        $list = new \App\Model\Admin\Admin();
        $totalData = $list->count();
        //dd($totalData);

        if (isset($custom_filter['name'])) {
            $list = $list->where(function($q) use($custom_filter) {
                $q->where('first_name', 'LIKE', '%' . $custom_filter['name'] . '%');
                $q->orWhere('last_name', 'LIKE', '%' . $custom_filter['name'] . '%');
            });
        }
        if (isset($custom_filter['id'])) {
            $list = $list->where('id', $custom_filter['id']);
        }
        if (isset($custom_filter['email'])) {
            $list = $list->where('email', $custom_filter['email']);
        }

        if (isset($custom_filter['status'])) {
            $list = $list->where('status', $custom_filter['status']);
        }

        if (!empty($search_text)) {
            $list = $list->where('name', 'LIKE', '%' . $search_text . '%');
        }
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

    public function changeStatus ($id) {
        $object = \App\Model\Admin\Admin::find($id);
        return \App\Facades\Tools::changeStatus($object);
    }

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

    public function changePassword($id) {

        $this->setPageTitle('Add/Edit  Admin');

        $model = \App\Model\Admin\Admin::find($id);
        // dd($this->page_vars['category']);
        if ($id > 0) {
            if (!$model) {
                session()->flash('page_action_flash_error', __('Either record id is missing or requested record does not exist.'));
                request()->flash();
                return redirect(url()->previous());
            }
        }

        $request = request();
        if ($request->isMethod('POST')) {
            $errors = array();
            $data = $request->post();
            //dd($data);
            $rules = [
                'old_password' => 'required',
                'new_password' => 'required|min:5',
                'confirm_password' => 'required|same:new_password',
            ];


            $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);


            if (!$validator->fails()) {
                try {
                    unset($data['_token']);
                    if (!\Illuminate\Support\Facades\Hash::check($data['password'], $model->password)) {
                        session()->put('msg_error', 'Your old password not match in database pls try again valid password');
                    } else {
                        $model->password = \Illuminate\Support\Facades\Hash::make($data['password']);
                        if ($model->update()) {
                            session()->put('msg_success', 'Admin Details has been updated successfully');
                        } else {
                            session()->put('msg_error', 'New Admin has been added successfully');
                        }
                    }
                    return redirect(\App\Facades\Tools::createdAdminEndUrl('admin_managment/change/password'));
                } catch (Exception $e) {
                    session()->put('msg_error', 'Something went wrong update your password pls try after sometime');
                    return redirect(\App\Facades\Tools::createdAdminEndUrl('admin_managment/change/password'));
                }
            } else {
                $this->page_vars['errors'] = $validator->errors();
            }
            $request->flash();
        }
        $this->page_vars['model'] = $model;
        return $this->renderView('admin_management.change_password');
    }

}
