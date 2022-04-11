<?php
class CUserBase {

    // userId->set, get, echo
    function setUserId($userId) {
        $this->userId = $userId;
    }
    function getUserId() {
        return $this->userId;
    }
    function echoUserId() {
        echo "\"userId\": \"".$this->userId."\"";
    }

    // echo->all
    function echoUserBase() {
        echo "{";
        $this->echoUserId();
        echo "}";
    }

    // varrible
    private $userId;

}

?>
