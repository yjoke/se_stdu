<?php
require("token.php");

$new_times = $_POST["newtimes"];

if (intval($new_times) < 300) {
    $r = '{"flag": "2", "new_times": "'.$new_times.'"}';
    json_decode($r);
    die($r);
}

$sql = "update globals set g_value = '$new_times' where g_ident = 'times'";

if (!$conn->doUpdate($sql)) {
    $r = '{"flag": "0", "new_times": "'.$new_times.'"}';
    json_decode($r);
    echo $r;
} else {
    $r = '{"flag": "1", "new_times": "'.$new_times.'"}';
    json_decode($r);
    echo $r;
}
?>
