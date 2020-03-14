@extends('admin.common.layout')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @if(isset($model->id)) 
        {{'Edit Pizza Category'}}
        @else
        {{'Add Pizza Category'}}
        @endif

    </h1>
    <ol class="breadcrumb">
        <li>

            <a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a>
        </li>

        <li class="active">

           @if(isset($model->id)) 
        {{'Edit Pizza Category'}}
        @else
        {{'Add Pizza Category'}}
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
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Name" name="name" value="{{old('name',$model->name)}}" >

                                @if ($errors && $errors->first('name'))
                                <span class="input-error" style="color:red">{{$errors->first('name')}}</span>
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
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" placeholder="Description" name="description" value="{{old('description',$model->description)}}">{{old('description',$model->description)}}</textarea>
                                @if ($errors && $errors->first('description'))
                                <span class="input-error" style="color:red">{{$errors->first('description')}}</span>
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
                        <a href="{{\App\Facades\Tools::createdAdminEndUrl('pizza/category/list')}}" class="btn btn-default pull-right" style="margin-left: 20px ">Cancel</a>
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
                name: {required: !0},
                amount: {required: !0},
                status: {required: !0},
               
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