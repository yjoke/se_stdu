<?php echo "{"; ?>
<?php
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}
$comment_id = $_POST["commentId"];

$sql = "update comments set read_flag = 1 where comment_id = ".$comment_id;
if ($conn->doUpdate($sql)) {
    echo "\"delFlag\": \"true\"";
} else {
    echo "\"delFlag\": \"false\"";
}


?>
<?php echo "}"; ?>