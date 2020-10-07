<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="{{url('/index/update/'.$res->id)}}" method = 'post'>

		<table>
			<tr>
				<td>名称</td>
				<td><input type="text" name="name" value="{{$res->name}}"></td>
			</tr>
			<tr>
				<td>密码</td>
				<td><input type="password" name="pwd" value = "{{$res->pwd}}"></td>
			</tr>
			<tr>
				<td><input type="submit" value="修改"></td>
				<td></td>
			</tr>
		</table>
	</form>
</body>
</html>