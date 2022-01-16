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
                <div class="col-md-12">
                    <a href="{{route('assign-spec')}}"><button class="btn btn-primary">Assign Specification</button></a>&nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Sub Category</th>
                                <th>Restricted Specification</th>
                                <!--<th>Action</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                            ?>
                            @foreach($users1 as $row)
                            <tr>
                                <td><?php echo $i++;?></td>
                                <td>{{$row->subname}}</td>
                                <td>
                                  <?php if(!empty($row->restrictionspecification)){ echo  $row->restrictionspecification;}else{echo '-';} ?>
                                </td>
                                <!--<td>-->
                                    <?php //if(!empty($row->id)){ ?>
                                    <!--<a href="{{url('edit-restriction/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><button class="btn btn-primary btn-sm" id="delete"><i class="fas fa-edit"></i> </button></a>&nbsp;-->
                                    <?php //} ?>
                                <!--</td>-->
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