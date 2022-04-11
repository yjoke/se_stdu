<?php
class CPostBase {
    
    // PostId->set, get, echo
    function setPostId($postId) {
        $this->postId = $postId;
    }
    function getPostId() {
        return $this->postId;
    }
    function echoPostId() {
        echo "\"postId\": \"".$this->postId."\"";
    }

    // echo->all
    function echoPostBase() {
        echo "{";
        $this->echoPostId();
        echo "}";
    }

    // 变量
    private $postId;    // 帖子Id
    
}

?>
