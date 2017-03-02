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

			$('.wrap-bottom').niceScroll();
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
		logInWithFacebook = function() {
	    FB.login(function(response) {
	      if (response.authResponse) {
	        alert('You are logged in &amp; cookie set!');
	        // Now you can redirect the user or do an AJAX request to
	        // a PHP script that grabs the signed request from the cookie.
	      } else {
	        alert('User cancelled login or did not fully authorize.');
	      }
	    });
	    return false;
	  };

		function postImageToFacebook(token, filename, mimeType, imageData, message) {
		    var fd = new FormData();
		    fd.append("access_token", token);
		    fd.append("source", imageData);
		    fd.append("no_story", true);

		    // Upload image to facebook without story(post to feed)
		    $.ajax({
		        url: "https://graph.facebook.com/me/photos?access_token=" + token,
		        type: "POST",
		        data: fd,
		        processData: false,
		        contentType: false,
		        cache: false,
		        success: function (data) {
		            // Get image source url
		            FB.api(
		                "/" + data.id + "?fields=images",
		                function (response) {
		                    if (response && !response.error) {
								FB.ui({
								  method: 'feed',
								  display: 'popup',
								  name: filename,
								  caption: 'Letter From Future',
								  description: message,
								  picture: response.images[0].source,
								  link : '{!!route("homepage")!!}',

								}, function(response){
									if(typeof response !== 'undefined'){
										console.log(response.post_id);
										var link = 'https://www.facebook.com/'+response.post_id;
										$.ajax({
											'url': '{!!route("frontend.AjaxOrder")!!}',
											'type':'POST',
											data: {link:link, _token:$("meta[name='csrf-token']").attr("content")},
											sucess:function(data){
												console.log(data.rs);
											}
										})
										 window.location = "{!!route('frontend.Done')!!}"
									}else{
										// console.log('you must share');

										alert('Để hoàn tất cuộc thi, bạn phải share bài viết của bạn trên status ở chế độ public!');
										$('.overlay-bg').fadeOut();
									}
								});
		                    }
		                }
		            );
		        }
		        // error: function (shr, status, data) {
		        //     console.log("error " + data + " Status " + shr.status);
		        // },
		        // complete: function (data) {
		        //     console.log('Post to facebook Complete');

		        //     // window.location = "{!!url('done')!!}"
		        // }
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
				}
			})
		});
	</script>


@stop

@section('content')

@include('Frontend::layouts.header02')
<div class="overlay-bg	"></div>
<div class="section letter">
		<div class="container">
			<div class="row">
				<div class="inner-letter clearfix">
					<form action="" method="POST" class="form-letter">
						{!!Form::token()!!}
						<input type="hidden" name="fb_img">
						<input type="hidden" name="fb_link">
						<div class="left-letter">
							<div class="wrap-content-left">
								<div class="wrap-top">
									<p class="normal-text"><label for="from">From: </label><input type="text" name="from" class="input-letter from-input" disabled="disabled" value="{!!$data->name!!} 2020"></p>
									<p class="normal-text"><label for="to">To: </label><input type="text" name="to" class="input-letter to-input" disabled="disabled" value="{!!$data->name!!} 2017"></p>
								</div>
								<div class="wrap-bottom">
									<div id="validate-content"></div>
									<textarea name="content" class="content-input"></textarea>
								</div>

								<div class="count-area"></div>

								<div class="signature">
									<p class="normal-text">Sincerely</p>
									<p class="normal-text"><b>{!!$data->name!!} 2020</b></p>
								</div>
							</div>
						</div>
						<div class="right-letter">
							<div class="top-right">
								<div class="wrap-quote">
									<p class="note-quote">Câu trích dẫn <i>(Sẽ được hiển thị trong phần chia sẻ trên Facebook)</i></p>
									<textarea name="quote" class="quote-input"></textarea>
								</div>
							</div>
							<div class="bottom-right">
								<a href="{!!route('homepage')!!}" class="btn-home">Trang Chủ</a>
								<button class="btn-submit" type="submit">Chia sẻ bài viết</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>	<!-- end letter -->
	<div id="preview"></div>
@stop
