<?php 
require("token.php");

$slide_id = $_POST["slide_id"];
$order = $_POST["order"];

// 默认失败
$r = '{"flag": "0"}';
json_decode($r);
// 获取之前该顺序的图片
$sql = "select slide_id from slides where slide_flag = $order";
$result = $conn->doQuery($sql);
// 查询到
if ($result[0]["slide_id"] != "") {
    $alter_id = $result[0]["slide_id"];
    
    // 修改该顺序的图片为未选中
    $sql = "update slides set slide_flag = 0 where slide_id = $alter_id";
    // 更新失败
    if (!$conn->doUpdate($sql)) {
        $r = '{"flag": "3"}';
        json_decode($r);
        die($r);
    }
}

// 修改选中的图片为选中
$sql = "update slides set slide_flag = $order where slide_id = $slide_id";
if (!$conn->doUpdate($sql)) {
    $r = '{"flag": "4"}';
    json_decode($r);
    die($r);
}

// 成功
$r = '{"flag": "1", "alter_id": "'.$alter_id.'"}';
json_decode($r);
echo $r;

?>