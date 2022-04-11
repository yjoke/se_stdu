<?php
class CCommentBase {

    // CommentId->set, get, echo
    function setCommentId($commentId) {
        $this->commentId = $commentId;
    }
    function getCommentId() {
        return $this->commentId;
    }
    function echoCommentId() {
        echo "\"commentId\": \"".$this->commentId."\"";
    }

    // echo->all
    function echoCommentBase() {
        echo "{";
        $this->echoCommentId();
        echo "}";
    }
    
    // virrible
    private $commentId;
}

?>
