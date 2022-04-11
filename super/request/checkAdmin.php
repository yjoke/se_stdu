<?php
require("mysql.php");

// 获取数据
$super_id = $_POST["username"];
$password = $_POST["password"];
$password = md5($password);

$r = '{';

$sql = "select g_value from globals where g_ident = 'super_id'";
$result = $conn->doQuery($sql);
$id = $result[0]["g_value"];
$sql = "select g_value from globals where g_ident = 'super_pw'";
$result = $conn->doQuery($sql);
$pw = $result[0]["g_value"];


if ($super_id && $password && $super_id == $id && $password == $pw)
{
	// 获取数据
	$times = time();
	$token = "";
	$str = "!#$%&()*+,-.0123456789:;=?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_`abcdefghijklmnopqrstuvwxyz{|}";
	for ($i = 0; $i <28; $i++)
		$token .= $str[rand(0, 86)];
	// 存入数据库
	$sql1 = "update globals set g_value = '$token' where g_ident = 'token'";
	$sql2 = "update globals set g_value = '$times' where g_ident = 'stime'";
	if ($conn->doUpdate($sql1) && $conn->doUpdate($sql2)) {
		$r .= '"flag": "1"';
		$r .= ', "token": "'.$token.'"';  // 登录成功
	} else {
		$r .= '"flag": "2"';  // 登录过于频繁
	}
} else {
	$r .= '"flag": "0"';  // 账号或密码错误
}
$r .= "}";
json_decode($r);
echo $r;

?>
