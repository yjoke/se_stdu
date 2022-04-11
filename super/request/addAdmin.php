<?php
require("token.php");

$admin_id = $_POST["id"];
$new_pw = $_POST["pw"];
$new_pwm = md5($new_pw);

$sql = "insert into admins(admin_id, password) values('$admin_id', '$new_pwm')";

if (!$conn->doInsert($sql)) {
    $r = '{"flag": "0", "admin_id": "'.$admin_id.'", "new_pw": "'.$new_pw.'"}';
    json_decode($r);
    die($r);
}

$s1 = "<tr id=$admin_id>";
$s2 = "<th>$admin_id</th>";
$s3 = "<th>";
$s4 = "<button type=".'\"'."button".'\"'." onclick=".'\"'."alterAdmin('$admin_id')".'\"'.">修改密码</button>";
$s5 = "<button type=".'\"'."button".'\"'." onclick=".'\"'."delAdmin('$admin_id')".'\"'.">删除</button>";
$s6 = "</th>";
$s = $s1.$s2.$s3.$s4.$s5.$s6;


$r = '{"flag": "1", "admin_id": "'.$admin_id.'", "new_pw": "'.$new_pw.'", "tr": "'.$s.'"}';

json_decode($r);
echo $r;


?>