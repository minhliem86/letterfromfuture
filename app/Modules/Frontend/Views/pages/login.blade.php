@extends('Frontend::layouts.default')

@section('script')
	<script>
		// window.onload = init;
		$(document).ready(function(){
			$('input#student_code').on('change',function(){
				var val = $(this).val();
				$.ajax({
					'url':'{!!route("frontend.checkLogin")!!}',
					'data' : {code: val, _token:$('meta[name="csrf-token"]').attr('content')},
					'type' : 'POST',
					success: function(data){
						if(data.result != 'Mã học viên không chính xác' && data.result != 'Mỗi học viên chỉ có thể tham gia 01 lần.'){
							$('input[type="submit"]').removeAttr('disabled');
						}else{
							$('input[type="submit"]').attr('disabled','disabled');
						}
						$('input[name="fullname"]').val(data.result);
					}
				})
			});
		});


	</script>
@stop
@section('content')

@include('Frontend::layouts.header02')
<div class="section login">
			<div class="container">
				<div class="row">
					<div class="inner-login">
						<div class="wrap-login">
							<form action="{!!route('frontend.postLogin')!!}" class="form-login" method="POST">
								{!!Form::token()!!}
								<div class="wrap-image">
									<label for="image" id="style-image">Tải ảnh đại diện</label>
									<input type="file" id="image" name="img">
								</div>
								<div class="wrap-form-input">
									<input type="text" name="code" class="form-control" placeholder="Mã học viên" id="student_code">
									<input type="text" name="fullname" class="form-control" placeholder="Tên học viên" disabled="">
								</div>
								<div class="wrap-btn clearfix">
									<input type="submit" class="btn-login" value="Bắt đầu viết" disabled="disabled">
									<a href="{!!route('homepage')!!}" class="btn-home">Trang chủ</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
@stop
