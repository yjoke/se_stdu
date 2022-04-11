<?php 
require("token.php");
// 删除的逻辑待实现
$admin_id = $_POST["admin_id"];

$sql = "delete from admins where admin_id = '$admin_id'";
if (!$conn->doDelete($sql)) {
    $r = '{"flag": "0", "admin_id": "'.$admin_id.'"}';
    json_decode($r);
    die($r);
}

$r = '{"flag": "1", "admin_id": "'.$admin_id.'"}';
json_decode($r);
echo $r;

?>