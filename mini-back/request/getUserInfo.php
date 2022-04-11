<?php echo "{"; ?>
<?php
require("../class/user/CUserInfo.php");
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}
$user_id = $_POST["userId"];
if(mb_strlen($user_id) == 0) {
	die("\"error\": \"未能检测到 userId 信息\"}");
}
// 返回用户信息
echo "\"user\": ";
$sql = "select * from users where user_id = '$user_id'";
$result = $conn->doQuery($sql);
$user = new CUserInfo();
$user->setUserName($result[0]["user_name"]);
$user->setUserImgUrl($result[0]["user_img"]);
$user->setUserSex($result[0]["user_sex"]);
$user->setUserLikeNum($result[0]["user_like_num"]);
$user->echoUserInfo();

?>
<?php echo "}"; ?>
