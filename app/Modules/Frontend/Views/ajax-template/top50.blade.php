@if(!$vote->isEmpty())
@foreach($vote as $item)
<div class="each-top50-more">
  <div class="grid">
    <figure class="effect">
      <!-- <img src="{!!asset('public/assets/frontend')!!}/images/img02.png" class="img-responsive" alt=""> -->
      <img src="{!!$item->fb_img!!}" class="img-responsive" alt="">
      <figcaption>
        <h2>{!!$item->name!!}</h2>

        <a href="#" class="show-detail">Xem bài viết</a>
      </figcaption>
    </figure>
  </div>
</div>	<!-- end each top 50 -->
@endforeach
<div class="wrap-button wrap-top50-btn" style="padding:3rem 0 0;">
    <a href="#" id="showmore-top50" class="btn-me btn-showmore" data-id='{!!$data_id_vote!!}' >Xem thêm</a>
</div>
@else
<p class="note-none">Các bài dự thi đang được cập nhật</p>
@endif
