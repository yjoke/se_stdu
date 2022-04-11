<?php echo "{" ?>
<?php
require("../class/mydb/CDbMysql.php");

$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}
// 获取前端的数据
$post_type 	= $_GET["postType"];
if(mb_strlen($post_type) == 0) {
	die("\"error\": \"未检测到 postType 信息\"}");
}
$post_title = $_GET["postTitle"];
if(mb_strlen($post_title) == 0) {
	die("\"error\": \"未检测到 postTitle 信息\"}");
}
$user_id 	= $_GET["userId"];
if(mb_strlen($user_id) == 0) {
	die("\"error\": \"未检测到 userId 信息\"}");
}
$post_text 	= $_GET["postText"];
$post_text = str_replace("'", "\\'", $post_text);  // "'"会影响 sql 语法

$post_time = date("Y-m-d H:i:s");

// 插入数据
$sql1 = "insert into posts (post_type, post_title, ";
$sql2 = "post_text, user_id, post_time) values ('$post_type', ";
$sql3 = "'$post_title', '$post_text', '$user_id', '$post_time')";
$sql = $sql1.$sql2.$sql3;
if(!$conn->doInsert($sql)) {
    die("\"error\": \"数据插入失败\"}");
}

// 获取帖子 id
$sql = "select LAST_INSERT_ID()";
$result = $conn->doQuery($sql);
echo "\"postId\": \"".$result[0]["LAST_INSERT_ID()"]."\"";

?>
<?php echo "}" ?>
