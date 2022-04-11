<?php echo "{"; ?>
<?php
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}

$post_id = $_POST["postId"];
$user_id = $_POST["userId"];

$sql = "select * from likes where post_id = '$post_id' and user_id = '$user_id'";
$result = $conn->doQuery($sql);

if (count($result) == 1) {
	echo "\"likeFlag\": \"1\"";
} else {
	echo "\"likeFlag\": \"0\"";
}

?>
<?php echo "}"; ?>
