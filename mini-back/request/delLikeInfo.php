<?php echo "{"; ?>
<?php
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}
$user_id = $_POST["userId"];
$post_id = $_POST["postId"];

$sql = "update likes set read_flag = 1 where post_id = $post_id and user_id = '".$user_id."'";
if ($conn->doUpdate($sql)) {
    echo "\"delFlag\": \"true\"";
} else {
    echo "\"delFlag\": \"false\"";
}


?>
<?php echo "}"; ?>