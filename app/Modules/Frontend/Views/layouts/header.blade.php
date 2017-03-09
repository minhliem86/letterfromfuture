		<div class="header">
			<div class="container">
				<div class="row">
					<div class="inner-header clearfix">
						<div class="navbar-header">
							<a href="{!!route('homepage')!!}" class="logo"><img src="{!!asset('public/assets/frontend')!!}/images/logo.png" class="img-responsive" alt="ILA"></a>
							<button type="button" class="navbar-toggle collapsed visible-sm visible-xs visible-ms" data-toggle="collapse" data-target="#main-navbar" aria-expanded="false">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="collapse navbar-collapse" id="main-navbar">
							<ul class="ul-navbar">
								<li anchor="#context"><a href="javascript:avoid()">Cuộc thi</a></li>
								<li anchor="#term"><a href="javascript:avoid()">Thể lệ</a></li>
								<li><a href="{!!route('frontend.getBaivietDuThi')!!}" >Bài Dự Thi</a></li>
								<li ><a href="{!!route('frontend.getDangnhaphocvien')!!}" >Bài viết của tôi</a></li>
							</ul>
						</div>
					</div> <!-- end inner-header-->
				</div>
			</div>
		</div> <!-- end header -->
