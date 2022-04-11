<?php require("token.php"); ?>

<?php require("head.php"); ?>

<title>帖子管理界面</title>

<link rel="stylesheet" type="text/css" href="css/table.css" >
<script>
function rePost(id) {
    if (window.confirm("你确定要恢复这条数据吗?")) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "request/rePost.php",
            data: {"post_id": id, "token": "<?php echo $_POST["token"]; ?>"},
            success: function (res) {
                console.log(res);
				if (res.flag == 1) {
                    $('#' + id).attr({"style":"display:none"});
				}
            },
            error: function(res) {
                console.log(res);
                alert("服务器异常，请稍后重试！");
            }
        });
    }
}
</script>
<center>
<h1>帖子管理界面</h1>
<button type="button" onclick="skip('user.php')">管理用户</button>
<button type="button" onclick="skip('slide.php')">管理轮播图</button>
<br/><br/>
<button type="button" onclick="skip('post.php')">帖子界面</button>
<table style="width: 60%;" class="altrowstable">
	<tr>
		<th>帖子id</th>
		<th>发帖人</th>
		<th>发帖时间</th>
		<th>帖子类型</th>
		<th>帖子标题</th>
		<th>获赞数</th>
		<th>操作</th>
	</tr>
<?php
$sql = "select * from posts join users on posts.user_id = users.user_id where del_flag = 1";
$result = $conn->doQuery($sql);
// $i = 0;
foreach($result as $row)
{
    $i = $row["post_id"];
	echo "<tr id='$i'>";
	echo "<th>".$row["post_id"]."</th>";
	echo "<th>".$row["user_name"]."</th>";
	echo "<th>".$row["post_time"]."</th>";
	echo "<th>".$row["post_type"]."</th>";
	echo "<th>".$row["post_title"]."</th>";
	echo "<th>".$row["post_like_num"]."</th>";
?>
	<th>
	    <button type="button" onclick="skip('postDInfo.php?post_id=<?php echo $row["post_id"] ?>')">查看</button>
	    <button type="button" onclick='rePost("<?php echo $i ?>")'>恢复</button>
    </th>
<?php
// 	$i++;
	echo "</tr>";
}
?>
</table>
</center>
