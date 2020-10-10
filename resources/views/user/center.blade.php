<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h2>个人中心</h2>

{{$_COOKIE['user_name']}},欢迎您回来
<a href="{{url('/user/quit')}}">退出</a>
</body>

</html>