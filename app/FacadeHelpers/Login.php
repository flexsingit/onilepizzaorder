<?php

namespace App\FacadeHelpers;

class Login
{
    public function getSessionObj() { return session(); }
    
    public function isLoggedIn()
    {
        if (!$isLogged = $this->isRememberSessionExists()) {
            $isLogged = $this->getSessionObj()->has($this->getUserSessionName());
        }
        return $isLogged;
    }
    
    public function makeLoginSession($user, $remember_me)
    {
        $this->setUserSession($user);
                
        if ($remember_me) {
            $this->rememberUserSession($user);
        }

        try {
            if (\Illuminate\Support\Facades\Hash::needsRehash($user->password)) {
                $user->password = \Illuminate\Support\Facades\Hash::make($user->password);
            }
            $user->last_login = date('Y-m-d H:i:s', time());
            @$user->save();
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    
    public function doLogout()
    {
        if ($this->getSessionObj()->has($this->getUserSessionName())) {
            $this->getSessionObj()->forget($this->getUserSessionName());
        }
        
        if (\Illuminate\Support\Facades\Cookie::has('pizza_order')) {
            \Illuminate\Support\Facades\Cookie::forgot('pizza_order');
        }
        
        $this->getSessionObj()->flush();
        
        return true;
    }
    
    public function setUserSession($user)
    {
        $this->getSessionObj()->put($this->getUserSessionName(), $user);
    }
    
    public function getUserSession()
    {
        return $this->getSessionObj()->get($this->getUserSessionName());
    }
    
    public function getUserSessionName()
    {
        return base64_encode('pizza_order');
    }
    
    public function getUserCookieName()
    {
        return 'pizza_order';
    }
    
    public function rememberUserSession($user)
    {
        $token_combination = json_encode(array('email' => $user->email, 'password' => $user->password));
        $token = \Illuminate\Support\Facades\Hash::make($token_combination);
        $user->remember_token = $token;
        if ($user->save()) {
            \Illuminate\Support\Facades\Cookie::forever($this->getUserCookieName(), $token);
        }
    }
    
    public function isRememberSessionExists()
    {
        $token = $this->getRememberedToken();

        if (empty($token)) {
            return false;
        }
        $user = \App\Model\User\User::select(array('*'))->with('meta_description');
        
        $user = $user->where('remember_token', $token)->first();
        if (!$user) {
            $user = \App\Model\B2b\Sponsor::select(array('*'));
            $user = $user->where('remember_token', $token)->first();
            if (!$user) {
                return false;
            }
        }
        
        
        return $this->makeLoginSession($user, true);
    }
    
    public function getRememberedToken()
    {
        return \Illuminate\Support\Facades\Cookie::get($this->getUserCookieName());
    }
    
    public function getUserModel()
    {
        return \App\Model\User\User::select(array('*'))->with('meta_description');
    }
    
    public function getLogoutUrl()
    {
        return url('logout');
    }
    
    public function getLoggedUserName()
    {
        $user = \App\Facades\Login::getUserSession();
        return $user->firstname;
    }
    
    public function getLoggedUserFullName()
    {
        $user = \App\Facades\Login::getUserSession();
        return $user->full_name;
    }
    
    public function getLoggedInUserId()
    {
        $user = \App\Facades\Login::getUserSession();
        return $user->id;
    }
    
    public function getLoggedInUserGender()
    {
        if(!Self::isLoggedIn())
        {
            return \App\Facades\Tools::getMaleGenderId();
        }
        $user = \App\Facades\Login::getUserSession();
        return $user->gender;
    }
}