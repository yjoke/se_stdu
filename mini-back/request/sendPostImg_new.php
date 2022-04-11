<?php echo "{"; ?>
<?php
require("../class/mydb/CDbMysql.php");

$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}
// 获取前端的数据
$file = $_FILES["file"];
$na = explode(".", $file["name"]);
$end = end($na);
$post_id = $_POST["postId"];
if(mb_strlen($post_id) == 0) {
    die("\"error\": \"未检测到 postId 信息\"}");
}
$i = $_POST["i"];
if(mb_strlen($i) == 0) {
    die("\"error\": \"未检测到 i 信息\"}");
}
// 用帖子 id 和顺序拼接的图片名字
$name = $post_id."_".$i.".".$end;
// 图片的绝对地址
$post_img = "https://test.yjoker.work:11111/v2.0/request/temp2/$name";

// print_r($file);
// 图片最大尺寸为 20 M
if($file["size"] <= 20971520) {
	// 下载图片
    move_uploaded_file($file["tmp_name"], "temp2/".$name);
}

$sql0 = " where post_id = $post_id";
if($i == '0') {  // 第一张图
	$sql1 = "update posts set post_img = '$post_img'";
	$sql2 = ", post_first_img = '$post_img' ";
	$sql = $sql1.$sql2.$sql0;
	$conn->doUpdate($sql);
} else {  // 不是第一张图
	$sql1 = "select post_img from posts";
	$sql = $sql1.$sql0;
	$result = $conn->doQuery($sql);
	$post_img = $result[0]["post_img"].";".$post_img;
	$sql1 = "update posts set post_img = '$post_img'";
	$sql = $sql1.$sql0;
	$conn->doUpdate($sql);
}
echo "\"upload\": \"OK\"";
?>
<?php echo "}"; ?>
