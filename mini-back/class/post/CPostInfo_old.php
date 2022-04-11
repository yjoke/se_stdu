<?php
/*
 * 图片的输出是按一张弄的，需要格式的更改
 */
require("CPostSearch.php");
class CPostInfo extends CPostSearch {

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

    // PostLikeNum->set, get, echo
    function setPostLikeNum($postLikeNum) {
        $this->postLikeNum = $postLikeNum;
    }
    function getPostLikeNum() {
        return $this->postLikeNum;
    }
    function echoPostLikeNum() {
        echo "\"postLikeNum\": \"".$this->postLikeNum."\"";
    }

    // echo->all
    function echoPostInfo() {
        echo "{";
        $this->echoPostId();
        echo ",";
        $this->echoPostTitle();
        echo ",";
        $this->echoPostTime();
        echo ",";
        $this->echoPostText();
        echo ",";
        $this->echoPostImgUrl();
        echo ",";
        $this->echoPostLikeNum();
        echo "}";
    }

    // 变量
    private $postTime;      // 发帖时间
    private $postText;      // 帖子内容
    private $postImgUrl;    // 帖子图片
    private $postLikeNum;   // 帖子点赞数

}

?>
