<?php echo "{"; ?>
<?php
require("../class/user/CUserInfo.php");
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}

$post_id = $_POST["postId"];
if(mb_strlen($post_id) == 0) {
	die("\"error\": \"未能检测到 postId 信息\"}");
}
$user_id = $_POST["userId"];
if(mb_strlen($user_id) == 0) {
	die("\"error\": \"未能检测到 userId 信息\"}");
}
$comment_text = $_POST["commentText"];

$sql1 = "Insert into comments (post_id, user_id, comment_text)";
$sql2 = " values ('$post_id', '$user_id', '$comment_text')";
$sql = $sql1.$sql2;
$conn->doInsert($sql);
$sql = "select user_name from users where user_id = '$user_id'";
$result = $conn->doQuery($sql);
echo "\"userName\": \"".$result[0]["user_name"]."\"";


?>
<?php echo "}"; ?>
