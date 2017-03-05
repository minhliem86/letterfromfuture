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
	})
</script>
@stop

@section('content')
@include('Frontend::layouts.header')
<div class="banner">
	<div class="container">
		<div class="row">
			<div class="inner-banner">
				<img src="{!!asset('public/assets/frontend')!!}/images/banner.png" class="img-responsive" alt="Thư gửi từ tương lai">

			</div> <!-- end inner-banner-->
		</div>
	</div>
</div>	<!-- end banner -->

<div class="section context" id="context">
	<div class="container">
		<div class="row">
			<div class="inner-context">
				<h1 class="title01">Cuộc thi viết tiếng Anh hào hứng nhất trong năm<span class="year">"Thư gửi từ tương lai"</span></h1>

				<p class="des-context">Hãy tưởng tượng bạn đang ở năm 2030, bạn đang ở đâu, đang làm gì, đã thay đổi như thế nào, đã có mơ ước nào được thành hiện thực chưa? Hãy viết một bức thư bằng tiếng Anh mô tả bạn ở 2030 và gửi đến cho chính mình ở năm 2017 nhé, nếu được, gửi thêm cho bản thân những lời khuyên chân thành nhất nữa.</p>
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
										<li>Hạn chót tham gia: 31/03/2017</li>
										<li>Ngày thông báo kết quả: 10/04/2017</li>
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

<div class="section top50" id="top50">
	<div class="container">
		<div class="row">
			<div class="inner-top50">
				<h2 class="title-section">Top 50</h2>
				@if(count($top50))
				<div class="wrap-content-top50 clearfix">
					<div class="left-top50">
						<div class="grid">
							<figure class="effect">
								<img src="{!!$top50->fb_img!!}" class="img-responsive" alt="">
								<figcaption>
									<h2>{!!$top50->name!!}</h2>

									<a href="{!!route('frontend.BaivietDetail',$top50->id)!!}" class="show-detail">Xem bài viết</a>
								</figcaption>
							</figure>
						</div>
					</div>

					<div class="right-top50 clearfix">
						@if($top4)
						@foreach($top4 as $item_top4)
						<div class="item-top50">
							<div class="grid">
								<figure class="effect">
									<img src="{!!$item_top4->fb_img!!}" class="img-responsive" alt="">
									<figcaption>
										<h2>{!!$item_top4->name!!}</h2>

										<a href="{!!route('frontend.BaivietDetail',$item_top4->id)!!}" class="show-detail">Xem bài viết</a>
									</figcaption>
								</figure>
							</div>
						</div>
						@endforeach
						@endif
					</div>	<!-- end right-top 50 -->
				</div>
				<div class="wrap-more-content top50-more">
					<div class="wrap-each-item-top50 clearfix">

						<div class="wrap-button wrap-top50-btn">
								<a href="#" id="showmore-top50" class="btn-me btn-showmore" data-id="{!!$data_id_current!!}">Xem thêm</a>
						</div>
					</div>

				</div>
				@else
					<h4 class="update"> Thông tin cuộc thi đang được cập nhật</h4>
				@endif
			</div>	<!-- end inner top 50 -->
		</div>
	</div>
</div>	<!-- end top50 -->

<div class="section baiduthi" id="baiduthi">
	<div class="container">
		<div class="row">
			<div class="inner-baiduthi">
				<h2 class="title-section">Bài dự thi</h2>
				@if(!$top_baiduthi->isEmpty())
				<div class="wrap-bai-thi clearfix">
					@foreach($top_baiduthi as $item_top)
					<div class="each-baiduthi">
						<div class="wrap-bai">
							<h3 class="name">{!!$item_top->name!!}</h3>
							<a href="{!!route('frontend.BaivietDetail',$item_top->id)!!}"><img src="{!!$item_top->fb_img!!}" class="img-responsive" alt=""></a>
							<div class="overlay">

								<p class="des"><a href="{!!route('frontend.BaivietDetail',$item_top->id)!!}">“{!!$item_top->letter_quote!!}”</a></p>
								<a href="{!!route('frontend.BaivietDetail',$item_top->id)!!}" class="xemthem">Xem thêm</a>
							</div>
						</div>
					</div>
					@endforeach
					<div class="wrap-more-content baithi-more">
						<a href="#" id="xemthem_baiduthi" class="btn-me btn-showmore" data-date="{!!$latest_item->updated_at!!}">Xem thêm</a>
					</div>
				</div>
				@else
					<h4 class="update"> Thông tin cuộc thi đang được cập nhật</h4>
				@endif
			</div>	<!-- end inner-baiduthi-->
		</div>
	</div>
</div>	<!-- end baiduthi -->

@stop
