<?php
require "./CDbMysql.php";

$conn = new CDbMysql();

if (!$conn->connect())
    die("error");

// if ($conn->flag())
//     echo "连接无误";
// die("程序结束");

$sql = "INSERT INTO users (user_id) VALUES ('insert')";
if ($conn->doInsert($sql))
	echo "插入成功"."<br/>";

$sql = "UPDATE users SET user_img = 'https://test.yjoker.work/upload/phone.jpg' WHERE user_id = 'insert'";
if ($conn->doUpdate($sql))
	echo "更新成功"."<br/>";

$sql = "SELECT * FROM users";
$result = $conn->doquery($sql);
foreach ($result as $row) {
    echo $row["user_id"]."<br/>";
}

$sql = "DELETE FROM users WHERE user_id = 'insert'";
if ($conn->doDelete($sql))
	echo "删除成功"."<br/>";

?>
