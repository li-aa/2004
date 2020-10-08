<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="{{url('/user/logindo')}}" method = 'post'>

		<table>
			<tr>
				<td>名称</td>
				<td>
					<input type="text" name="user_name">
					<b style="color:red">{{$errors->first('user_name')}}</b>
				</td>
			</tr>
			<tr>
				<td>密码</td>
				<td>
					<input type="password" name="password">
					<b style="color:red">{{$errors->first('password')}}</b>
				</td>
			</tr>
			<tr>
				<td><input type="submit" value="登录"></td>
				<td></td>
			</tr>
		</table>
	</form>
</body>
</html>