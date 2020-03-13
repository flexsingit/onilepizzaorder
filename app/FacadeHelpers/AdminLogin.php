<?php

namespace App\FacadeHelpers;

class AdminLogin {

    public function getSessionObj() {
        return session();
    }

    public function isLoggedIn() {
        if (!$isLogged = $this->isRememberSessionExists()) {
            $isLogged = $this->getSessionObj()->has($this->getAdminSessionName());
        }
        return $isLogged;
    }

    public function doLogin($credentials) {
        $model = $this->getAdminModel();

        $admin = $model->where('email', $credentials['email'])->first();

        if (!$admin) {
//            dd('hello');
            $this->getSessionObj()->flash('login_error', __('Login Error: Your account does not exists'));
            return false;
        } else {
//            if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $admin->password)) {
//                $this->getSessionObj()->flash('login_error', __('Login Error: Invalid Login'));
//                return false;
//            } else {

                if (!\App\Facades\Tools::isActive($admin->status)) {
                    $this->getSessionObj()->flash('login_error', __('Login Error: Your Account is not Active'));
                    return false;
                }

                $this->setAdminSession($admin);

                if (isset($credentials['remember_me'])) {
                    $this->rememberAdminSession($admin);
                }

                try {
                    if (\Illuminate\Support\Facades\Hash::needsRehash($admin->password)) {
                        $admin->password = \Illuminate\Support\Facades\Hash::make($admin->password);
                    }
                    $admin->last_login = date('Y-m-d H:i:s', time());
                    @$admin->save();
                } catch (Exception $e) {
                    
                }
                return true;
//            }
        }
    }

    public function doLogout() {
        if ($this->getSessionObj()->has($this->getAdminSessionName())) {
            $this->getSessionObj()->forget($this->getAdminSessionName());
        }

        if (\Illuminate\Support\Facades\Cookie::has('pizza_order_admin')) {
            \Illuminate\Support\Facades\Cookie::forgot('pizza_order_admin');
        }

        $this->getSessionObj()->flush();

        return true;
    }

    public function setAdminSession($admin) {
        $this->getSessionObj()->put($this->getAdminSessionName(), $admin);
    }

    public function getAdminSession() {
        return $this->getSessionObj()->get($this->getAdminSessionName());
    }

    public function getAdminSessionName() {
        return base64_encode('pizza_order_admin');
    }

    public function rememberAdminSession($admin) {
        $token_combination = json_encode(array('email' => $admin->email, 'password' => $admin->password));
        $token = \Illuminate\Support\Facades\Hash::make($token_combination);
        $admin->remember_token = $token;
        if ($admin->save()) {
            \Illuminate\Support\Facades\Cookie::forever('pizza_order_admin', $token);
        }
    }

    public function isRememberSessionExists() {
        $token = $this->getRememberedToken();
        if (empty($token)) {
            return false;
        }
        $model = $this->getAdminModel();
        $admin = $model->where('remember_token', $token)->first();
        if (!$admin) {
            return false;
        }

        return $this->doLogin(array('email' => $admin->email, 'password' => $admin->password, 'remember_me' => 1));
    }

    public function getRememberedToken() {
        return \Illuminate\Support\Facades\Cookie::get($this->getAdminSessionName());
    }

    public function getAdminModel() {
        return \App\Model\Admin\Admin::select(array('*'));
    }

    public function getLogoutUrl() {
        return url('admin/logout');
    }

    public function getLoggedAdminName() {
        $admin = \App\Facades\AdminLogin::getAdminSession();
        return $admin->first_name;
    }

    public function getLoggedInAdminId() {
        $admin = \App\Facades\AdminLogin::getAdminSession();
        return $admin->id;
    }

    public function setAdminModeSession($type) {
        $this->getSessionObj()->put($this->getModeTypeSessionName(), $type);
    }

    public function getModeTypeSessionName() {
        return base64_encode('pizza_order');
    }

}
