<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $page_title = 'Pizza Order';
        
    protected $page_vars = array();
    
    protected function setPageTitle($title)
    {
        if (!empty($title)) {
            if (strpos($title, 'Pizza Order') === false) {
                $this->page_title = $this->page_title . ' - '.$title;
            } else {
                $this->page_title = $title;
            }
        }
    }
    
    protected function getPageTitle()
    {
        return $this->page_title;
    }
    
    protected function renderView($view_name = 'page_not_found', $end)
    {
        return view($end.'.'.$view_name, $this->page_vars);
    }
}
