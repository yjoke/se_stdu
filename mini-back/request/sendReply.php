<?php echo "{"; ?>
<?php
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}
$post_id = $_POST["postId"];
$user_id = $_POST["commentUserId"];
$comment_text = $_POST["commentText"];
$reply_id = $_POST["replyUserId"];
$sql = "insert into comments (post_id, user_id, reply_id, comment_text) values ($post_id, '$user_id', '$reply_id', '$comment_text')";
if($conn->doInsert($sql)) {
	echo "\"sendFlag\": \"true\"";
	$sql = "select user_name from users where user_id = '$user_id'";
	$result = $conn->doQuery($sql);
	echo ",\"commentUserName\": \"".$result[0]["user_name"]."\"";
	$sql = "select user_name from users where user_id = '$reply_id'";
	$result = $conn->doQuery($sql);
	echo ",\"replyUserName\": \"".$result[0]["user_name"]."\"";
} else {
	echo "\"sendFlag\": \"false\"";
}

?>
<?php echo "}"; ?>
