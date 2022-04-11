<?php
require("CCommentBase.php");
class CCommentInfo extends CCommentBase {

    // CommentText->set, get, echo
    function setCommentText($commentText) {
        $this->commentText = $commentText;
    }
    function getCommentText() {
        return $this->commentText;
    }
    function echoCommentText() {
        echo "\"commentText\": \"".$this->commentText."\"";
    }

    // echo->all
    function echoCommentInfo() {
        echo "{";
        $this->echoCommentId();
        echo ",";
        $this->echoCommentText();
        echo "}";
    }
    
    // virrible
    private $commentText;
}

?>
