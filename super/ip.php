<?php
$ip = $_SERVER["REMOTE_ADDR"];
if($ip != '198.211.10.146')
    die("你没有权限访问该网页! ");
// echo "正常显示"
?>