@extends('Frontend::layouts.default')

@section('meta')
	<meta property="og:image" content="{!!$baiviet->img_upload!!}">
@stop

@section('script')
	<script type="text/javascript" src="{!!asset('public/assets/frontend')!!}/js/jquery.nicescroll.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.wrap-content .content').niceScroll();
		})
	</script>
@stop

@section('content')
@include('Frontend::layouts.header02')
<div class="section detail">
			<div class="container">
				<div class="row">
					<div class="inner-detail">
						<div class="wrap-detail clearfix">
							<div class="left-detail">
								<img src="{!!$baiviet->fb_img!!}" class="img-responsive img-author" alt="">
								<h2 class="author">{!!$baiviet->name!!}</h2>
							</div>
							<div class="right-detail">
								<div class="wrap-content">
									<h4 class="quote-text">{!!$baiviet->letter_quote!!}</h4>
									<div class="content">
										<p>{!!$baiviet->letter_content!!}</p>

									</div>
									<div class="wrap-social">
										<a href="{!!$baiviet->fb_link!!}" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
									</div>

								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@stop
