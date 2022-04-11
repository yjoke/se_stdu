<?php 
require("token.php");

// 删除的逻辑待实现
$post_id = $_POST["post_id"];

$sql = "update posts set del_flag = 0 where post_id = $post_id";
if ($conn->doUpdate($sql)) {
    $r = '{"flag":"1", "post_id": "'.$post_id.'"}';
    json_decode($r);
    echo $r;
} else {
    $r = '{"flag":"0", "post_id": "'.$post_id.'"}';
    json_decode($r);
    echo $r;
}


?>