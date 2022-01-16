@extends('layouts.header')
@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            @if(Session::has('success'))
                <p style="z-index: 1;" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }} <i class="fas fa-check-circle"></i></p>
            @endif
            <div class="row">
                <a href="{{route('add-company')}}"><button class="btn btn-primary">Add Comapny</button></a>&nbsp;
                <button style="margin-bottom:15px;" class="btn btn-danger btn-xs delete-all" id="btnPrintcompany">Delete Selected</button>&nbsp;
                <a href="#" data-toggle="modal" data-target="#exampleModal"><button class="btn btn-info">Import</button></a>&nbsp;
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th></th>
                                <th>S.No</th>
                                <th>Action</th>
                                <th>Status</th>
                                <th>Company Name</th>
                                <th>Comapny Id</th>
                                <th>Brand Name</th>
                                <th>Contact Person Name</th>
                                <th>Contact Person Mobile</th>
                                <th> Contact Person Email</th>
                                <th>Website</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Pincode</th>
                                <th>Radius</th>
                                <th>GST Number</th>
                                <th>Quick Shop Per Click Price</th>
                                <th>Live Shop Per Click Price</th>
                                <th>Prepiad Video Minutes</th>
                                <th>Prepiad Audio Minutes</th>
                                <th>Commision On Sell (In %)</th>
                                <th>S&M Price Per Store</th>
                                <th>Reserve Video Minutes</th>
                                <th>Reserve Voice Minutes</th>
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
                                <td>
                                    <div style="display: flex;">
                                        <?php
                                            if($row->status ==1){ ?>
                                            <a href="{{url('changecomstatus2/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Make Inactive"><button class="btn btn-success btn-sm"><i class="fa fa-times" aria-hidden="true"></i></button></a>&nbsp;
                                        <?php }else{ ?>
                                            <a href="{{url('changecomstatus1/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Make Active"><button class="btn btn-success btn-sm"><i class="fa fa-check" aria-hidden="true"></i></button></a>&nbsp;
                                        <?php } ?>
                                        <a href="{{url('edit-company/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><button class="btn btn-primary btn-sm" id="delete"><i class="fas fa-edit"></i> </button></a>&nbsp;
                                        <a href="{{url('delete-company/'.$row->id)}}" data-toggle="tooltip" data-placement="top" title="Delete"><button class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i> </button></a>&nbsp;
                                    </div>
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
                                <td>{{$row->name}}</td>
                                <td>{{$row->company_id}}</td>
                                <td><?php if(!empty($row->brand_name)){echo $row->brand_name;}else{ echo '-';} ?></td>
                                <td><?php if(!empty($row->contact_name)){echo $row->contact_name;}else{ echo '-';} ?></td>
                                <td><?php if(!empty($row->contact_mobile)){echo $row->contact_mobile;}else{ echo '-';} ?></td>
                                <td>{{$row->email}}</td>
                                <td><?php if(!empty($row->website)){echo $row->website;}else{ echo '-';} ?></td>
                                <td>{{$row->city}}</td>
                                <td><?php if(!empty($row->address)){echo $row->address;}else{ echo '-';} ?></td>
                                <td>{{$row->pincode}}</td>
                                <td>{{$row->radius}}</td>
                                <td><?php if(!empty($row->gst_number)){echo $row->gst_number;}else{ echo '-';} ?></td>
                                <td><?php if(!empty($row->quick_shop)){echo $row->quick_shop;}else{ echo '-';} ?></td>
                                <td><?php if(!empty($row->online_shop)){echo $row->online_shop;}else{ echo '-';} ?></td>
                                <td><?php if(!empty($row->video_minutes)){echo $row->video_minutes;}else{ echo '-';} ?></td>
                                <td><?php if(!empty($row->audio_minutes)){echo $row->audio_minutes;}else{ echo '-';} ?></td>
                                <td><?php if(!empty($row->commision)){echo $row->commision;}else{ echo '-';} ?></td>
                                <td><?php if(!empty($row->store_price)){echo $row->store_price;}else{ echo '-';} ?></td>
                                <td><?php if(!empty($row->reserve_video_minutes)){echo $row->reserve_video_minutes;}else{ echo '-';} ?></td>
                                <td><?php if(!empty($row->reserve_audio_minutes)){echo $row->reserve_audio_minutes;}else{ echo '-';} ?></td>
                                
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
        <h5 class="modal-title" id="exampleModalLabel">Import Brand Admin</h5>
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
    								<input type="checkbox" name="name">
    								<i class="form-icon"></i> Name
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="brand_name">
    								<i class="form-icon"></i> Brand Name
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" class="loginField" name="company_id">
    								<i class="form-icon"></i> Short Name
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="person_name">
    								<i class="form-icon"></i>Contact Person Name
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" class="loginField" name="person_email">
    								<i class="form-icon"></i> Contact Person Email
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="person_mobile">
    								<i class="form-icon"></i> Contact Person Mobile
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
    								<input type="checkbox" name="address">
    								<i class="form-icon"></i> Address
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="website">
    								<i class="form-icon"></i> Website
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="pincode">
    								<i class="form-icon"></i> Pincode
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="radius">
    								<i class="form-icon"></i> Radius
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="info">
    								<i class="form-icon"></i> About Company
      							</label>
    						</div>
    						<div class="form-group">
      							<label class="form-checkbox">
    								<input type="checkbox" name="password">
    								<i class="form-icon"></i> Password
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