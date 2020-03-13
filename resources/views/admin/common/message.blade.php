    @if(session()->get("msg_success") != "") 
    <div class="alert alert-success fade in alert-dismissable"><a style="text-decoration:none;" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>{{ session()->get("msg_success")}} </div>
    {{session()->put("msg_success","")}}
    @elseif(session()->get("msg_error") != "") 
    <div class="alert alert-error fade in alert-dismissable"><a style="text-decoration:none;" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>{{session()->get("msg_error")}} </div>
    {{ session()->put("msg_error","")}}
    @elseif(session()->has("login_error") != "") 
    <div class="alert alert-error fade in alert-dismissable"><a style="text-decoration:none;" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>{{session()->get("login_error")}} </div>
    {{ session()->put("login_error","")}}
    @endif 
    
        