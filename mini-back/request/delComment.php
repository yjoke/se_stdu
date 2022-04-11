<?php echo "{"; ?>
<?php
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}
$comment_id = $_POST["commentId"];

$sql = "update comments set del_flag = 1 where comment_id = $comment_id";
if($conn->doUpdate($sql)) {
	echo "\"delCommentFlag\": \"true\"";
} else {
	echo "\"delCommentFlag\": \"false\"";
}

?>
<?php echo "}"; ?>
