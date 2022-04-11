<?php echo "{"; ?>
<?php
// 删除帖子要把对应的评论也全部设置为删除（不删除不影响使用，影响逻辑）（待修改）
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}
$post_id = $_POST["postId"];
$sql = "update posts set del_flag = 1 where post_id = $post_id";
if($conn->doUpdate($sql)) {
	echo "\"delPostFlag\": \"true\"";
} else {
	echo "\"delPostFlag\": \"false\"";
}

?>
<?php echo "}"; ?>
