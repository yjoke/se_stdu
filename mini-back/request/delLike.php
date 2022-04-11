<?php echo "{"; ?>
<?php
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}
$post_id = $_POST["postId"];
$user_id = $_POST["userId"];
$sql = "select user_id from posts where post_id = $post_id";
$result = $conn->doQuery($sql);
$sql0 = "update users set user_like_num = user_like_num - 1 where user_id = '".$result[0]["user_id"]."'";
$sql1 = "update posts set post_like_num = post_like_num - 1 where post_id = $post_id";
$sql2 = "delete from likes where post_id = $post_id and user_id = '$user_id'";
if($conn->doUpdate($sql0) && $conn->doUpdate($sql1) && $conn->doDelete($sql2)) {
	echo "\"delLikeFlag\": \"true\"";
} else {
	echo "\"delLikeFlag\": \"false\"";
}

?>
<?php echo "}"; ?>
