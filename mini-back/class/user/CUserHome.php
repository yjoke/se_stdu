<?php
require("CUserBase.php");
class CUserHome extends CUserBase {

    // userFlag->set, get, echo
    function setUserFlag($userFlag) {
        $this->userFlag = $userFlag;
    }
    function getUserFlag() {
        return $this->userFlag;
    }
    function echoUserFlag() {
        echo "\"userFlag\": \"".$this->userFlag."\"";
    }

    // echo->all
    function echoUserHome() {
        echo "{";
        $this->echoUserId();
        echo ",";
        $this->echoUserFlag();
        echo "}";
    }

    // varrible
    private $userFlag;
}

?>