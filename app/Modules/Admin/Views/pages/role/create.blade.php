<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AdminOSC | Registration Page</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta content="noindex, nofollow" name="robots">
	{!!Html::style('public/assets/backend/bootstrap/css/bootstrap.min.css')!!}

	 <!-- Font Awesome -->
	{!!Html::style('public/assets/backend/css/fontawesome/css/font-awesome.min.css')!!}

	<!-- Ionicons -->
	{!!Html::style('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')!!}
	<!-- Theme style -->
	{!!Html::style('public/assets/backend/css/AdminLTE.min.css')!!}
	<!-- iCheck -->
	{!!Html::style('public/assets/backend/plugins/iCheck/square/blue.css')!!}
</head>
<body class="hold-transition register-page">
	<div class="register-box">
		<div class="register-logo">
			<a href="{!!url('/')!!}"><b>Admin</b>LTE</a>
		</div>
		<div class="register-box-body">
			<p class="login-box-msg">Register a new membership</p>
			@include('Admin::errors.listerror')
      {!!Form::open(array('route'=>array('admin.role.store'),'class'=>'formAdmin form-horizontal','files'=>true))!!}
        <div class="form-group">
          <label for="" >Role name</label>
          {!!Form::text('name',old('name'),array('class'=>'form-control'))!!}
        </div>
        <div class="form-group">
          <label for="" >Description</label>
          {!!Form::textarea('description',old('description'),array('class'=>'form-control'))!!}
        </div>
        <div class="form-group">
          {!!Form::submit('Save',array('class'=>'btn btn-primary'))!!}
          <a href="{!!URL::previous()!!}" class="btn btn-primary">Back</a>
        </div>
      {!!Form::close()!!}

		</div>
		<!-- /.form-box -->
	</div>
	<!-- /.register-box -->
	<!-- jQuery 2.1.4 -->
	{!!Html::script('public/assets/backend/js/jQuery-2.1.4.min.js')!!}
	 <!-- CORE JQUERY SCRIPTS -->
	{!!Html::script('public/assets/backend/bootstrap/js/bootstrap.min.js')!!}
	<!-- iCheck -->
	{!!Html::script('public/assets/backend/plugins/iCheck/icheck.min.js')!!}
	<script>
		$(function () {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%' // optional
			});
		});
	</script>
</body>
</html>
