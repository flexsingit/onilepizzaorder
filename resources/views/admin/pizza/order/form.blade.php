@extends('admin.common.layout')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @if(isset($model->id)) 
        {{'Edit Pizza Order'}}
        @else
        {{'Add Pizza Order'}}
        @endif

    </h1>
    <ol class="breadcrumb">
        <li>

            <a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a>
        </li>

        <li class="active">

           @if(isset($model->id)) 
        {{'Edit Pizza Order'}}
        @else
        {{'Add Pizza Order'}}
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

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Contact Number</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="First Name" name="contact_number" value="{{old('contact_number',$model->contact_number)}}" >

                                @if ($errors && $errors->first('contact_number'))
                                <span class="input-error" style="color:red">{{$errors->first('contact_number')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" placeholder="Address" name="address" value="{{old('address',$model->address)}}">{{old('address',$model->address)}}</textarea>

                                @if ($errors && $errors->first('address'))
                                <span class="input-error" style="color:red">{{$errors->first('address')}}</span>
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
                        <a href="{{\App\Facades\Tools::createdAdminEndUrl('pizza/order/list')}}" class="btn btn-default pull-right" style="margin-left: 20px ">Cancel</a>
                        <button type="submit" class="btn btn-info pull-right"  value="submit">Submit</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
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
                  last_name: {required: !0},
                    contact_number: {required: !0},
                      address: {required: !0},
                        status: {required: !0},
               
            }

        });
      
    });
  
</script>

@stop