<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class DashboardController extends AdminController {

    public function index() {
        $this->setPageTitle('Pizza Order Dashboard');
        return $this->renderView('dashboard.home');
    }

}
