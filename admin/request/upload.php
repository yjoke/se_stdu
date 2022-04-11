<?php
require("token.php");
// 数据
// echo ;
// $file = $_POST["name"];
// echo $file;
// $r = '{"file": "'.'\"'.'"}';
// json_decode($r);
// echo $r;
// die();


$file = $_FILES["file"];
$slide_name = $_POST["name"];
$slide_link = $_POST["link"];

// 插入数据
$sql = "insert into slides(slide_name, slide_link) values('$slide_name', '$slide_link')";
if (!$conn->doInsert($sql)) {
    $r = '{"flag": "2"}';
    json_decode($r);
    die($r);
}

// 获取图片id
$sql = "select LAST_INSERT_ID()";
$result = $conn->doQuery($sql);
$slide_id = $result[0]["LAST_INSERT_ID()"];

// 拼接图片名字
$na = explode(".", $file["name"]);
$end = end($na);
$name = $slide_id.".".$end;

// 下载图片 20 兆
if($file["size"] <= 20971520) {
    move_uploaded_file($file["tmp_name"], "../slideImg/".$name);
} else {
    $sql = "delete from slides where slide_id = $slide_id";
    $conn->doDelete($sql);
    $r = '{"flag": "2"}';
    json_decode($r);
    die($r);
}


// 图片的绝对地址
$slide_img = "https://test.yjoker.work:11111/admin/slideImg/$name";
$sql = "update slides set slide_url = '$slide_img' where slide_id = $slide_id";
if (!$conn->doUpdate($sql)) {
    $sql = "delete from slides where slide_id = $slide_id";
    $conn->doDelete($sql);
    $r = '{"flag": "2"}';
    json_decode($r);
    die($r);
}

// 方便前端函数书写，后台直接拼接好表格
$s1 = "<tr id='$slide_id'>";
$s2 = "<th>$slide_name</th>";
$s3 = "<th><img src='$slide_img' height='150' width='300'/></th>";
$s4 = "<th><a href='$slide_link' target='_blank' >$slide_link</a></th>";
$s5 = "<th>0</th>";
$s7 = "<th>";
$s8 = "<button type=".'\"'."button".'\"'." onclick=".'\"'."alterSlide('$slide_id', '1')".'\"'.">1</button>";
$s9 = "<button type=".'\"'."button".'\"'." onclick=".'\"'."alterSlide('$slide_id', '2')".'\"'.">2</button>";;
$s10 = "<button type=".'\"'."button".'\"'." onclick=".'\"'."alterSlide('$slide_id', '3')".'\"'.">3</button>";;
$s11 = "<button type=".'\"'."button".'\"'." onclick=".'\"'."alterSlide('$slide_id', '4')".'\"'.">4</button>";;
$s12 = "<br/>";
$s13 = "<button type=".'\"'."button".'\"'." onclick=".'\"'."alterLink('$slide_id')".'\"'.">修改链接地址</button>";
$s14 = "<button type=".'\"'."button".'\"'." onclick=".'\"'."delSlide('$slide_id')".'\"'.">删除</button>";
$s15 = "</th>";
$s16 = "</tr>";
$s = $s1.$s2.$s3.$s4.$s5.$s6.$s7.$s8.$s9.$s10.$s11.$s12.$s13.$s14.$s15.$s16;

// 成功
$r = '{"flag": "1", "tr": "'.$s.'"}';
json_decode($r);
echo $r;


?>



