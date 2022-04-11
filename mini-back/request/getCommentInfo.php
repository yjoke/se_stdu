<?php echo "{" ?>
<?php
require("../class/user/CUserComment.php");
require("../class/comment/CCommentInfo.php");
require("../class/mydb/CDbMysql.php");
require("../function/EchoComment.php");

// 获取前端数据
$post_id = $_POST["postId"];
if(mb_strlen($post_id) == 0) {
    die("\"error\": \"未能检测到 postId 信息\"}");
}

// 连接数据库
$conn = new CDbMysql();
if(!$conn->connect()) {
    die("\"error\": \"数据库连接失败\"}");
}

// 返回评论信息
echo "\"comments\": ";
$comment = new CCommentInfo();
$user = new CUserComment();
$reply = new CUserComment();
// $sql1 = "select comment_id, comment_text, user_id, reply_id";
// $sql2 = " from comments where post_id = '".$post_id."' and del_flag = 0";
// $sql = $sql1.$sql2;
$sql1 = "select comment_id, comment_text, ";
$sql2 = "comments.user_id as user_id, u1.user_name as user_name, ";
$sql3 = "reply_id, u2.user_name as reply_name ";
$sql4 = "from comments ";
$sql5 = "left join users as u1 on comments.user_id = u1.user_id ";
$sql6 = "left join users as u2 on comments.reply_id = u2.user_id ";
$sql7 = "where post_id = '".$post_id."' and del_flag = 0";
$sql = $sql1.$sql2.$sql3.$sql4.$sql5.$sql6.$sql7;
$result = $conn->doQuery($sql);
$conn->close();
// if(count($result) == 0) {
//     echo "\"检索结果为空\"";
// } else {
    echo "[";
    $i = 0;
    foreach($result as $row) {
        if($i === 0) {
			$i++;
        } else {
            echo ",";
        }
		$comment->setCommentId($row["comment_id"]);
		$comment->setCommentText($row["comment_text"]);
		$user->setUserId($row["user_id"]);
		$user->setUserName($row["user_name"]);
		$reply->setUserId($row["reply_id"]);
		$reply->setUserName($row["reply_name"]);
		EchoComment($user, $reply, $comment);
// 		echo "{";
// 		echo "\"user\":";
// 		$user->echoUserComment();
// 		echo ",";
// 		echo "\"replier\":";
// 		$reply->echoUserComment();
// 		echo ",";
// 		echo "\"comment\":";
// 		$comment->echoCommentInfo();
// 		echo "}";
    }
    echo "]";
// }

?>
<?php echo "}" ?>