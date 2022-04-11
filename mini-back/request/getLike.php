<?php echo "{"; ?>
<?php
require("../class/user/CUserComment.php");
require("../class/post/CPostSearch.php");
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}
$user_id = $_POST["userId"];
$sql = "select post_id from posts where user_id = '$user_id'";
$result = $conn->doQuery($sql);
$i = 0;
$user = new CUserComment();
$post = new CPostSearch();
echo "\"like\": [";
foreach($result as $row) {
	$post_id = $row["post_id"];
	$sql1 = "select likes.user_id as user_id, user_name, post_id";
	$sql2 = " from likes join users on likes.user_id = users.user_id";
	$sql3 = " where post_id = $post_id and read_flag = 0 and likes.user_id <> '$user_id'";
	$sql = $sql1.$sql2.$sql3;
	$res = $conn->doQuery($sql);  // error
	
	foreach($res as $r) {
		if($i === 0) {
			$i++;
		} else {
			echo ",";
		}
		$post_id = $r["post_id"];
		// 更新读标志
// 		$sql = "update likes set read_flag = 1 where post_id = $post_id and user_id = '".$r["user_id"]."'";
// 		$conn->doUpdate($sql);
		$user->setUserId($r["user_id"]);
		$user->setUserName($r["user_name"]);
		
		$post->setPostId($post_id);
		$sql = "select post_title from posts where post_id = $post_id";
		$temp = $conn->doQuery($sql);
		$post->setPostTitle($temp[0]["post_title"]);
		
		echo "{\"user\":";
		$user->echoUserComment();
		echo ",\"post\":";
		$post->echoPostSearch();
		echo "}";
	}
}
echo "]";
?>
<?php echo "}"; ?>
