<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class LoginController extends AdminController {

    public function login() {
        $this->setPageTitle('Login');
        $request = request();
        if ($request->method() == 'POST') {
            $params = $request->all();

            $rules = [
                'email' => 'required|email',
                'password' => 'required|min:6'
            ];

            $validator = \Illuminate\Support\Facades\Validator::make($params, $rules);

            if ($validator->fails()) {
                $this->page_vars['errors'] = $validator->errors();
            } else {
                if (\App\Facades\AdminLogin::doLogin($params)) {
                    return redirect('admin/dashboard');
                } else {
                    return redirect('admin/login')->withInput();
                }
            }
        }


        return $this->renderView('login.form');
    }

    public function logout() {
        \App\Facades\AdminLogin::doLogout();
        return redirect('admin/login');
    }

}
