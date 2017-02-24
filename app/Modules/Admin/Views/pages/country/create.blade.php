@extends('Admin::layouts.layout')

@section('content')
<section class="content-header">
  <h1>Country</h1>
</section>
<section class="content">

	<div class="box">
		<div class="container-fluid">
			{!!Form::open(array('route'=>array('admin.country.store'),'class'=>'formAdmin form-horizontal','files'=>true))!!}
				<div class="form-group">
					<label for="">Hình đại diện</label>
					{!!Form::file('img')!!}
					@if($errors->first('img'))
						<p class="error">{!!$errors->first('img')!!}</p>
					@endif
				</div>
				<div class="form-group">
					<label for="">Hình Slideshow</label>
					{!!Form::file('imgslide')!!}
				</div>
				<div class="form-group">
					<label for="">Quốc gia</label>
					{!!Form::text('name',old('name'),array('class'=>'form-control'))!!}
				</div>
				<div class="form-group">
					<label for="">Mô tả</label>
					{!!Form::textarea('description',old('description'),array('class'=>'form-control'))!!}
				</div>
				<div class="form-margin">
					<label for="">Kết hợp nhiều quốc gia</label>
					<div>
						<span class="inline-radio"><input type="radio" name="multi_countries" value="1" checked=""> <b>Có</b> </span>
						<span class="inline-radio"><input type="radio" name="multi_countries" value="0" > <b>Không</b> </span>
					</div>
				</div>
				<div class="form-margin">
					<label for="">Hiển thị theo lựa chọn</label>
					<div>
						<span class="inline-radio"><input type="radio" name="home_show" value="1" checked=""> <b>Có</b> </span>
						<span class="inline-radio"><input type="radio" name="home_show" value="0" > <b>Không</b> </span>
					</div>
				</div>
				<div class="form-margin">
					<label for="">Trạng thái</label>
					<div>
						<span class="inline-radio"><input type="radio" name="status" value="1" checked=""> <b>Active</b> </span>
						<span class="inline-radio"><input type="radio" name="status" value="0" > <b>Deactive</b> </span>
					</div>
				</div>
				<div class="form-margin">
					<label for="img_banner">Hình Banner</label>
					{!!Form::file('img-banner')!!}
				</div>

				<div class="form-margin">
					<label for="img-banner-mobile">Hình Banner Mobile version</label>
					{!!Form::file('img-banner-mobile')!!}
				</div>

				<div class="form-group">
					{!!Form::submit('Save',array('class'=>'btn btn-primary'))!!}
					<a href="{!!URL::previous()!!}" class="btn btn-primary">Back</a>
				</div>
			{!!Form::close()!!}
		</div>
	</div>
</section>
@stop

@section('script')
<script>

</script>
@stop