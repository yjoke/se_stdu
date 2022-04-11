<?php echo "{"; ?>
<?php
require("../class/post/CPostSearch.php");
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
if(!$conn->connect()) {
	die("\"error\": \"数据库连接失败\"}");
}
$str = $_GET["str"];
$i = 0;
while($i < 100) {
	$temp = str_replace("  ", " ", $str);
	if($temp == $str) {
		break;
	} else {
		$str = $temp;
	}
	$i++;
}
$str = explode(" ", $str);
$sql = "select post_id, post_title from posts where del_flag = 0";
$i = 0;
foreach($str as $s) {
    if ($s == ' ' || $s == "") {
        // echo "error";
        continue;
    }
	if($i === 0) {
	    $sql = $sql." and (";
		$i++;
	} else {
		$sql = $sql." or ";
	}
	$sql = $sql."post_title like '%".$s."%'";
}
if ($i !== 0) {
    $sql = $sql.")";
}
$result = $conn->doQuery($sql);
echo "\"post\": [";
$post = new CPostSearch();
$i = 0;
foreach($result as $row) {
	if($i === 0) {
		$i++;
	} else {
		echo ",";
	}
	$post->setPostId($row["post_id"]);
	$post->setPostTitle($row["post_title"]);
	$post->echoPostSearch();
}
echo "]";
?>
<?php echo "}"; ?>
