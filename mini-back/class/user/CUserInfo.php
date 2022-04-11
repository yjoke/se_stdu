<?php
require("CUserPost.php");
class CUserInfo extends CUserPost {
    
    // userSex->set, get, echo
    function setUserSex($userSex) {
        $this->userSex = $userSex;
    }
    function getUserSex() {
        return $this->userSex;
    }
    function echoUserSex() {
        echo "\"userSex\": \"".$this->userSex."\"";
    }

    // userLikeNum->set, get, echo
    function setUserLikeNum($userLikeNum) {
        $this->userLikeNum = $userLikeNum;
    }
    function getUserLikeNum() {
        return $this->userLikeNum;
    }
    function echoUserLikeNum() {
        echo "\"userLikeNum\": \"".$this->userLikeNum."\"";
    }

    // echo->all
    function echoUserInfo() {
        echo "{";
        // $this->echoUserId();
        // echo ",";
        $this->echoUserName();
        echo ",";
        $this->echoUserImgUrl();
        echo ",";
        $this->echoUserSex();
        echo ",";
        $this->echoUserLikeNum();
        echo "}";
    }

    // varrible
    private $userSex;
    private $userLikeNum;

}

?>
