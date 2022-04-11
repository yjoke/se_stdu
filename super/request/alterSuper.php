<?php
require("token.php");

$pw = $_POST["newsuperpw"];
$pwm = md5($pw);
$sql = "update globals set g_value = '$pwm' where g_ident = 'super_pw'";

if (!$conn->doUpdate($sql)) {
    $r = '{"flag": "0", "super_pw": "'.$pw.'"}';
    json_decode($r);
    echo $r;
} else {
    $r = '{"flag": "1", "super_pw": "'.$pw.'"}';
    json_decode($r);
    echo $r;
}
?>