<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    private $list_filter = array();
    
    
    public function welcome()
    {
        return $this->renderView('welcome');
    }
    
    protected function setListFilter($filter)
    {
        $this->list_filter = $filter;
    }
    
    protected function renderView($view_name = 'page_not_found', $end = 'admin')
    {
        $this->page_vars['page_title'] = $this->getPageTitle();
        
        $show_filters = false;
        if (count($this->list_filter) > 0) {
            foreach($this->list_filter as $fl) {
                if ($fl['type'] != 'hidden') {
                    $show_filters = true;
                    break;
                }
            }
        }
        $this->page_vars['list_filters'] = $this->list_filter;
        $this->page_vars['show_filters'] = $show_filters;
        
        return parent::renderView($view_name, $end);
    }

    
    public function toggleErrorState(Request $request, $id)
    {
        $model = \App\Model\Error\SystemBug::find($id);
        
        if (!$model) {
            session()->flash('page_action_flash_error', __('Either record id is missing or requested record does not exist.'));
            request()->flash();
            return redirect(url()->previous());    
        }
        
        if($model->issue_status == \App\Model\Error\SystemBug::ISSUE_STATE_OPEN) {
            $model->issue_status = \App\Model\Error\SystemBug::ISSUE_STATE_CLOSE;
        } else {
            $model->issue_status = \App\Model\Error\SystemBug::ISSUE_STATE_OPEN;
        }
        @$model->save();
        session()->flash('page_action_flash_success', 'State updated successfully');
        return redirect(url()->previous());
    }
    
}
