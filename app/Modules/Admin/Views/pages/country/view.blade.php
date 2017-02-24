@extends('Admin::layouts.layout')

@section('content')

<section class="content-header">
  <h1>Country</h1>
</section>
<section class="content">
	<div class="box">
		<div class="container-fluid">
			{!!Form::model($country,array('route'=>array('admin.country.update',$country->id),'method'=>'PUT' ,'class'=>'formAdmin form-horizontal','files'=>true))!!}
				<div class="form-group">
					<label for="">Quốc gia</label>
					{!!Form::text('name',old('name'),array('class'=>'form-control'))!!}
				</div>
				<div class="form-group">
					<label for="">Mô tả</label>
					{!!Form::textarea('description',old('description'),array('class'=>'form-control'))!!}
				</div>

				<div class="form-group">
					<label for="" >Sắp xếp</label>
					{!!Form::text('order',old('order'),array('class'=>'form-control'))!!}
				</div>

				<div class="form-group">
					<label for="" >Hình đại diện</label>
					<p>
						<img src="{!!$country->img_avatar!!}" width="150" alt="">
						{!!Form::hidden('img-bk',$country->img_avatar)!!}
					</p>
					{!!Form::file('img')!!}
				</div>
				<div class="form-group">
					<label for="" >Hình slideshow</label>
					<p>
						<img src="{!!$country->img_slide!!}" width="150" alt="">
						{!!Form::hidden('imgslide-bk',$country->img_slide)!!}
					</p>
					{!!Form::file('imgslide')!!}
				</div>
				<div class="form-group">
					<label for="">Kết hợp nhiều quốc gia</label>
					<div>
						<span class="inline-radio"><input type="radio" name="multi_countries" value="1" {!!$country->multi_countries == 1 ? 'checked' : ''!!}> <b>Có</b> </span>
						<span class="inline-radio"><input type="radio" name="multi_countries" value="0" {!!$country->multi_countries == 0 ? 'checked' : ''!!}> <b>Không</b> </span>
					</div>

				</div>
				<div class="form-group">
					<label for="">Hiển thị theo lựa chọn</label>
					<div>
						<span class="inline-radio"><input type="radio" name="home_show" value="1" {!!$country->home_show == 1 ? 'checked' : ''!!}> <b>Có</b> </span>
						<span class="inline-radio"><input type="radio" name="home_show" value="0" {!!$country->home_show == 0 ? 'checked' : ''!!}> <b>Không</b> </span>
					</div>
				</div>
				@if(!$country->images()->where('type','banner_country')->get()->isEmpty())
				<div class="form-group">
					<label for="">Hình Banner</label>
					<div>
						<ul class="ul-image">
							@foreach($country->images()->where('type','banner_country')->get() as $image)
							<li>
								<img src="{!!$image->img_url!!}" class="img-responsive" alt="">
								<button type="button" data-id="{!!$image->id!!}" class="remove-banner btn btn-xs btn-danger">Remove</button>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
				@endif
				<div class="form-group">
					<label for="img-banner">Thêm Hình Banner</label>
					{!!Form::file('img-banner')!!}
				</div>
				@if(!$country->images()->where('type','banner_country_mobile')->get()->isEmpty())
				<div class="form-group">
					<label for="">Hình Banner Mobile Version</label>
					<div>
						<ul class="ul-image">
							@foreach($country->images()->where('type','banner_country_mobile')->get() as $image_mobile)
							<li>
								<img src="{!!$image_mobile->img_url!!}" class="img-responsive" alt="">
								<button type="button" data-id="{!!$image_mobile->id!!}" class="remove-banner btn btn-xs btn-danger">Remove</button>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
				@endif
				<div class="form-group">
					<label for="img-banner-mobile">Thêm Hình Banner Mobile version</label>
					{!!Form::file('img-banner-mobile')!!}
				</div>
				<div class="form-group">
					<label for="status">Trạng thái hoạt động</label>
					<div>
						<span class="inline-radio"><input type="radio" name="status" value="1" {!!$country->status == 1 ? 'checked' : ''!!}> <b>Active</b> </span>
						<span class="inline-radio"><input type="radio" name="status" value="0" {!!$country->status == 0 ? 'checked' : ''!!}> <b>Deactive</b> </span>
					</div>
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
	$('.remove-banner').click(function(){
		var thisbtn = $(this);
		var id = thisbtn.data('id');
		alertify.confirm('You can not undo this action. Are you sure ?', function(e){
			if(e){
				$.ajax({
					'url':'{!!route("admin.country.removeBanner")!!}',
					'data' : {id: id,_token:$('meta[name="csrf-token"]').attr('content')},
					'type':'POST',
					'success':function(data){
						thisbtn.parent().remove();
					}
				})
			}
		})
	})
})
</script>
@stop
