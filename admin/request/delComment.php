<?php 
require("token.php");

// 删除的逻辑待实现
$comment_id = $_POST["comment_id"];

$sql = "update comments set del_flag = 1 where comment_id = $comment_id";
if ($conn->doUpdate($sql)) {
    $r = '{"flag":"1", "comment_id": "'.$comment_id.'"}';
    json_decode($r);
    echo $r;
} else {
    $r = '{"flag":"0", "comment_id": "'.$comment_id.'"}';
    json_decode($r);
    echo $r;
}


?>