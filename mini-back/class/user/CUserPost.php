<?php
require("CUserComment.php");
class CUserPost extends CUserComment {
    
    // userImgUrl->set, get, echo
    function setUserImgUrl($userImgUrl) {
        $this->userImgUrl = $userImgUrl;
    }
    function getUserImgUrl() {
        return $this->userImgUrl;
    }
    function echoUserImgUrl() {
        echo "\"userImgUrl\": \"".$this->userImgUrl."\"";
    }

    // echo->all
    function echoUserPost() {
        echo "{";
        $this->echoUserId();
        echo ",";
        $this->echoUserName();
        echo ",";
        $this->echoUserImgUrl();
        echo "}";
    }

    // varrible
    private $userImgUrl;

}

?>
