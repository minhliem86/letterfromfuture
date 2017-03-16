@extends('Admin::layouts.layout')

@section('script')
  {!!Html::script(asset('public/assets/backend').'/js/jrate/jRate.min.js')!!}
  {!!Html::script(asset('public/assets/backend').'/js/matchHeight.js')!!}
  <script>
    $(document).ready(function(){
      $('.each-letter').matchHeight()
    })
  </script>
@stop

@section('css')
  	{!!Html::style('public/assets/backend/css/customize_student.css')!!}
@stop

@section('content')
<!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Letters
        <small>Analytic</small>
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      @if(!$top50->isEmpty())
      <div class="wrap-top50">
        <div class="container-fluid">
          <div class="row">
            @foreach($top50 as $item)
            <div class="col-lg-2 col-sm-3">
              <div class="each-letter">
                <div class="wrap-img">
                    <img src="{!!$item->fb_img!!}" class="img-responsive" alt="{!!$item->name!!}">
                </div>
                <h4 class="name">{!!$item->name!!}</h4>
                <div class="diem" id="diem-{!!$item->id!!}"></div>
                <script type="text/javascript">
                  $('#diem-{!!$item->id!!}').jRate({
                    readOnly: true,
                    rating:{!!$item->vote!!}
                  })
                </script>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>  <!-- end top 50 -->
      @endif
      <div class="wrap-pagination">
        {!!$top50->render()!!}
      </div>
      <!-- Your Page Content Here -->

    </section>
    <!-- /.content -->

  <!-- /.content-wrapper -->
@stop
