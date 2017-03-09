@extends('Frontend::layouts.default')

@section('script')
	<script src="{!!asset('public/assets/frontend')!!}/js/jquery.nicescroll.min.js"></script>
	<script src="{!!asset('public/assets/frontend')!!}/js/textcounter-edit-byme.js"></script>

	<script src="{!!asset('public/assets/frontend')!!}/js/html2canvas.js"></script>
	<script src="{!!asset('public/assets/frontend')!!}/js/jquery.validate.min.js"></script>
	<script src="{!!asset('public/assets/frontend')!!}/js/base64binary.js"></script>

	<script>
		$(document).ready(function(){
			$('textarea[name="content"]').textcounter({
				type: 'word',
				max: '200',
				countDown: true,
				countDownText: "Số ký tự còn lại: %d",
				// countContainerClass: 'count-area'
			})

			$('textarea[name="quote"]').textcounter({
				type: 'word',
				max: '50',
				// countContainerClass: 'count-area'
			})

			$('.wrap-bottom').niceScroll();
			$('.wrap-quote-textarea').niceScroll();
		})
	</script>
	<script type="text/javascript">
		/*FB INIT*/
		window.fbAsyncInit = function() {
		  FB.init({
		    appId      : '{!!env("FACEBOOK_APP_ID")!!}',
		    cookie      : true,
		  // xfbml  : true,
		    version    : 'v2.8'
		  });
		  FB.AppEvents.logPageView();
		};

		(function(d, s, id){
		   var js, fjs = d.getElementsByTagName(s)[0];
		   if (d.getElementById(id)) {return;}
		   js = d.createElement(s); js.id = id;
		   js.src = "//connect.facebook.net/en_US/sdk.js";
		   fjs.parentNode.insertBefore(js, fjs);
		 }(document, 'script', 'facebook-jssdk'));
		 /*END*/

		// Convert a data URI to blob
		function dataURItoBlob(dataURI) {
		    var byteString = atob(dataURI.split(',')[1]);
		    var ab = new ArrayBuffer(byteString.length);
		    var ia = new Uint8Array(ab);
		    for (var i = 0; i < byteString.length; i++) {
		        ia[i] = byteString.charCodeAt(i);
		    }
		    return new Blob([ab], {
		        type: 'image/png'
		    });
		}
		// POST FB
		function postFacebook(filename,caption,description,link){
			FB.api('https://graph.facebook.com/', 'post', {
					id: link,
					scrape: true
			}, function(response) {
				FB.ui({
					method: 'feed',
					display: 'popup',
					name: filename,
					caption: 'ila.edu.vn',
					description: description,
					link : link,
				},function(res){
					if(typeof res !== 'undefined'){

						var linkfb = 'https://www.facebook.com/'+res.post_id;
						$.ajax({
							'url': '{!!route("frontend.AjaxOrder")!!}',
							'type':'POST',
							data: {link:linkfb, _token:$("meta[name='csrf-token']").attr("content")},
							success:function(data){

								if(data.rs == "Đã tham dự"){
										window.location = "{!!route('frontend.Done')!!}";
								}
							}
						})

					}else{
						alert('Để hoàn tất cuộc thi, bạn phải share bài viết của bạn trên status ở chế độ public!');
						$('.overlay-bg').fadeOut();
					}
				})
			});
		}

	</script>
	<script type="text/javascript">
		$(document).ready(function(){

			$('.form-letter').validate({
				elementError: 'span',
				errorPlacement: function(error, element) {
            //Custom position: first name
            if (element.attr("name") == "content" ) {
                $("#validate-content").text($(error).html());
            }else if(element.attr("name") == "quote"){
								$("#validate-quote").text($(error).html());
						}else{
            	element.after(error);
            }
        },
				rules: {
					content: "required",
					quote: "required",
				},
				messages:{
					content: 'Vui lòng nhập nội dung bức thư',
					quote: 'Vui lòng nhập câu trích dẫn'
				},
				submitHandler:function(data){
					var from = $('input[name="from"]').val();
					var message = $('textarea[name="content"]').val();
					var quote = $('textarea[name="quote"]').val();
					$('.overlay-bg').fadeIn();

					// getPictureAjax();
					FB.getLoginStatus(function(response) {
						if (response.status === 'connected') {
							FB.api('me/picture?type=large',function(response){
								var img = response.data.url;
								$.ajax({
									url: '{!!route("frontend.AjaxImg")!!}',
									type: 'POST',
									data: {img: img, _token:$("meta[name='csrf-token']").attr("content")},
									success:function(data){
										console.log(data.rs)
									}
								})
							});
							$.ajax({
								url:'{!!route("frontend.ajaxLetter")!!}',
								type:'POST',
								data:{from:from,message:message,quote:quote, _token:$("meta[name='csrf-token']").attr("content")},
								success:function(data){
									// console.log(data.rs);
									$('#preview').html(data.rs);

									/*RENDER IMAGE*/
									var element = $('#preview');
									element.show();
									html2canvas(element, {
											onrendered: function (canvas) {
												var dataimg = canvas.toDataURL("image/png");
												try {
														blob = dataURItoBlob(dataimg);
												} catch (e) {
														console.log(e);
												}

												$.ajax({
													url: '{!!route("frontend.AjaxGetImg")!!}',
													type:'POST',
													data: {img:dataimg,  _token:$("meta[name='csrf-token']").attr("content")},
													success:function(data){
															console.log(data.rs);
													}
												});
												postFacebook('Thư Từ Tương Lai',quote,message,'{!!route("frontend.BaivietDetail",Session::get("id_hocvien"))!!}')
											}
										});
									element.hide();
								}
							});
						} else if (response.status === 'not_authorized') {
							alert('Bạn cần cấp quyền cho ứng dụng Letter From Future!');
							$('.overlay-bg').fadeOut();
							FB.login(function(response){
								FB.api('me/picture?type=large',function(response){
									var img = response.data.url;
									$.ajax({
										url: '{!!route("frontend.AjaxImg")!!}',
										type: 'POST',
										data: {img: img, _token:$("meta[name='csrf-token']").attr("content")},
										success:function(data){
											if(data.rs = 'ok'){
												console.log('IMG upload OK');
											}
										}
									})
								});
								$.ajax({
									url:'{!!route("frontend.ajaxLetter")!!}',
									type:'POST',
									data:{from:from,message:message,quote:quote, _token:$("meta[name='csrf-token']").attr("content")},
									success:function(data){
										// console.log(data.rs);
										$('#preview').html(data.rs);

										/*RENDER IMAGE*/
										var element = $('#preview');
										element.show();
										html2canvas(element, {
													onrendered: function (canvas) {
														var dataimg = canvas.toDataURL("image/png");
														try {
																blob = dataURItoBlob(dataimg);
														} catch (e) {
																console.log(e);
														}
														$.ajax({
															url: '{!!route("frontend.AjaxGetImg")!!}',
															type:'POST',
															data: {img:dataimg,  _token:$("meta[name='csrf-token']").attr("content")},
															success:function(data){
																if(data.rs = 'ok'){
																	console.log('IMG upload OK');
																}
															}
														});
														postFacebook('Thư Từ Tương Lai',quote,message,'{!!route("frontend.BaivietDetail",Session::get("id_hocvien"))!!}')
													}
											});
											element.hide();
										}
									});
								},{scope: "email"});
						} else {
							FB.login(function(response){
								FB.api('me/picture?type=large',function(response){
									var img = response.data.url;
									$.ajax({
										url: '{!!route("frontend.AjaxImg")!!}',
										type: 'POST',
										data: {img: img, _token:$("meta[name='csrf-token']").attr("content")},
										success:function(data){
											console.log(data.rs)
										}
									})
								});
								$.ajax({
									url:'{!!route("frontend.ajaxLetter")!!}',
									type:'POST',
									data:{from:from,message:message,quote:quote, _token:$("meta[name='csrf-token']").attr("content")},
									success:function(data){
										// console.log(data.rs);
										$('#preview').html(data.rs);

										/*RENDER IMAGE*/
										var element = $('#preview');
										element.show();
										html2canvas(element, {
											onrendered: function (canvas) {
												var dataimg = canvas.toDataURL("image/png");
												try {
														blob = dataURItoBlob(dataimg);
												} catch (e) {
														console.log(e);
												}
													$.ajax({
														url: '{!!route("frontend.AjaxGetImg")!!}',
														type:'POST',
														data: {img:dataimg,  _token:$("meta[name='csrf-token']").attr("content")},
														success:function(data){
															if(data.rs = 'ok'){
																console.log('IMG upload OK');
															}
														}
													});
													postFacebook('Thư Từ Tương Lai',quote,message,'{!!route("frontend.BaivietDetail",Session::get("id_hocvien"))!!}')
												}
											});
											element.hide();
										},
									});

							},{scope: "email"});
						}
					});
				}
			})
		});
	</script>


@stop

@section('content')

<div class="overlay-bg	"></div>
@include('Frontend::layouts.header02')
<div class="section letter">
		<div class="container">
			<div class="row">
				<div class="inner-letter clearfix">
					<form action="" method="POST" class="form-letter">
						{!!Form::token()!!}
						<div class="left-letter">
							<div class="wrap-content-left">
								<div class="wrap-top">
									<p class="normal-text"><label for="from">From: </label><input type="text" name="from" class="input-letter from-input" disabled="disabled" value="{!!$data->name!!} 2030"></p>
									<p class="normal-text"><label for="to">To: </label><input type="text" name="to" class="input-letter to-input" disabled="disabled" value="{!!$data->name!!} 2017"></p>
								</div>
								<div class="wrap-bottom">
									<div id="validate-content"></div>
									<textarea name="content" class="content-input"></textarea>
								</div>

								<div class="count-area"></div>

								<div class="signature">
									<p class="normal-text">Sincerely</p>
									<p class="normal-text"><b>{!!$data->name!!} 2030</b></p>
								</div>
							</div>
						</div>
						<div class="right-letter">
							<div class="top-right">
								<div class="wrap-quote">
									<p class="note-quote">Câu trích dẫn <i>(Sẽ được hiển thị trong phần chia sẻ trên Facebook)</i></p>
									<div class="wrap-quote-textarea">
										<div id="validate-quote"></div>
										<textarea name="quote" class="quote-input"></textarea>
									</div>
								</div>
							</div>
							<div class="bottom-right">
								<!-- <a href="{!!route('homepage')!!}" class="btn-home">Trang Chủ</a> -->
								<button class="btn-submit" type="submit">Nộp bài & chia sẻ</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>	<!-- end letter -->
	<div id="preview"></div>
@stop
