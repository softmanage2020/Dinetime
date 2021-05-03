@extends('layouts/main')
@section('pageSpecificCss')
<link type="text/css" rel="stylesheet" href="{{asset('plugins/bower_components/datatables/jquery.dataTables.min.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('plugins/bower_components/datatables/buttons.dataTables.min.css')}}" />
<style>
tr.even{
	background-color: #191B1D !important;
}
tr th{
  padding-left: 10px !important;
  color: #dce2ec !important;
}
tr td{
  color: #dce2ec !important;
}
.color-dce2ec {
	color: #dce2ec !important;
}
.word-wrap{word-wrap: break-word !important; white-space: normal;width: 400px;}
.QW9338a-APoWav3K944Aw {
    margin: 0 0 4px;
    display: flex;
    align-items: center;
}
._25xMNiLip-SZ1zuCkSA7ge {
    display: flex;
    align-items: center;
}
._2IMP-CK1uNe12eCxaNLqbL {
    display: flex;
    margin-right: 8px;
    align-items: center;
    flex-shrink: 0;
}
._2UvC6jGDOaDUaN4lDzrERj {
    width: 1.5rem;
    height: 1.5rem;
    margin-right: 4px;
}
._2UvC6jGDOaDUaN4lDzrERj>i {
    display: block;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    width: 100%;
    height: 100%;
    color: #da3743;
}
._1J28HXkF9OXU_OaZfUmxou {
    background-image: url(../../../plugins/images/dinetime/star.png);
}
._1h89tIvK1Zm7zGJiJKLt-G {
    background-image: url(../../../plugins/images/dinetime/halfstar.png);
}
</style>
@stop
@section('content')
<!-- Page Content -->
<div class="container-fluid bg-010101">
	<input type="hidden" id="formatedDate" name="formatedDate" value="{{ date('Y_m_d') }}">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title color-dce2ec"> Venue</h4>
		</div>
	</div>
	<!--/row -->
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12">
			<div class="white-box">
				<h3 class="box-title m-b-15 pull-left">All Venues</h3>
				<div class="table-responsive">
					<table id="venueList" class="display nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th class="text-center">Actions</th>
								<th class="text-center">Photo</th>
								<th>Venue Name</th>
								<th>Suburb</th>
								<th>Type</th>
								<th>Dine In</th>
								<th class="text-center">Status</th>
								<th class="text-center">Rating/Review</th>
								<th>Created Date</th>
							</tr>
						</thead>
						<tbody>
						@foreach($venueDetails as $value)
							<tr>
								<td class="text-center">
									@if(Session::get('login_type_id') == 1)
										<span data-toggle="modal" data-target="#rejectedVenueModel">
											<a data-toggle="tooltip" data-placement="top" title="Reject Venue" class="btn btn-warning btn-circle add-venue-reason" data-id="{{$value->venue_id}}">
												<i class="ti-lock"></i>
											</a>
										</span>
									@endif
									<a data-toggle="tooltip" data-placement="top" title="Venue Detail" class="btn btn-primary btn-circle" href="{{ route('venuedetail',['venue_id' => $value->venue_id]) }}">
										<i class="ti-receipt"></i>
									</a>
									<a class="btn btn-danger btn-circle" onclick="return confirm(' Are you sure you want to delete this Venue?');" href="{{ route('removevenue',['venue_id' => $value->venue_id]) }}" data-toggle="tooltip" data-placement="top" title="Remove">
                                        <i class="ti-trash"></i>
									</a>
								</td>
								<td>
								@if(!empty($value->venue_image_url))
									<div><img class="d-block" src="{{url($value->venue_image_url)}}" width="85" height="85" alt="First slide"></div></td>
								@else
									<div><img class="d-block" src="{{ asset('plugins/images/dinetime/logo.png') }}" width="85" height="85" alt="First slide"></div></td>
								@endif
								<td>{{ strtoupper($value->venue_name)}}</td>
								<td>{{strtoupper($value->suburb)}}</td>
								<td>{{$value->restaurant_type}}</td>
								<td>{{$value->dine_in}}</td>
								@if($value->status == 1)
								<td class="label_{{$value->venue_id}}"><span class="label label-info font-weight-100 text-white">Pending</span></td>
								@elseif($value->status == 2)
								<td class="label_{{$value->venue_id}}"><span class="label label-success font-weight-100 text-white">Approved</span></td>
								@else
								<td class="label_{{$value->venue_id}}"><span class="label label-warning font-weight-100 text-white">Rejected</span></td>
								@endif
								<td>
								<div class="QW9338a-APoWav3K944Aw">
								@if(!empty($value->review))
								<div class="_25xMNiLip-SZ1zuCkSA7ge">
									<div class="_2IMP-CK1uNe12eCxaNLqbL" aria-label="">
										@for($i=1;$i<=$value->review; $i++)
										<div class="_2UvC6jGDOaDUaN4lDzrERj"><i class="_1J28HXkF9OXU_OaZfUmxou #da3743" aria-hidden="true" tab-index="-1" focusable="no"></i></div>
										@endfor
										@if(strpos($value->review, "." ) !== false)
										<div class="_2UvC6jGDOaDUaN4lDzrERj"><i class="_1h89tIvK1Zm7zGJiJKLt-G #da3743" aria-hidden="true" tab-index="-1" focusable="no"></i></div>
										@endif
									</div>
								</div>
								@endif
								<span class="_3OyqNtiqTfiRI7Wxdogeko G1kfyull_V3y-AuTlAlGm">@if(!empty($value->total_review))  ({{$value->total_review}} reviews) @else (0 review) @endif</span>
								</div>
								</td>
								<td class="venueCreateDate" datetime="{{ $value->created_at }}">{{ date('m-d-Y',strtotime($value->created_at))}}</td>
							</tr>
							@endforeach	
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- row -->
</div>
<!--Rejected Venue model-->
<div class="modal fade" id="rejectedVenueModel" tabindex="-1" data-backdrop="true" style="display: none;">
	<div class="modal-dialog" style="border:1px solid">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="color-dce2ec" aria-hidden="true">&times;</span></button>
				<h4 class="modal-title color-dce2ec" id="exampleModalLabel1">Add&nbsp;Reason</h4>
			</div>
			<div class="modal-body">
				<div class="form-body">
					<form method="POST" id="formAddVenueReason">
						{{ csrf_field() }}
						<input type="hidden" id="hiddenVenueId" name="hiddenVenueId">
						<div class="row m-t-10">
							<div class="row col-md-12">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-12 color-dce2ec">ADD Reject Reason</label>
										<div class="col-md-12 m-b-10">
											<textarea class="form-control" rows="5" name="venueReason" id="venueReason" placeholder="Enter reason . . ."></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer form-group">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>&nbsp;
							<button type="submit" id="venueReasonSubmit" class="btn btn-success">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--/.jobNotes model-->
@stop
@section('pageSpecificJs')
<script type="text/javascript" src="{{asset('plugins/bower_components/datatables/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/bower_components/datatables/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/bower_components/datatables/buttons.flash.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/bower_components/datatables/jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/bower_components/datatables/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/bower_components/datatables/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/bower_components/datatables/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/bower_components/datatables/buttons.print.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
		var date = $('#formatedDate').val();
        var value = 'DIneTime_Venue' + date;
		/*Franchise*/
		$('#venueList').DataTable({
			dom: 'Bfrtip',
			buttons: [
				{
					extend:'excel',
					title: value,
					exportOptions: {columns: [2,3,4,5,6,7,8 ]},
				},
				{
					extend:'csv',
					title: value,
					exportOptions: {columns: [ 2,3,4,5,6,7,8 ]},
				},
				{
					extend:'pdf',
					title: value,
					exportOptions: {columns: [ 2,3,4,5,6,7,8 ]},
				},
				{
					extend:'print',
					title: value,
					exportOptions: {columns: [ 2,3,4,5,6,7,8 ]},
				},
			],
		});

		$('.venueCreateDate').each(function(i, e) {
			var time = $(this).attr('datetime');
			time = moment.parseZone(time).local().format('MM-DD-YYYY');
			$(e).html(time);
		});
	});

/*set job id on models*/
$(document).on('click',".add-venue-reason",function(){
	var venueId = $(this).attr('data-id');
	$("#venueReasonSubmit").prop("disabled",false);
	$('#hiddenVenueId').val(venueId);
	$('#venueReason').val('');
	$('#venueReasonSubmit').html('Add');
});

$('#formAddVenueReason').on('success.form.bv', function(e) {
	e.preventDefault();
	$('#loader').show();
	$('#rejectedVenueModel').modal('hide');
	var hidden_venue_id = $('#hiddenVenueId').val();
	var venue_reason = $('#venueReason').val();
	$.ajax({
		url:'{{ route('rejectvenue') }}',
		data:{
			hidden_venue_id:hidden_venue_id,
			venue_reason:venue_reason
		},
		type:'post',
		dataType:'json',
		success: function(data)
		{
			if(data.key == 1)
			{
				location.reload();
			}
		}
	});
});

$(document).on('click',".approveVenue",function(){
	$('#loader').show();
	var hidden_venue_id = $(this).attr('data-id');
	$.ajax({
		url:'{{ route('approvevenue') }}',
		data:{
			hidden_venue_id:hidden_venue_id
		},
		type:'post',
		dataType:'json',
		success: function(data)
		{
			if(data.key == 1)
			{
				location.reload();
			}
		}
	});
});
</script>
@stop