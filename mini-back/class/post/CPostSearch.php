<?php
require('CPostBase.php');
class CPostSearch extends CPostBase {

    // PostTitle->set, get, echo
    function setPostTitle($postTitle) {
        $this->postTitle = $postTitle;
    }
    function getPostTitle() {
        return $this->postTitle;
    }
    function echoPostTitle() {
        echo "\"postTitle\": \"".$this->postTitle."\"";
    }

    // echo->all
    function echoPostSearch() {
        echo "{";
        $this->echoPostId();
        echo ",";
        $this->echoPostTitle();
        echo "}";
    }

    // 变量
    private $postTitle;     // 帖子标题
    
}

?>
