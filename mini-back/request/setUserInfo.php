<?php
require("../class/mydb/CDbMysql.php");
function dlfile($file_url, $save_to) {
 $content = file_get_contents($file_url);
 file_put_contents($save_to, $content);
}
$conn = new CDbMysql();
$conn->connect();
$user_id = $_POST["userId"];
$user_name = $_POST["userName"];
$user_sex = $_POST["userSex"];
$user_url = $_POST["userImgUrl"];
$user_url = str_replace("/132", "/0", $user_url);
// echo "userurl: $user_url";
dlfile($user_url, "./temp/".$user_id.".jpg");
$url = "https://test.yjoker.work:11111/v1.0/request/temp/$user_id.jpg";
$sql1 = "update users set ";
$sql2 = "user_flag = 1, user_name = '".$user_name;
$sql3 = "', user_sex = ".$user_sex.", user_img = '".$url."'";
$sql4 = "where user_id = '".$user_id."'";
$sql = $sql1.$sql2.$sql3.$sql4;
$conn->doInsert($sql);

?>
