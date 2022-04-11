<?php require("token.php"); ?>

<?php require("head.php"); ?>

<title>查看建议</title>

<link rel="stylesheet" type="text/css" href="css/table.css" >

<center>
<h1>帖子管理界面</h1>
<button type="button" onclick="skip('post.php')">管理用户</button>
<button type="button" onclick="skip('user.php')">管理用户</button>
<button type="button" onclick="skip('slide.php')">管理轮播图</button>
<br/><br/>
<button type="button" onclick="skip('postDeleted.php')">恢复删除的帖子</button>
<table style="width: 60%;" class="altrowstable">
	<tr>
		<th>联系方式</th>
		<th>建议内容</th>
	</tr>
<?php
$sql = "select * from suggest";
$result = $conn->doQuery($sql);
foreach($result as $row)
{
    echo "<tr>";
	echo "<th>".$row["contact"]."</th>";
	$a = str_replace(PHP_EOL, "<br/>", $row["texts"]);
	echo "<th>".$a."</th>";
	echo "</tr>";
}
?>
</table>
</center>
