@extends('admin.common.layout')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Order Item</h1>

    <ol class="breadcrumb">
        <li><a href="{{\App\Facades\Tools::createdAdminEndUrl('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Order Item</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">  

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="box-title">Order Item</h2>
                    <a href="{{\App\Facades\Tools::createdAdminEndUrl('pizza/order/item/form')}}" class="btn btn-info pull-right" style="margin-bottom: 20px">{{__('Add New Item')}}</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatable_full" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> Id </th>
                                <th>User Name </th>
                                <th>Pizza Name </th>
                                <th>Pizza Size </th>
                                <th>Quantity</th>
                                 <th>Amount</th>
                                <th style="text-align:center;"> Status </th>
                                <th> Created At </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody id="datatable-list-body">
                            <tr class="empty_row"><td colspan="9" class="text-center"><span class="text-danger"><b>No Record Found</b></span></td></tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>

@stop

@section('page_specific_js')
<script type="text/javascript">
    var list_table_id = 'datatable_full';

    generateDatatable({

        table_id: list_table_id,
        url: "{{\App\Facades\Tools::createdAdminEndUrl('pizza/order/item/list/ajax')}}",
        number_of_columns: 9,
        searching: true,
        columnDefs: [
            {name: 'id', targets: 0},
            {name: 'pizza_order_id', targets: 1},
            {name: 'pizza_category_id', targets: 2},
            {name: 'pizza_type_id', targets: 3},
            {name: 'quantity', targets: 4},
            {name: 'amount', targets: 5},
            {name: 'status', targets: 6},
            {name: 'created_at', targets: 7},
            {name: 'action', targets: 8}
        ],
        order: [[0, "DESC"]]
    });
    
    $("#hideShow").click(function () {
        $("#onclick").toggle("slow");
    });
    function dtRowCreatedCallback()
    {

    }
    function ChangeStatus(id) {
        $.ajax({
            type: 'GET',
            url: '{{\App\Facades\Tools::createdAdminEndUrl("pizza/order/item/change/status")}}' + '/' + id,
            dataType: 'json',
            success: function (json) {
                if (json.status == false) {
                    alert('Error while change status for selected Category');
                } else {

                    if (json.data == 1) {
                        $("#status_" + id).removeClass('fa fa-close btn-xs btn-danger').addClass('fa fa-check btn-xs btn-success');
                    } else {
                        $("#status_" + id).removeClass('fa fa-check btn-xs btn-success').addClass('fa fa-close btn-xs btn-danger');
                    }
                }
            }
        });
    }

</script>
@stop