@if(!$more_baiviet->isEmpty())
  @foreach($more_baiviet as $item_more)
  <div class="each-baiduthi">
    <div class="wrap-bai">

      <!-- <a href="#"><img src="{!!asset('public/assets/frontend')!!}/images/img02.png" class="img-responsive" alt=""></a> -->
      <a href="#">
        <img src="{!!$item_more->fb_img!!}" class="img-responsive" alt="">
          <h3 class="name">{!!$item_more->name!!}</h3>
      </a>
      <div class="overlay">

        <p class="des"><a href="#">“{!!$item_more->letter_quote!!}”</a></p>
        <a href="#" class="xemthem">Xem thêm</a>
      </div>
    </div>
  </div>
  @endforeach
<div class="wrap-more-content baithi-more">
  <a href="#" id="xemthem_baiduthi" class="btn-me btn-showmore" data-date='{!!$data_arr_id!!}'>Xem thêm</a>
</div>
@else
  <p class="note-none">Hiện chưa có bài dự thi mới</p>
@endif
