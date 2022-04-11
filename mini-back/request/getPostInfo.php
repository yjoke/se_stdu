<?php echo "{" ?>
<?php
require("../class/user/CUserPost.php");
require("../class/post/CPostInfo.php");
require("../class/mydb/CDbMysql.php");

// 获取前端信息
$post_id = $_POST["postId"];
if(mb_strlen($post_id) == 0) {
    die("\"error\": \"未能检测到 id 信息\"}");
}

// 连接数据库
$conn = new CDbMysql();
if(!$conn->connect()) {
    die("\"error\": \"数据库连接失败\"}");
}

// 返回帖子信息
echo "\"post\": ";
$post = new CPostInfo();
$user = new CUserPost();
$sql1 = "select user_id, post_time, post_title, post_text, post_img, post_like_num";
$sql2 = " from posts where del_flag = 0 and post_id = ".$post_id;
$sql = $sql1.$sql2;
$result = $conn->doQuery($sql);
if(count($result) == 0) {
    echo "\"0\"";
} else {
    $user->setUserId($result[0]["user_id"]);
    // $post->setPostId($post_id);
    $post->setposttime($result[0]["post_time"]);
    $post->setPostTitle($result[0]["post_title"]);
    $str = str_replace(PHP_EOL, "&&n&&", $result[0]["post_text"]);
    $post->setPostText($str);
    $post->setPostImgUrl($result[0]["post_img"]);
    $post->setPostLikeNum($result[0]["post_like_num"]);
    $post->echoPostInfo();
}
echo ",";

// 用户部分
echo "\"user\": ";
$sql = "select user_name, user_img from users where user_id = '".$user->getUserId()."'";
$result = $conn->doQuery($sql);
if(count($result) == 0) {
    echo "\"0\"";
} else {
    $user->setUserName($result[0]["user_name"]);
    $user->setUserImgUrl($result[0]["user_img"]);
    $user->echoUserPost();
}



?>
<?php echo "}" ?>