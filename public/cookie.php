<?php
	$cookie = "token";
	$str_key = uniqid(rand());
	$value = substr(md5($str_key), 0, 20);
	// $value = rand(0000,9999);
	setcookie($cookie,$value,time()+3600*30);