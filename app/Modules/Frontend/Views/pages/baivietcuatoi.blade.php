@extends('Frontend::layouts.default')

@section('meta')
	<meta property="og:image" content="{!!$baiviet->img_upload!!}">
@stop

@section('script')
	<script type="text/javascript" src="{!!asset('public/assets/frontend')!!}/js/jquery.nicescroll.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.wrap-bottom').niceScroll();
		})
	</script>
@stop

@section('content')
@include('Frontend::layouts.header02')
<div class="section letter baiviet">
	<div class="container">
		<div class="row">
			<div class="inner-letter clearfix">
				<form action="" method="POST" class="form-letter">
					<div class="left-letter">
						<div class="wrap-content-left">
              <span class="top-right hidden-md hidden-lg">
								<img src="{!!$baiviet->fb_img!!}" class="img-responsive" alt="">
                <p class="name">{!!$baiviet->name!!}</p>
							</span>
							<div class="wrap-top">
								<p class="normal-text"><label for="from">From: </label><input type="text" name="from" class="input-letter from-input" disabled="disabled" value="{!!$baiviet->name!!} 2030"></p>
								<p class="normal-text"><label for="to">To: </label><input type="text" name="to" class="input-letter to-input" disabled="disabled" value="{!!$baiviet->name!!} 2017"></p>
							</div>
							<div class="wrap-bottom">
								<textarea name="content" class="content-input" disabled="disabled">{!!$baiviet->letter_content!!}</textarea>
							</div>
							<div class="count-area"></div>
							<div class="signature">
								<p class="normal-text">Sincerely</p>
								<p class="normal-text"><b>{!!$baiviet->name!!} 2030</b></p>
							</div>
						</div>
					</div>
					<div class="right-letter">
						<span class="top-right">
							<img src="{!!$baiviet->fb_img!!}" class="img-responsive" alt="{!!$baiviet->name!!}">
              <p class="name">{!!$baiviet->name!!}</p>
						</span>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>	<!-- end letter -->
@stop
