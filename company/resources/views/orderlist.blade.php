@extends('layouts.header')
@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            @if(Session::has('success'))
                <p style="z-index: 1;" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }} <i class="fas fa-check-circle"></i></p>
            @endif
            <div class="row">
                <button style="margin-bottom:15px;" class="btn btn-danger btn-xs delete-all" id="btnPrintorder">Delete Selected</button>&nbsp;
            </div>   
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th></th>
                                <th>S.No</th>
                                <th>Order Id</th>
                                <th>User Name </th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                            ?>
                            @foreach($users1 as $row)
                            <tr>
                                <td><input type="checkbox" class="chkAccId" value="{{$row->id}}"></td>
                                <td><?php echo $i++;?></td>
                                <td>{{$row->order_id}}</td>
                                <td>{{$row->u_name}}</td>
                                <td>{{$row->mobile}}</td>
                                <td>{{$row->address}}</td>
                                <td>{{$row->p_name}}</td>
                                <td>{{$row->qty}}</td>
                                <td>{{$row->total_amount}}</td>
                                <td><?php if($row->c_name==''){echo 'N/A';}else{echo $row->c_name;} ?></td>
                                <td><?php if($row->s_name==''){echo 'N/A';}else{echo $row->s_name;} ?></td>
                                <td>{{$row->date}}</td>
                                <td>
                                    <?php //if($row->status==1){echo 'Processing';}elseif($row->status==2){echo 'Delivered';}elseif($row->status==3){echo 'Return';}elseif($row->status==4){echo 'Cancelled';}else{echo 'On the way';} ?>
                                    <select class="select2" value="" name="Status" autocomplete="off" onchange="ChangeStatus(this.value);">
                                        <option value="{{$row->id}}/1" {{ ($row->status == '1' ? "selected":"") }}>Processing</option>
                                        <option value="{{$row->id}}/2" {{ ($row->status == '2' ? "selected":"") }}>Delivered</option>
                                        <option value="{{$row->id}}/3" {{ ($row->status == '3' ? "selected":"") }}>Return</option>
                                        <option value="{{$row->id}}/4" {{ ($row->status == '4' ? "selected":"") }}>Cancelled</option>
                                        <option value="{{$row->id}}/5" {{ ($row->status == '5' ? "selected":"") }}>On the way</option>
                                    </select>
                                </td>
                                <td>
                                    <div style="display: flex;">
                                        <a href="{{url('delete-order/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Delete"><button class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i> </button></a>&nbsp;
                                    </div>
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> 
            </div> 
        </div> 
    </div> 
</div>
@endsection('content')
@section('script')

<script>
function ChangeStatus(ids){
        var arr = ids.split('/');

        var id = parseInt(arr[0]);
        var status = parseInt(arr[1]);
    $.confirm({
    title: 'Alert!',
    content: 'are you sure to change status',
    type: 'red',
    typeAnimated: true,
    buttons: {
        confirm: function () {
           $.getJSON('{{url("updateorderstatus")}}', {id:id,status: status}, function (data) {
            location.reload();
        });
        },
        cancel: function () {
            $.alert('Canceled!');
        },
    }
});
}
</script>
@endsection