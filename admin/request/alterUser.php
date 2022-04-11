<?php
require("token.php");

$user_id = $_POST["user_id"];
$s1 = $_POST["s1"];
$s2 = $_POST["s2"];

$col = "";
if ($s1 == "5") {
    $col = "shut_flag";
} else if ($s1 == 6) {
    $col = "black_flag";
} else {
    $r = '{"flag": "0"}';
    json_decode($r);
    die($r);
}
$sql = "update users set $col = '$s2' where user_id = '$user_id'";
if ($conn->doUpdate($sql)) {
    $r = '{"flag": "1", "user_id": "'.$user_id.'", "s1": "'.$s1.'", "s2": "'.$s2.'"}';
    json_decode($r);
    echo $r;
} else {
    $r = '{"flag": "2"}';
    json_decode($r);
    die($r);
}



?>