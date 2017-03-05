@extends('Admin::layouts.layout')

@section('content')
<section class="content-header">
  <h1>Create USER</h1>
</section>
<section class="content">

	<div class="box">
    <div class="register-box">
  		<div class="register-box-body">
  			<p class="login-box-msg">Register a new membership</p>
  			@include('Admin::errors.listerror')
  			{!! Form::open(array('route'=>'admin.postCreateUser', 'class'=>'form-register')) !!}
  				<div class="form-group has-feedback">
  					{!!Form::text('name',old('name'), array('class'=>'form-control', 'placeholder'=>'Fullname'))!!}
  					<span class="glyphicon glyphicon-user form-control-feedback"></span>
  				</div>
  				<div class="form-group has-feedback">
  					<input type="email" class="form-control" placeholder="Email (*)" name="email" value="{!!old('email')!!}">
  					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
  				</div>
  				<div class="form-group has-feedback">
  					<input type="password" class="form-control" placeholder="Password (*)" name="password">
  					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
  				</div>
  				<div class="form-group has-feedback">
  					<input type="password" class="form-control" placeholder="Retype password (*)" name="password_confirmation">
  					<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
  				</div>
  				<div class="form-group">
  					<input type="radio" name="role" value="admin" id="admin"> <label for="admin">Admin</label>
  					<input type="radio" name="role" value="teacher" id="teacher"> <label for="teacher">Teacher</label>
  				</div>
  				<div class="row">
  					<!-- <div class="col-xs-8">
  						<div class="checkbox icheck">
  							<label>
  								<input type="checkbox" name="agree"> Tôi chấp nhận sử dụng dịch vụ
  							</label>
  						</div>
  					</div> -->
  					<!-- /.col -->
  					<div class="col-xs-12">
  						<button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
  					</div>
  					<!-- /.col -->
  				</div>
  			{!! Form::close()!!}
  			<!-- <div class="social-auth-links text-center">
  				<p>- OR -</p>
  				<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
  				Facebook</a>
  				<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
  				Google+</a>
  			</div>
  			<a href="login.html" class="text-center">I already have a membership</a> -->
  		</div>
  		<!-- /.form-box -->
  	</div>
	</div>
</section>
@stop

@section('script')
{!!Html::script('public/assets/backend/plugins/iCheck/icheck.min.js')!!}
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '5%' // optional
    });
  });
</script>
@stop
