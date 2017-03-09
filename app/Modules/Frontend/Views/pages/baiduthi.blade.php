@extends('Frontend::layouts.default')

@section('script')
<link rel="stylesheet" href="{!!asset('public/assets/frontend')!!}/js/swiper/css/swiper.min.css">
<script type="text/javascript" src="{!!asset('public/assets/frontend')!!}/js/swiper/js/swiper.min.js"></script>
	<script>
		$(document).ready(function(){
			// SWIPER TOP 50
      var swiper50 = new Swiper ('#swiper-top50',{
        slidesPerView: 3,
        spaceBetween:5,
        slidesPerColumn: 2,
        autoplay:1500,
        speed:1000,
        preventClicks: false,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
      });
      $('#swiper-top50').hover(function(){
        swiper50.stopAutoplay();
      },function(){
        swiper50.startAutoplay();
      })
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
						// console.log(data.rs);
					}
				})
			})
		})
	</script>
@stop
@section('content')

@include('Frontend::layouts.header02')
<div class="section top50">
   <div class="container">
     <div class="row">
       <div class="inner-top50">
        <h2 class="title-section">Bài Viết mới nhất</h2>
        <div class="container-fluid">
          <div class="row">
						@if($data_baimoinhat)
            <div class="col-md-5">
							@if($data_baimoinhat)
              <div class="lastest-post">
                <!-- <div class="grid">
                  <figure class="effect">
                    <img src="{!!$data_baimoinhat->fb_img!!}" class="img-responsive" alt="">
                    <figcaption>
                      <h2>{!!$data_baimoinhat->name!!}</h2>
                      <a href="{!!route('frontend.BaivietDetail',$data_baimoinhat->id)!!}" class="show-detail">Xem bài viết</a>
                    </figcaption>
                  </figure>
                </div> -->
								<a href="{!!route('frontend.BaivietDetail',$data_baimoinhat->id)!!}">
									<img src="{!!$data_baimoinhat->fb_img!!}" class="img-responsive" alt="">
									<h2>{!!$data_baimoinhat->name!!}</h2>
								</a>

              </div>
							@endif
            </div>
						@if($data_listbaimoi)
            <div class="col-md-7">
              <div class="container-slider-top50">
                <div class="swiper-container" id="swiper-top50">
                  <div class="swiper-wrapper">
										@foreach($data_listbaimoi as $item)
                    <div class="swiper-slide">
                      <div class="item-top50">
                        <!-- <div class="grid">
                          <figure class="effect">
                            <img src="{!!$item->fb_img!!}" class="img-responsive" alt="">
                            <figcaption>
                              <h2>{!!$item->name!!}</h2>
                              <a href="{!!route('frontend.BaivietDetail',$item->id)!!}" class="show-detail">Xem bài viết</a>
                            </figcaption>
                          </figure>
                        </div> -->
												<a href="{!!route('frontend.BaivietDetail',$item->id)!!}">
													<img src="{!!$item->fb_img!!}" class="img-square img-top img-responsive" alt="">
													<h2>{!!$item->name!!}</h2>
												</a>

                      </div>
                    </div>
										@endforeach
                  </div>

                </div>
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
              </div>
            </div>
						@endif
						@else
							<div class="col-md-12">
								  <h4 class="update"> Thông tin cuộc thi đang được cập nhật</h4>
							</div>
						@endif
          </div>
        </div>
       </div>
     </div>
   </div>
</div>  <!-- end top 50 -->


<div class="section baiduthi">
  <div class="container">
    <div class="row">
      <div class="inner-baiduthi">
        <div class="container-fluid">
          <h2 class="title-section">Bài dự thi</h2>
					@if(!$top_baiduthi->isEmpty())
          <div class="wrap-bai-thi clearfix">
						@foreach($top_baiduthi as $item_rand)
            <div class="each-baiduthi">
              <div class="wrap-bai">

                <a href="{!!route('frontend.BaivietDetail',$item_rand->id)!!}">
									<img src="{!!$item_rand->fb_img!!}" class="img-responsive" alt="">
									<h3 class="name">{!!$item_rand->name!!}</h3>
								</a>
                <div class="overlay">

                  <p class="des"><a href="{!!route('frontend.BaivietDetail',$item_rand->id)!!}">{!!Illuminate\Support\Str::words($item_rand->letter_quote,20)!!}</a></p>
                  <a href="{!!route('frontend.BaivietDetail',$item_rand->id)!!}" class="xemthem">Xem thêm</a>
                </div>

              </div>
            </div>
						@endforeach

            <div class="wrap-more-content baithi-more">
              <a href="#" id="xemthem_baiduthi" class="btn-me btn-showmore" data-date="{!!$data_arr_baiduthi!!}">Xem thêm</a>
            </div>
          </div>
					@else
          <h4 class="update"> Thông tin cuộc thi đang được cập nhật</h4>
					@endif
        </div>

      </div>
    </div>
  </div>
</div>

@stop
