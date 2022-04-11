<?php
/*
 * 图片的输出是按一张弄的，需要格式的更改
 */
require('CPostHome.php');
class CPostSend extends CPostHome {

    // PostTime->set, get, echo
    function setPostTime($postTime) {
        $this->postTime = $postTime;
    }
    function getPostTime() {
        return $this->postTime;
    }
    function echoPostTime() {
        echo "\"postTime\": \"".$this->postTime."\"";
    }

    // PostText->set, get, echo
    function setPostText($postText) {
        $this->postText = $postText;
    }
    function getPostText() {
        return $this->postText;
    }
    function echoPostText() {
        echo "\"postText\": \"".$this->postText."\"";
    }

    // PostImgUrl->set, get, echo
    function setPostImgUrl($postImgUrl) {
        $this->postImgUrl = $postImgUrl;
    }
    function getPostImgUrl() {
        return $this->postImgUrl;
    }
    function echoPostImgUrl() {
        echo "\"postImgUrl\": \"".$this->postImgUrl."\"";
    }

    // echo->all
    function echoPostSend() {
        /* 这里应当补充连接数据库的函数，这个不需要多少返回值 */
        echo "{";
        $this->echoPostId();
        echo ",";
        $this->echoPostTitle();
        echo ",";
        $this->echoPostFirstImgUrl();
        echo ",";
        $this->echoPostTime();
        echo ",";
        $this->echoPostText();
        echo ",";
        $this->echoPostImgUrl();
        echo "}";
    }

    // 变量
    private $postTime;      // 发帖时间
    private $postText;      // 帖子内容
    private $postImgUrl;    // 帖子图片

}

?>
