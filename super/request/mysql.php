<?php /* 引入数据库文件, 并进行连接判断操作 */ ?>
<?php
// 引入数据库类
require("../../v1.0/class/mydb/CDbMysql.php");

// 创建实例
$conn = new CDbMysql();

// 连接
if (!$conn->connect()) {
	die("数据库连接失败");
}

?>
