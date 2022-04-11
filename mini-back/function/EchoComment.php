<?php
// require("../class/user/CUserComment.php");
// require("../class/comment/CCommentInfo.php");
function EchoComment($user, $reply, $comment) {
    echo "{";
    echo "\"user\":";
    $user->echoUserComment();
    echo ",";
    echo "\"replier\":";
    $reply->echoUserComment();
    echo ",";
    echo "\"comment\":";
    $comment->echoCommentInfo();
    echo "}";
}
?>
