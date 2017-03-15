@extends('Admin::layouts.layout')

@section('content')
 <section class="content-header">
  <h1> Teacher List
    <!-- <small>Optional description</small> -->
  </h1>
  <!-- <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
    <li class="active">Here</li>
  </ol> -->
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
	            <!-- /.box-header -->
	            @if(!$data_teacher->isEmpty())
				<div class="box-body">

				  <table id="table-post" class="table table-bordered table-striped">
				    <thead>
					    <tr>
							<th>ID</th>
							<th data-width="30%">Fullname</th>
							<th>Email Address</th>
							<th>Role</th>
              <th>Created date</th>
							<th>Action</th>
						</tr>
				    </thead>
				    <tbody>
					  @foreach($data_teacher as $item)
  						<tr>
                <td>{!!$item->id!!}</td>
  							<td >{!!$item->name!!}</td>
  							<td>{!!$item->email!!}</td>
  							<td>{!!$item->roles()->first()->name!!}</td>
  							<td>{!!$item->created_at!!}</td>
  							<td>
                  {!!Form::open(array('route'=>array('admin.user.deleteUser',$item->id),'method'=>'DELETE', 'class' => 'inline'))!!}
    							<button class="btn  btn-danger btn-xs remove-btn" type="button" onclick="confirm_remove(this);"> Remove </button>
    							{!!Form::close()!!}
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
				'ordering': false,
				"bLengthChange": false,
				"bFilter" : false,
			});
			/*SELECT ROW*/
			$('#table-post tbody').on('click','tr',function(){
				$(this).toggleClass('selected');
			})

			/*REMOVE SELECTED*/
		})
    function confirm_remove(a){
			alertify.confirm('You can not undo this action. Are you sure ?', function(e){
				if(e){
					a.parentElement.submit();
				}
			});
		}


	</script>
@stop
