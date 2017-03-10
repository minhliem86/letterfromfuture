@extends('Admin::layouts.layout')

@section('content')
 <section class="content-header">
  <h1>
    Students List
    <!-- <small>Optional description</small> -->
  </h1>
  <!-- <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
    <li class="active">Here</li>
  </ol> -->
</section>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">

					@if($data->count() != 0)
					<div class="box-body">
						<table id="table-post" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th data-width="30%">Fullname</th>
									<th>Facebook link</th>
									<th>Status</th>
									<th>Point</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								@foreach($data as $item)
									<tr>
										<td >{!!$item->id!!}</td>
										<td>{!!$item->name!!}</td>
										<td><a href="{!!$item->fb_link!!}" target="_blank">Facebook link</a></td>
										<td>{!!$item->votes()->where('user_id',Auth::user()->id)->first() ? 'Done' : 'Not'!!}</td>
										<td>
											<div id="jRate-{!!$item->id!!}"></div>
											<script type="text/javascript">
												$('#jRate-{!!$item->id!!}').jRate({
													readOnly: true,
													rating:{!!$item->votes()->where('user_id',Auth::user()->id)->first() ? $item->votes()->where('user_id',Auth::user()->id)->first()->diem : '0'!!}
												})
											</script>
										</td>
										<td>
											<a href="{!!route('admin.student.show',$item->id)!!}" class="btn btn-primary btn-xs">Vote</a>
										</td>
									</tr>
									@endforeach
							</tbody>
							<tfoot>

							</tfoot>

						</table>
					</div>
					@else
						<h2 class="text-center">No Data</h2>
					@endif
							<!-- /.box-body -->
				</div>
				</div>	<!-- end ajax-table-->

			</div>
		</div>
	</div>

</section>
@stop

@section('script')
	<!-- SCRIPT -->
	{!!Html::style(asset('public/assets/backend').'/js/DataTables/datatables.min.css')!!}
	{!!Html::script(asset('public/assets/backend').'/js/DataTables/datatables.min.js')!!}

	<script type="text/javascript">
		$(document).ready(function(){
			{!! Notification::showSuccess('alertify.success(":message");') !!}
			{!! Notification::showError('alertify.error(":message");') !!}

			var table = $('#table-post').DataTable({
				"order":[[4,'asc']],
				"columnDefs":[
						{"targets":[0,2,3,5],"orderable":false}
				],
				"bLengthChange": false,
				"bFilter" : false,
			});
			/*SELECT ROW*/
			$('#table-post tbody').on('click','tr',function(){
				$(this).toggleClass('selected');
			})
		})

	</script>
@stop
