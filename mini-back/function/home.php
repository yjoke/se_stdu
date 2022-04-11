<?php
require("../class/slide/CSlide.php");
require("../class/post/CPostHome.php");
require("../class/user/CUserHome.php");

$s = new CSlide();
$s->setSlideUrl("这是图片地址");
$s->setSlideLink("这是图片指向的链接");

$u = new CUserHome();
$u->setUserId("评论人的id");
$u->setUserFlag("True");

$p = new CPostHome();
$p->setPostId("postId");
$p->setPostTitle("postTitle");
$p->setPostFirstImgUrl("postFirstImgUrl");

echo "{";
echo "\"slide\":";
$s->echoSlide();
echo ",";
echo "\"user\":";
$u->echoUserHome();
echo ",";
echo "\"post\":";
$p->echoPostHome();
echo "}";
?>
