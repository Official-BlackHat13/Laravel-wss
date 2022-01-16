<?php $gst = str_replace('/public','',url('/uploads/')); ?>
@extends('layouts.header')
@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            @if(Session::has('success'))
                <p style="z-index: 1;" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }} <i class="fas fa-check-circle"></i></p>
            @endif
            <div class="row">
                <a href="{{route('add-super-category')}}"><button class="btn btn-primary">Add Super Category</button></a>&nbsp;
                <button style="margin-bottom:15px;" class="btn btn-danger btn-xs delete-all" id="btnPrintsupercat">Delete Selected</button>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>S.No</th>
                                <th>Name</th>
                                <!--<th>Icon</th>-->
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
                                <td>{{$row->name}}</td>
                                <td>
                                    <?php
                                        if($row->status ==1){ ?>
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
                                            <a href="{{url('changescatstatus2/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Make Inactive"><button class="btn btn-success btn-sm"><i class="fa fa-times" aria-hidden="true"></i></button></a>&nbsp;
                                        <?php }else{ ?>
                                            <a href="{{url('changescatstatus1/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Make Active"><button class="btn btn-success btn-sm"><i class="fa fa-check" aria-hidden="true"></i></button></a>&nbsp;
                                        <?php } ?>
                                        <a href="{{url('edit-super-category/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><button class="btn btn-primary btn-sm" id="delete"><i class="fas fa-edit"></i> </button></a>&nbsp;
                                        <a href="{{url('delete-super-category/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Delete"><button class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i> </button></a>&nbsp;
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