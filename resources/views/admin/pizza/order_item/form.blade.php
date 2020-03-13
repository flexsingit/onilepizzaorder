@extends('admin.common.layout')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @if(isset($model->id)) 
        {{'Edit Order Item'}}
        @else
        {{'Add Order Item'}}
        @endif

    </h1>
    <ol class="breadcrumb">
        <li>

            <a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a>
        </li>

        <li class="active">

           @if(isset($model->id)) 
        {{'Edit Order Item'}}
        @else
        {{'Add Order Item'}}
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
                            <label class="col-sm-2 control-label">Pizza Order Id</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Pizza Order Id" name="pizza_order_id" value="{{old('pizza_order_id',$model->pizza_order_id)}}" >
                                @if ($errors && $errors->first('pizza_order_id'))
                                <span class="input-error" style="color:red">{{$errors->first('pizza_order_id')}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Pizza Detail Id</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Pizza Amount Id" name="pizza_amount_id" value="{{old('pizza_amount_id',$model->pizza_amount_id)}}" >
                                @if ($errors && $errors->first('quantity'))
                                <span class="input-error" style="color:red">{{$errors->first('quantity')}}</span>
                                @endif
                            </div>
                        </div>


                         <div class="form-group">
                            <label class="col-sm-2 control-label">Quantity</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Amount" name="quantity" value="{{old('quantity',$model->quantity)}}" >
                                @if ($errors && $errors->first('quantity'))
                                <span class="input-error" style="color:red">{{$errors->first('quantity')}}</span>
                                @endif
                            </div>
                        </div>

                          <div class="form-group">
                            <label class="col-sm-2 control-label">Amount</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Amount" name="amount" value="{{old('amount',$model->amount)}}" >
                                @if ($errors && $errors->first('amount'))
                                <span class="input-error" style="color:red">{{$errors->first('amount')}}</span>
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
                        <a href="{{\App\Facades\Tools::createdAdminEndUrl('pizza/order/item/list')}}" class="btn btn-default pull-right" style="margin-left: 20px ">Cancel</a>
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
                pizza_order_id: {required: !0},
                pizza_amount_id: {required: !0},
                amount: {required: !0},
                quantity: {required: !0},
                status: {required: !0},
               
            }

        });
      
    });
   
</script>

@stop