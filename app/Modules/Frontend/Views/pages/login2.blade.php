@extends('Frontend::layouts.default')

@section('script')
	<script>
		// window.onload = init;
		$(document).ready(function(){
			$('button[name="login"]').on('click',function(){
				var val = $('#student_code').val();
				$.ajax({
					'url':'{!!route("frontend.checkLogin")!!}',
					'data' : {code: val, _token:$('meta[name="csrf-token"]').attr('content')},
					'type' : 'POST',
					success: function(data){
						if(data.result != 'Vui lòng nhập chính xác mã học viên'){
							$('input[type="submit"]').removeAttr('disabled');
						}else{
							$('input[type="submit"]').attr('disabled','disabled');
						}
						$('input[name="fullname"]').val(data.result);
					}
				})
			})
		});

		// function init() {
		// 	key_count_global = 0; // Global variable
		// 	document.getElementById("student_code").onkeypress = function(ele) {
		// 		key_count_global++;
		// 		setTimeout(function(){
		// 			var val = $(ele.target).val();
		// 			// console.log(val);
		// 			$.ajax({
		// 				'url':'{!!route("frontend.checkLogin")!!}',
		// 				'data' : {code: val, _token:$('meta[name="csrf-token"]').attr('content')},
		// 				'type' : 'POST',
		// 				success: function(data){
		// 					if(data.result != 'Vui lòng nhập chính xác mã học viên'){
		// 						$('input[type="submit"]').removeAttr('disabled');
		// 					}
		// 					$('input[name="fullname"]').val(data.result);
		// 				}
		// 			})
		// 		}, 3000);//Function will be called 1 second after user types anything. Feel free to change this value.
		// 	}
		// }
		// window.onload = init; //or $(document).ready(init); - for jQuery

		// function lookup(key_count) {
		// 	if(key_count == key_count_global) { // The control will reach this point 1 second after user stops typing.
		// 		// Do the ajax lookup here.
		// 		document.getElementById("status_stop").innerHTML = " ... lookup result ...";
		// 	}
		// }
	</script>
@stop
@section('content')

@include('Frontend::layouts.header02')
<div class="section login">
			<div class="container">
				<div class="row">
					<div class="inner-login">
						<div class="wrap-login">
							<form action="" class="form-login" method="POST">
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
									<a href="#" class="btn-home">Trang chủ</a>
								</div>
								<div class="form-group">
									<button type="button" name="login" class="btn btn-primary">Đăng nhập</button>
								</div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
@stop
