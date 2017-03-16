@extends('Admin::layouts.layout')

@section('css')
  	{!!Html::style('public/assets/backend/css/customize_student.css')!!}
@stop

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
                <div class="clearfix">
                  <img src="{!!$student->fb_img!!}" class="img-responsive img-avatar" alt="">
                  <div class="wrap-title">
                    <h3 class="name"><span>Student name:</span> {!!$student->name!!}</h3>
                    <h4 class="title"><span>Quote:</span> {!!$student->letter_quote!!}</h4>
                  </div>
                </div>

                <div class="wrap-letter">
                  <p>{!!$student->letter_content!!}</p>
                </div>
            </div>
            <div class="col-sm-5">
              <div class="right-view">
                <div class="form-row">

                </div>
                <div class="form-row">
                  <div id="jRate"></div>
                  <div id="onset-value"></div>
                </div>
                <div class="form-row">
                  <input type="submit" name="submit" value="Save" class="btn btn-primary">
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
        precision:1,
        rating:1,
        count: 5,
        rating:{!!$student->votes()->where('user_id',Auth::user()->id)->first() ? $student->votes()->where('user_id',Auth::user()->id)->first()->diem : '0'!!},
        onSet: function(rating){
          $('#onset-value').text("You voted: "+rating+ " stars");
          $('input[name="diem"]').val(rating);
        }
      })
    })
  </script>
@stop
