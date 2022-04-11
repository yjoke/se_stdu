<?php
$servername = "localhost";
$username = "test1";
$password = "test1";
$dbname = "test1";

$conn = new mysqli($servername, $username, $password, $dbname);
if(!$conn) {
    die("链接失败<br/>, ".$conn->connect_error());
} else {
    echo("连接成功<br/>");
}
// 添加
$insert = "INSERT INTO users (user_id) VALUES ('insert')";
$conn->query($insert);
if($conn->affected_rows == 1) {
    echo "插入成功<br/>";
} else {
    echo "插入失败<br/>";
}

// 更新  -> 这个好像也没返回值
$update = "UPDATE users SET user_img = 'https://test.yjoker.work/upload/phone.jpg' WHERE user_id = 'insert'";
$conn->query($update);
if($conn->affected_rows == 1) {
    echo "更新成功<br/>";
} else {
    echo "更新失败<br/>";
}

// 查找 
$sql = "SELECT * FROM users";// WHERE user_id = 'insert'";
$result = $conn->query($sql);
$arr = $result->fetch_all(MYSQLI_ASSOC);
$result->free_result();
echo $arr[0][''];
// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()){
//         echo "id: ".$row['user_id']."<br/>";
//         echo "<img src=\"".$row['user_img']."\" alt=\"yjoker\"/><br/>";
//     }
// } else {
//     echo "未检索到信息<br/>";
// }

// 删除  -> 好像没有返回值   
// mysql_affected_rows()这个返回insert，update，delete的影响的行数。// 看着要用这个
$delete = "DELETE FROM users WHERE user_id = 'insert'";
$conn->query($delete);
if($conn->affected_rows == 1) {
    echo "删除成功<br/>";
} else {
    echo "删除失败<br/>";
}

$conn->close();

?>
