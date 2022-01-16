@extends('layouts.header')
@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            @if(Session::has('success'))
                <p style="z-index: 1;" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }} <i class="fas fa-check-circle"></i></p>
            @endif
            <div class="row">
                <a href="{{route('add-outlet')}}"><button class="btn btn-primary">Add Outlet</button></a>&nbsp;
                <button style="margin-bottom:15px;" class="btn btn-danger btn-xs delete-all" id="btnPrintoutlet">Delete Selected</button>&nbsp;
                <a href="#" data-toggle="modal" data-target="#exampleModal"><button class="btn btn-info">Import</button></a>&nbsp;
            </div>   
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th></th>
                                <th>S.No</th>
                                <th>Company Id</th>
                                <th>Brand Admin Id </th>
                                <th>Country</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Outlet Location</th>
                                <th>Outlet Pincode</th>
                                <th>Pincode Served</th>
                                <th>Store Admin</th>
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
                                <td>{{$row->company_id}}</td>
                                <td>{{$row->brand_admin_id}}</td>
                                <td>{{$row->country}}</td>
                                <td>{{$row->state}}</td>
                                <td>{{$row->city}}</td>
                                <td>{{$row->outlet_location}}</td>
                                <td>{{$row->outlet_pincode}}</td>
                                <td>{{$row->served_pincode}}</td>
                                <?php $data=explode(',',$row->store_admin_id);
                                      $name =  DB::table('store_admin')->select('store_admin.name')->whereIn('id',$data)->get();
                                ?>
                                <td>
                                    <?php foreach ($name as $names){
                                        $datat= $names->name.',';
                                        echo $datat;
                                    } 
                                    ?>
                                </td>
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
                                            <a href="{{url('changeoutstatus2/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Make Inactive"><button class="btn btn-success btn-sm"><i class="fa fa-times" aria-hidden="true"></i></button></a>&nbsp;
                                        <?php }else{ ?>
                                            <a href="{{url('changeoutstatus1/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Make Active"><button class="btn btn-success btn-sm"><i class="fa fa-check" aria-hidden="true"></i></button></a>&nbsp;
                                        <?php } ?>
                                        <a href="{{url('edit-outlet/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><button class="btn btn-primary btn-sm" id="delete"><i class="fas fa-edit"></i> </button></a>&nbsp;
                                        <a href="{{url('delete-outlet/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Delete"><button class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i> </button></a>&nbsp;
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Outlets</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="overflow: scroll;max-height: 80vh !important;">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="#">
                    <div class="input-group">
                        <input type="file" class="form-control" name="brand_admin" />
                        <button class="btn btn-primary input-group-addon" style="border-radius:0px;">Upload</span>
                    </div>
                    <div class="form-group">
    					<p class="form-input-hint">Please choose the fields from below and then download the template. Enter the data in excel and then upload the excel.</p>
      			    </div>
                </form>
                <div class="form-cont">
    					<h5>Choose Excel Fields - Choose User information fields to be imported</h5>
    					<div class="excelFields" style="margin-top:20px;">
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" class="loginField" name="company_id">
    								<i class="form-icon"></i> Company Id
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="brand_id">
    								<i class="form-icon"></i> Brand Id
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="country">
    								<i class="form-icon"></i> Country
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="state">
    								<i class="form-icon"></i> State
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="city">
    								<i class="form-icon"></i> City
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="location">
    								<i class="form-icon"></i> location
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" class="loginField" name="pincode">
    								<i class="form-icon"></i> Pincode
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="served_pincode">
    								<i class="form-icon"></i> Pincode Served
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="radius">
    								<i class="form-icon"></i> Radius
      							</label>
    						</div>
    					</div>
    					<div class="text-right">
    						<button class="btn btn-primary btn-sm downloadExcelTemplateBtn" data-href="#">Download Excel Template</button>
    					</div>
    				</div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection