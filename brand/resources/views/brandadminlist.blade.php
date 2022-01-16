@extends('layouts.header')
@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            @if(Session::has('success'))
                <p style="z-index: 1;" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }} <i class="fas fa-check-circle"></i></p>
            @endif
            <a href="{{route('add-brand-admin')}}"><button class="btn btn-primary">Add Brand Admin</button></a><br><br>
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Comapny Id</th>
                                <th>City & Brand Admin Id </th>
                                <th>State</th>
                                <th>City</th>
                                <th>Pincode Managed</th>
                                <th>Name </th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Position</th>
                                <th>Age</th>
                                <th>Gender</th>
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
                                <td><?php echo $i++;?></td>
                                <td>{{$row->company_id}}</td>
                                <td>{{$row->brand_admin_id}}</td>
                                <td>{{$row->state}}</td>
                                <td>{{$row->city}}</td>
                                <td>{{$row->pincodes_managed}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->phone}}</td>
                                <td>{{$row->position}}</td>
                                <td>{{$row->age}}</td>
                                <td>{{$row->gender}}</td>
                                <td>
                                    <?php
                                        if($row->status ==1){?>
                                            <center><button class="btn btn-success sts-btn btn-sm">Active &nbsp; <i class="fa fa-check" aria-hidden="true" style="font-size: 9px;"></i></button></center>
                                        <?php
                                        }else{?>
                                            <center><button class="btn btn-danger sts-btn btn-sm">In-Active &nbsp; <i class="fa fa-times" aria-hidden="true" style="font-size: 9px;"></i></button></center>
                                        <?php
                                        }
                                    ?>
                                </td>
                                <td>
                                    <div style="display: flex;">
                                        <?php
                                            if($row->status ==1){ ?>
                                            <a href="{{url('changebadminstatus2/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Make Inactive"><button class="btn btn-success btn-sm"><i class="fa fa-times" aria-hidden="true"></i></button></a>&nbsp;
                                        <?php }else{ ?>
                                            <a href="{{url('changebadminstatus1/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Make Active"><button class="btn btn-success btn-sm"><i class="fa fa-check" aria-hidden="true"></i></button></a>&nbsp;
                                        <?php } ?>
                                        <a href="{{url('edit-brand-admin/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><button class="btn btn-primary btn-sm" id="delete"><i class="fas fa-edit"></i> </button></a>&nbsp;
                                        <a href="{{url('delete-brand-admin/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Delete"><button class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i> </button></a>&nbsp;
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

@endsection