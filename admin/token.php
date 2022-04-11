<?php
require("mysql.php");

// 获取用户传值
$token = $_POST["token"];
// 没有携带 token 访问
if (strlen($token) != 28) {
	die("没有权限访问");
}

// 寻找是否存在此 token, 返回时间
$sql = "select times from admins where token = '$token'";
$result = $conn->doQuery($sql);
$times_old = $result[0]["times"];
// 如果没有找到该 token 
if (strlen($times_old) == 0) {
	die("没有权限访问");
}

$times_now = time();
$sql = "select g_value from globals where g_ident = 'admin_time'";
$result = $conn->doQuery($sql);
$times = $result[0]["g_value"];
// 登录过期
if ((intval($times_now) - intval($times_old)) > intval($times)) {
	die("登录过期, 请重新登录");
}

?>
