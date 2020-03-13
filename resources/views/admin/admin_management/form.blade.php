@extends('admin.common.layout')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @if(isset($model->first_name)) 
        {{'Edit Admin - ' . $model['first_name']." ".$model['last_name']}}<button type="button" class="btn btn-info center-block"  data-toggle="modal" data-target="#change_password">
            Change Password
        </button>
        @else
        {{'Add Admin'}}
        @endif

    </h1>
    <ol class="breadcrumb">
        <li>

            <a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a>
        </li>

        <li class="active">

            @if (isset($model->first_name)) 
            {{'Edit Admin - ' . $model['first_name']." ".$model['last_name']}}
            @else 
            {{'Add Admin'}}
            @endif

        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            @include('admin.common.message')
            <!-- general form elements disabled -->
            <div class="box box-warning">

                <!-- form start -->
                <form class="form-horizontal" id="form"  method="post" enctype="multipart/form-data" name="submit"> 
                    <div class="box-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">First Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{old('first_name',$model->first_name)}}" >

                                @if ($errors && $errors->first('first_name'))
                                <span class="input-error" style="color:red">{{$errors->first('first_name')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{old('last_name',$model->last_name)}}" >
                                @if ($errors && $errors->first('last_name'))
                                <span class="input-error" style="color:red">{{$errors->first('last_name')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group " >
                            <label class="col-sm-2 control-label">Image</label>
                            <div class="col-sm-10">
                                <img id="image_placeholder" src="{{$model->image_url}}" class="logo-view-placeholder" style="width:150px;height: 150px" />

                                <input type="file"  placeholder="Image" id="image" name="image" value="">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Email" name="email" value="{{old('email',$model->email)}}">
                                @if ($errors && $errors->first('email'))
                                <span class="input-error" style="color:red">{{$errors->first('email')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Contact Number 1</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Mobile Number" name="contact_number_1"  value="{{old('contact_number_1', $model->contact_number_1)}}">
                                @if ($errors && $errors->first('contact_number_1'))
                                <span class="input-error" style="color:red">{{$errors->first('contact_number_1')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Contact Number 2</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Mobile Number" name="contact_number_2"  value="{{old('contact_number_2', $model->contact_number_2)}}">
                                @if ($errors && $errors->first('contact_number_2'))
                                <span class="input-error" style="color:red">{{$errors->first('contact_number_2')}}</span>
                                @endif
                            </div>
                        </div>
                        @if(empty($model))
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type=password class="form-control" placeholder="Enter Password" name="password"  value="{{old('password', $model->password)}}">
                                @if ($errors && $errors->first('password'))
                                <span class="input-error" style="color:red">{{$errors->first('password')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Confirm Password</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Confirm Password" name="confirm_password"  value="{{old('confirm_password', $model->confirm_password)}}">
                                @if ($errors && $errors->first('confirm_password'))
                                <span class="input-error" style="color:red">{{$errors->first('confirm_password')}}</span>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Gender</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="gender">            
                                    <option value="" >Select Gender</option>
                                    @foreach (\App\Facades\Tools::getGenders() as $key => $label)
                                    <option value="{{$key}}" @if(old('gender', $model->gender) == $key) selected="selected" @endif >{{__($label)}}</option>
                                    @endforeach
                                </select>
                                @if ($errors && $errors->first('gender'))
                                <span class="input-error" style="color:red">{{$errors->first('gender')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="status">                                      
                                    @foreach (\App\Facades\Tools::getStatusesText() as $key => $label)
                                    <option value="{{$key}}" @if(old('status', $model->status) == $key && $model->status !='') selected="selected" @endif >{{__($label)}}</option>
                                    @endforeach
                                </select>
                                @if ($errors && $errors->first('status'))
                                <span class="input-error" style="color:red">{{$errors->first('status')}}</span>
                                @endif
                            </div>
                        </div>


                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{\App\Facades\Tools::createdAdminEndUrl('admin_managment/list')}}" class="btn btn-default pull-right" style="margin-left: 20px ">Cancel</a>
                        <button type="submit" class="btn btn-info pull-right"  value="submit">Submit</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="modal fade" id="change_password">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="" id="change_password_form">
                        <div class="box-body">
                            <input type="hidden" name="user_id" value="{{$model->id}}" />
                                
                            <div class="form-group">
                                <label for="current_password" class="col-sm-2 control-label">Current Password</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="col-sm-2 control-label">New Password</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="col-sm-2 control-label">Confirm Password</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>

                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</section>

@stop
@section('page_specific_js')
<!--Custom Script For Validation -->
<script>

    $().ready(function () {

        // validate signup form on keyup and submit
        $("#form").validate({
            rules: {
                first_name: {required: !0},
                email: {required: !0, email: true},
                contact_number_1: {required: !0, minlength: 10, maxlength: 10},
                status: {required: !0},
                gender: {required: !0},
            }

        });
        $("#change_password_form").validate({
            rules: {
                current_password: {required: !0},
                new_password: {required: !0,minlength: 5},
                confirm_password: {required: !0,equalTo: "#new_password"},
                
            }

        });
    });
    $(document).ready(function () {
        $("#image").change(function () {
            preview_image(this);
        });
    });

    function preview_image(input)
    {
        var element_id = $(input).attr('id');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + element_id + '_placeholder').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@stop