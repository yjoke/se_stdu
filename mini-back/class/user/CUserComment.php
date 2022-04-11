<?php
require("CUserBase.php");
class CUserComment extends CUserBase {
    
    // userName->set, get, echo
    function setUserName($userName) {
        $this->userName = $userName;
    }
    function getUserName() {
        return $this->userName;
    }
    function echoUserName() {
        echo "\"userName\": \"".$this->userName."\"";
    }

    // echo->all
    function echoUserComment() {
        echo "{";
        $this->echoUserId();
        echo ",";
        $this->echoUserName();
        echo "}";
    }

    // varrible
    private $userName;

}

?>
