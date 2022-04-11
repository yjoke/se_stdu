<?php echo "{" ?>
<?php
require("../class/user/CUserHome.php");
require("../class/slide/CSlide.php");
require("../class/post/CPostHome.php");
require("../class/mydb/CDbMysql.php");

// 获取前端数据
// $post_type = $_POST['postType'];
// if(mb_strlen($post_type) == 0) {
//     die("\"error\": \"未能检测到 postType 信息\"}");
// }

// 连接数据库
$conn = new CDbMysql();
if(!$conn->connect()) {
    die("\"error\": \"数据库连接失败\"}");
}


// 返回 slide 数据
echo "\"slide\": ";
$slide = new CSlide();
$sql = "select slide_url, slide_link from slides where slide_flag != 0 order by slide_flag";
$result = $conn->doQuery($sql);
// if(count($result) == 0) {
//     echo "\"检索结果为空\"";
// } else {
    echo "[";
    $i = 0;
    foreach($result as $row) {
        if($i === 0) {
            $i++;
        } else {
            echo ",";
        }
        $slide->setSlideUrl($row["slide_url"]);
        $slide->setSlideLink($row["slide_link"]);
        $slide->echoSlide();
    }
    echo "]";
// }
// **** slide 结束

echo ",";

// 返回 post 数据  --> 当前是全返回
echo "\"post\": ";
$post = new CPostHome();
$sql1 = "select post_id, post_title, post_first_img, post_type from posts";
$sql2 = " where del_flag = 0 order by post_time DESC";
$sql = $sql1.$sql2;
// echo "\"".$sql."\",\"posts\": ";
$result = $conn->doQuery($sql);
// if(count($result) == 0) {
//     echo "\"检索结果为空\"";
// } else {
    echo "[";
    $i = 0;
    foreach($result as $row) {
        if($i === 0) {
            $i++;
        } else {
            echo ",";
        }
        $post->setPostId($row["post_id"]);
        $post->setPostTitle($row["post_title"]);
        $post->setPostFirstImgUrl($row["post_first_img"]);
        $post->setPostType($row["post_type"]);
        $post->echoPostHome();
    }
    echo "]";
// }
?>

<?php echo "}" ?>
