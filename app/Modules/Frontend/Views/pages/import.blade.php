<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Import Data</title>
</head>
<body>
	<div class="wrap">
		<form action="{!!route('postImportdata')!!}" method="POST" enctype="multipart/form-data">
			{!!Form::token()!!}
			<div>
				<input type="file" name="file">
			</div>
			<div>
				<input type="submit" value="Import File">
			</div>
		</form>
	</div>
</body>
</html>