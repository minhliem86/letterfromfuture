@extends('Admin::layouts.layout')

@section('content')
<section class="content-header">
  <h1>Modify Tour</h1>
</section>
<section class="content">
	<div class="box">
		<div class="container-fluid">
			<!-- <div class="row">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Thêm Lịch trình</button>
			</div>

			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Thêm lịch trình</h4>
			      </div>
			      {!!Form::open(['files'=>true])!!}
			      <input type="hidden" name="tour_id" value="{!!$tour->id!!}">
			      <div class="modal-body">
			        <div class="form-group">
			        	{!!Form::text('titleSch',old('titleSch[]'),array('class'=>'form-control', 'placeholder' => 'Tiêu đề (vd Tuần 1: 15/01 - 20/01/2017)'))!!}
			        </div>
			        <div class="form-group">
			        	{!!Form::textarea('contentSch',old('contentSch[]'),array('class'=>'form-control','rows'=>3, 'placeholder'=>'Nội dung'))!!}
			        </div>
			        <div class="form-group">
			        	{!!Form::file('imgSch')!!}
			        </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary">Save changes</button>
			      </div>
			      {!!Form::close()!!}
			    </div>
			  </div>
			</div> -->

			{!!Form::model($tour,array('route'=>array('admin.tour.update',$tour->id),'method'=>'PUT' ,'class'=>'formAdmin form-horizontal','files'=>true))!!}
				<div class="form-group">
					<label for="">Tên Tour</label>
					{!!Form::text('title',old('title'),array('class'=>'form-control'))!!}
				</div>
				<div class="form-group">
					<label for="">Quốc gia du học</label>
					{!!Form::select('country_id',$country,$tour->country_id,['class'=>'form-control'])!!}
				</div>
				<div class="form-group">
					<label for="">Nơi đăng ký</label>
					{!!Form::select('location_id',$location,'',['class'=>'form-control'])!!}
				</div>
				<div class="form-group">
					<label for="">Mô tả</label>
					{!!Form::textarea('description',old('description'),array('class'=>'form-control','rows'=>3))!!}
				</div>
				<div class="form-group">
					<label for="" >Nội dung</label>
					{!!Form::textarea('content',old('content'),array('class'=>'form-control ckeditor'))!!}
				</div>


				<!-- MODIFY SCHEDULE -->
				<!-- @if($tour->schedule()->get())
				<div class="form-group">
					<label for="">Lịch trình</label>
				
					<div class="container-fluid">
						<div class="wrap-schedule">
							@foreach($tour->schedule()->get() as $item_schedule)
							<input type="hidden" name="schedule_id[]" value="{!!$item_Schedule->id!!}" >
							<div class="each-schedule" style="margin-bottom:10px;">
								<div class="form-group">
									<input type="text" name="scheduletitle[]" value="{!! $item_schedule->title !!}" class="form-control" placeholder="Tiêu đề (vd Tuần 1: 15/01 - 20/01/2017)">
								</div>
								<div class="form-group">
									<textarea name="schedulecontent[]" rows="4" class="form-control">{!! $item_schedule->content !!}</textarea>
								</div>
								<div class="form-group">
									<label for="" >Hình đại diện</label>
									<p>
										<img src="{!!$item_schedule->img_avatar!!}" width="150" alt="">
									</p>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
				@endif -->

				<div class="form-group">
					<label for="">Đối tác</label>
					{!!Form::text('partner',old('partner'),array('class'=>'form-control'))!!}
				</div>
				<div class="form-group">
					<label for="">Chổ ổ</label>
					{!!Form::text('stay',old('stay'),array('class'=>'form-control'))!!}
				</div>
				<div class="form-group">
					<label for="">Thời gian dự kiến</label>
					{!!Form::text('week',old('week'),array('class'=>'form-control'))!!}
				</div>
				<div class="form-group">
					<label for="">Thời gian bắt đầu</label>
					{!!Form::text('start',old('start'),array('class'=>'form-control date'))!!}
				</div>
				<div class="form-group">
					<label for="">Thời gian kết thúc</label>
					{!!Form::text('end',old('end'),array('class'=>'form-control date'))!!}
				</div>
				<div class="form-group">
					<label for="">Giá</label>
					{!!Form::text('price',old('price'),array('class'=>'form-control'))!!}
				</div>
				<div class="form-group">
					<label for="">Độ tuổi</label>
					{!!Form::text('age',old('age'),array('class'=>'form-control'))!!}
				</div>
				<div class="form-group">
					<label for="" >Thứ tự</label>
					{!!Form::text('order',old('order'),array('class'=>'form-control'))!!}
				</div>

				<div class="form-group">
					<label for="" >Hình đại diện</label>
					<p>
						<img src="{!!$tour->img_avatar!!}" width="150" alt="">
						{!!Form::hidden('img-bk',$tour->img_avatar)!!}
					</p>
					{!!Form::file('img')!!}
				</div>
				
				<div class="form-group">
					<label for="" >Hình FB sharing (600x315)</label>
					<p>
						<img src="{!!$tour->img_sharing!!}" width="150" alt="">
						{!!Form::hidden('img-bk-sharing',$tour->img_sharing)!!}
					</p>
					{!!Form::file('img-sharing')!!}
				</div>
				
				<div class="form-group">
					<span class="inline-radio"><input type="radio" name="status" value="1" {!!$tour->status == 1 ? 'checked' : ''!!}> <b>Active</b> </span>
					<span class="inline-radio"><input type="radio" name="status" value="0" {!!$tour->status == 0 ? 'checked' : ''!!}> <b>Deactive</b> </span>
				</div>

				<div class="form-group">
					{!!Form::submit('Save',array('class'=>'btn btn-primary'))!!}
				</div>
			{!!Form::close()!!}
		</div>
	</div>
</section>
@stop

@section('script')
<script>
	$(document).ready(function(){
		$('.date').datepicker({
			'dateFormat': 'dd-mm-yy'
		});

		// ADD SCHEDULE
		// $('#addschedule').on('click',function(){
		// 	$('.each-schedule:first-child').clone().appendTo('.wrap-schedule');
		// })
	})

</script>
@stop