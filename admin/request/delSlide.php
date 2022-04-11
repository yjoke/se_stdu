<?php 
require("token.php");
// 删除的逻辑待实现
$slide_id = $_POST["slide_id"];

$sql = "delete from slides where slide_id = $slide_id";
if (!$conn->doDelete($sql)) {
    $r = '{"flag": "0"}';
    json_decode($r);
    die($r);
}

$r = '{"flag": "1"}';
json_decode($r);
echo $r;

?>