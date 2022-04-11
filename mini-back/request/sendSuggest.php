<?php
require("../class/mydb/CDbMysql.php");
$conn = new CDbMysql();
$conn->connect();

$text = $_GET["text"];
$contact = $_GET["contact"];

$sql = "insert into suggest(contact, texts) values('$contact', '$text')";

$conn->doInsert($sql);


?>
