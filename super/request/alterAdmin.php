<?php
require("token.php");

$admin_id = $_POST["adminId"];
$new_pw = $_POST["newpw"];
$new_pwm = md5($new_pw);

$sql = "update admins set password = '$new_pwm' where admin_id = '$admin_id'";

if (!$conn->doUpdate($sql)) {
    $r = '{"flag": "0", "admin_id": "'.$admin_id.'", "new_pw": "'.$new_pw.'"}';
    json_decode($r);
    echo $r;
} else {
    $r = '{"flag": "1", "admin_id": "'.$admin_id.'", "new_pw": "'.$new_pw.'"}';
    json_decode($r);
    echo $r;
}
?>