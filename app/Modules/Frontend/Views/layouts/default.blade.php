<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{!! csrf_token() !!}">

	<link rel="stylesheet" href="{!!asset('public/assets/frontend')!!}/css/bootstrap-me_min.css">
	<link rel="stylesheet" href="{!!asset('public/assets/frontend')!!}/css/animate.css">
	<link rel="stylesheet" href="{!!asset('public/assets/frontend')!!}/css/font-awesome.min.css">
	<link rel="stylesheet" href="{!!asset('public/assets/frontend')!!}/css/style.css">

	<title>@yield('title','Letter From Future')</title>
</head>
<body>
	<div class="bg">
		@yield('content')
		
		@include('Frontend::layouts.footer')
	</div>

	<script src="{!!asset('public/assets/frontend')!!}/js/jquery-2.1.1.js"></script>
	<script src="{!!asset('public/assets/frontend')!!}/js/bootstrap.min.js"></script>
	<script src="{!!asset('public/assets/frontend')!!}/js/jquery.sticky.js"></script>
	<!-- RESOLUTION -->
	<link rel="stylesheet" href="{!!asset('public/assets/frontend')!!}/js/revolution/css/settings.css">
	<script src="{!!asset('public/assets/frontend')!!}/js/revolution/jquery.themepunch.plugins.min.js"></script>
	<script src="{!!asset('public/assets/frontend')!!}/js/revolution/jquery.themepunch.revolution.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			var w_window = $(window).width();

			if(w_window < 850){
				h_nav = 0;
			}else{
				h_nav = $('.header').height();
			}
			/*ACTIVE MENU*/

			$('ul.ul-navbar li').click(function(){
				var h_nav;
				$('ul.ul-navbar li').removeClass('active');
				$(this).addClass('active')
				if(w_window < 850){
					h_nav = 0;
				}else{
					h_nav = $('.header').height();
				}
				var target = $(this).attr('anchor');

				 $('html, body').animate({
			        scrollTop: $(target).offset().top - h_nav}, 1200);
			})
			/*STICKY MENU*/
			var sticky = $('.header').sticky({
				topSpacing:0,
				zIndex:9999999,
			})
			sticky.on('sticky-start',function(){
				$('.header').addClass('havecolor');
			});
			sticky.on('sticky-end',function(){
				$('.header').removeClass('havecolor');
			});
			if(w_window < 850) sticky.unstick();

			/*SLIDER BANER*/
			$('.banner-container').revolution({
				delay:6000,
                startheight:366,
                startwidth:1170,
                navigationArrows :'none',
                onHoverStop : 0,
                navigationType : 'none'

			})
		})
	</script>
	@yield('script')
</body>
</html>
