@extends('Admin::layouts.layout')

@section('content')
  <section class="content-header">
    <h1>Student Letter</h1>
  </section>
  <section class="content">
  	<div class="box">
  		<div class="container-fluid">
  			{!!Form::model($student,array('route'=>array('admin.student.update',$student->id) ,'method'=>'PUT','class'=>'formAdmin form-horizontal','files'=>true))!!}
          <input type="hidden" name="diem" value="">
          <div class="row">
            <div class="col-sm-7">
                <h3 class="name">{!!$student->name!!}</h3>
                <h4 class="form-group">{!!$student->letter_quote!!}</h4>
                <div class="wrap-letter">
                  <p>{!!$student->letter_content!!}</p>
                </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                  <img src="{!!$student->fb_img!!}" class="img-responsive" alt="">
              </div>
              <div class="form-group">
                <div id="jRate"></div>
                <div id="onset-value">

                </div>
              </div>
            </div>
          </div>
  			{!!Form::close()!!}
  		</div>
  	</div>
  </section>
@stop

@section('script')
  {!!Html::script(asset('public/assets/backend').'/js/jrate/jRate.min.js')!!}
  <script type="text/javascript">
    $(document).ready(function(){
      $('#jRate').jRate({
        rating:1,
        count: 5,
        onSet: function(rating){
          $('#demo-onset-value').text("Selected Rating: "+rating);
          $('input[name="diem"]').val(rating);
        }
      })
    })
  </script>
@stop
