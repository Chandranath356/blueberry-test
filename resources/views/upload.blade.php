<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	@if(Auth::check())
	<a href="/logout">Logout</a>
	<a href="{{route('customer.export')}}">Export</a>
	<a href="/uploads/blueberry.csv" download>Sample File</a>
	<form action="{{route('customer.import')}}" method="post" enctype="multipart/form-data" style="margin-top:65px;">
		@csrf
		<input type="file" name="file" required>
		@if($errors->has('file'))
    		<div class="error">{{ $errors->first('file') }}</div>
		@endif
		<div style="margin-top:20px;">
		<input type="submit" name="" value="File Upload">
		</div>
	</form>
	@else
	<a href="google/login">Login With Google</a>
	@endif
</body>
</html>