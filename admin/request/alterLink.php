<?php
require("token.php");
$alter_id = $_POST["linkId"];
$new_link = $_POST["newLink"];

$sql = "update slides set slide_link = '$new_link' where slide_id = $alter_id";

if (!$conn->doUpdate($sql)) {
    $r = '{"flag": "0", "alter_id": "'.$alter_id.'", "newLink": "'.$new_link.'"}';
    json_decode($r);
    echo $r;
} else {
    $r = '{"flag": "1", "alter_id": "'.$alter_id.'", "newLink": "'.$new_link.'"}';
    json_decode($r);
    echo $r;
}
?>
