<?php
require("mysql.php");

// 获取用户传值
$token = $_POST["token"];
// 没有携带 token 访问
if (strlen($token) != 28) {
	die("1.没有权限访问");
}

// 寻找是否存在此 token, 返回时间
$sql = "select g_value from globals where g_ident = 'token'";
$result = $conn->doQuery($sql);
$token_s = $result[0]["g_value"];
// 如果没有找到该 token 
if ($token != $token_s) {
	die("2.没有权限访问");
}

$times_now = time();
$sql = "select g_value from globals where g_ident = 'stime'";
$result = $conn->doQuery($sql);
$times_old = $result[0]["g_value"];
$sql = "select g_value from globals where g_ident = 'times'";
$result = $conn->doQuery($sql);
$times = $result[0]["g_value"];

// 登录过期
if ((intval($times_now) - intval($times_old)) > intval($times)) {
	die("3.登录过期, 请重新登录");
}

?>
