@extends('Frontend::layouts.default')

@section('script')
<script type="text/javascript" src="{!!asset('public/assets/frontend')!!}/js/jquery.nicescroll.min.js"></script>
<script>

	$(document).ready(function(){
		$('.wrap-each-item-top50').niceScroll();

		// SHOW MORE BAI THI
		$(document).on('click','#xemthem_baiduthi',function(e){
			e.preventDefault();
			var $btn = $(this);
			var date = $btn.data('date');
			$.ajax({
				"url":"{!!route('frontend.ajaxShowmoreBaiThi')!!}",
				"type": "POST",
				"data": {date:date, _token:$('meta[name="csrf-token"]').attr('content')},
				beforeSend:function(data){
					$btn.html('Loading Please Wait...');
				},
				success:function(data){
					$btn.html('Xem thêm');
					// console.log(data.rs);
					$('.baithi-more').remove();
					$('.wrap-bai-thi').append(data.rs);
				}
			})
		})
		// SHOW MORE TOP 50
		$(document).on('click','#showmore-top50',function(e){
			e.preventDefault();
			var $btn = $(this);
			var id = $btn.data('id');
			$.ajax({
				"url":"{!!route('frontend.ajaxShowmoreTop50')!!}",
				"type": "POST",
				"data": {arr:id, _token:$('meta[name="csrf-token"]').attr('content')},
				beforeSend:function(data){
					$btn.html('Loading Please Wait...');
				},
				success:function(data){
					$btn.html('Xem thêm');
					// console.log(data.rs);
					$('.wrap-top50-btn').remove();
					$('.wrap-each-item-top50').append(data.rs);
				}
			})
		})

		@if(Session::has('section'))
			$('html, body').animate({
				scrollTop:$('#{!!Session::get("section")!!}').offset().top - h_nav
			},2000)
		@endif
	})
</script>
@stop

@section('content')
@include('Frontend::layouts.header')
<div class="banner">
	<div class="container">
		<div class="row">
			<div class="inner-banner">
				<div class="banner-container">
					<ul>
						<li data-transition="boxslide" data-slotamount="7">
							<img src="{!!asset('public/assets/frontend')!!}/images/banner.png" class="img-responsive" alt="Letter for future">
							<div class="caption sfl hidden-sm hidden-xs" id="caption1"  data-x="760" data-y="100" data-speed="500" data-start="1900" data-easing="easeOutBack">
								<div class="wrap-caption-content">
									<p class="normal-text">
										Cuộc thi viết tiếng Anh hào hứng nhất trong năm
										<span class="title-banner">"2020 TO 2017"</span>
									</p>
								</div>
							</div>
						</li>

						<li data-transition="slotslide-vertical" data-slotamount="7">
							<img src="{!!asset('public/assets/frontend')!!}/images/banner.png" class="img-responsive" alt="Letter for future">
							<div class="caption sfl" id="caption1"  data-x="760" data-y="100" data-speed="500" data-start="1900" data-easing="easeOutBack">
								<div class="wrap-caption-content">
									<p class="normal-text">
										Cuộc thi viết tiếng Anh hào hứng nhất trong năm
										<span class="title-banner">"2020 TO 2017"</span>
									</p>
								</div>
							</div>
						</li>

					</ul>
				</div>

			</div> <!-- end inner-banner-->
		</div>
	</div>
</div>	<!-- end banner -->

<div class="section context" id="context">
	<div class="container">
		<div class="row">
			<div class="inner-context">
				<h1 class="title01">Cuộc thi viết tiếng Anh hào hứng nhất trong năm<span class="year">"2020 TO 2017"</span></h1>

				<p class="des-context">Hãy tưởng tượng bạn đang ở năm 2020, bạn đang ở đâu, đang làm gì, đã thay đổi như thế nào, đã có mơ ước nào được thành hiện thực chưa? Hãy viết một bức thư bằng tiếng Anh mô tả bạn ở 2020 và gửi đến cho chính mình ở năm 2017 nhé, nếu được, gửi thêm cho bản thân những lời khuyên chân thành nhất nữa.</p>
				<p class="des-context">Chủ đề thật thú vị phải không nào? Hãy click “Tham gia” và bắt tay vào viết ngay thôi, vì phần thưởng vô cùng hấp dẫn đấy!</p>
			</div>	<!-- end inner-context-->
		</div>
	</div>
</div>	<!-- end context-->

<div class="section term" id="term">
	<div class="container">
		<div class="row">
			<div class="inner-term">
				<h2 class="title-section">Thể Lệ</h2>
				<div class="content-term">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-4">
								<div class="each-term term01">
									<ul class="list-term list-01">
										<li>Cuộc thi dành riêng cho học viên <span class="align">Super Juniors và Smart Teens của ILA.</span></li>
										<li>Bức thư viết bằng tiếng Anh.</li>
										<li>Độ dài: tối đa 200 chữ.</li>
										<li>Hạn chót tham gia: 10/03/2017</li>
										<li>Ngày thông báo kết quả: 15/03/2017</li>
									</ul>
								</div> <!-- end each term-->
							</div>
							<div class="col-sm-4">
								<div class="each-term term02">
									<h3 class="title-term">Tiêu chí chấm giải:</h3>
									<ul class="list-term list-02">
										<li>Viết đúng yêu cầu chủ đề.</li>
										<li>Sử dụng từ vựng hợp lý.</li>
										<li>Sử dụng ngữ pháp chính xác.</li>
										<li>Sự sáng tạo.</li>
									</ul>
								</div> <!-- end each term-->
							</div>
							<div class="col-sm-4">
								<div class="each-term term03">
									<h3 class="title-term">Giải thưởng:</h3>
									<ul class="list-term list-03">
										<li>10 học bổng ILA Summer trị giá 5,000,000VND dành cho Top 10 bức thư hay nhất</li>
										<li>50 bộ quà ILA Giftset độc đáo dành cho Top 50 bức thư hay nhất</li>

									</ul>
								</div> <!-- end each term-->
							</div>
						</div>
					</div>
				</div>	<!-- end content-term -->
				<div class="wrap-btn">
					<a href="{!!route('frontend.getLogin')!!}" class="btn-dk btn-me">đăng ký Dự thi</a>
				</div>	<!-- end wrap-btn -->
			</div>
		</div>
	</div>
</div>	<!-- end term -->

@stop
