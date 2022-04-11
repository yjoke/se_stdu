<?php
require("mysql.php");

// 获取数据
$admin_id = $_POST["username"];
$password = $_POST["password"];

$r = '{';

$sql = "select password from admins where admin_id = '$admin_id'";
$result = $conn->doQuery($sql);
$password = md5($password);
if ($result[0]["password"] && $result[0]["password"] == $password)
{
	// 获取数据
	$times = time();
	$token = "";
	$str = "!#$%&()*+,-.0123456789:;=?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_`abcdefghijklmnopqrstuvwxyz{|}";
	for ($i = 0; $i <28; $i++)
		$token .= $str[rand(0, 86)];
	// 存入数据库
	$sql = "update admins set token = '$token', times = '$times' where admin_id = '$admin_id'";
	if ($conn->doUpdate($sql)) {
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
