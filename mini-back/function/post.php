<?php
require("../class/user/CUserPost.php");
require("../class/post/CPostInfo.php");

$u = new CUserPost();
$u->setUserId("评论人的id");
$u->setUserName("这是评论者名字");
$u->setUserImgUrl("头像链接");

$p = new CPostInfo();
$p->setPostId("postId");
$p->setPostTitle("postTitle");
$p->setPostTime("2021-10-25");
$p->setPostText("这是正文");
$p->setPostImgUrl("这是图片链接");
$p->setPostLikeNum("点赞数");


echo "{";
echo "\"user\":";
$u->echoUserPost();
echo ",";
echo "\"post\":";
$p->echoPostInfo();
echo "}";

?>
