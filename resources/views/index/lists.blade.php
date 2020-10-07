<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<table>
		<tr>
			<td>id</td>
      		<td>名称</td>
      		<td>密码</td>
      		<td>操作</td>
		</tr>
		@foreach($res as $k=>$v)
		    <tr>
		      <td>{{$v->id}}</td>
		      <td>{{$v->name}}</td>
		      <td>{{$v->pwd}}</td> 
		      <td>  <a href="{{url('/index/delete/'.$v->id)}}">删除</a>
		            <a href="{{url('/index/edit/'.$v->id)}}">编辑</a>
		      </td> 
		    </tr>
	    @endforeach
	</table>
</body>
</html>