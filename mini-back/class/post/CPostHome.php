<?php
require('CPostSearch.php');
class CPostHome extends CPostSearch {

    // PostFirstImgUrl->set, get, echo
    function setPostFirstImgUrl($postFirstImgUrl) {
        $this->postFirstImgUrl = $postFirstImgUrl;
    }
    function getPostFirstImgUrl() {
        return $this->postFirstImgUrl;
    }
    function echoPostFirstImgUrl() {
        echo "\"postFirstImgUrl\": \"".$this->postFirstImgUrl."\"";
    }
    
    function setPostType($postType) {
        $this->postType = $postType;
    }
    function getPostType() {
        return $this->postType;
    }
    function echoPostType() {
        echo "\"postType\": \"".$this->postType."\"";
    }
    
    // echo->all
    function echoPostHome() {
        echo "{";
        $this->echoPostId();
        echo ",";
        $this->echoPostTitle();
        echo ",";
        $this->echoPostFirstImgUrl();
        echo ",";
        $this->echoPostType();
        echo "}";
    }

    // 变量
    private $postFirstImgUrl;   // 帖子首图
    private $postType;  // 帖子类型
}

?>
