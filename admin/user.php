<?php require("token.php"); ?>

<?php require("head.php"); ?>

<title>用户管理界面</title>

<link rel="stylesheet" type="text/css" href="css/table.css" >

<script>
// 禁言
function alter(id, user_id, s1, s2) {
    console.log(user_id);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "request/alterUser.php",
        async: true,
        data: {"user_id": user_id, "s1": s1, "s2": s2, "token": "<?php echo $_POST["token"]; ?>"},
        success: function (res) {
            console.log(res);
			if (res.flag == 1) {
                $('#' + id + ' th:nth-child(' + s1 + ')').html(s2);
			}
			alert("操作成功！");
        },
        error: function(res) {
            console.log(res);
            alert("服务器异常, 请稍后重试！");
        }
    });
}
</script>

<center>
<h1>用户管理界面</h1>
<button type="button" onclick="skip('post.php')">管理帖子</button>
<button type="button" onclick="skip('slide.php')">管理轮播图</button>
<button type="button" onclick="skip('suggest.php')">查看建议</button>
<br/><br/>
<button type="button" onclick="skip('post.php')">修改密码</button>
<table style="width: 60%;" class="altrowstable">
	<tr>
		<th>用户id</th>
		<th>受否授权</th>
		<th>用户昵称</th>
		<th>获赞数</th>
		<th>是否被禁言</th>
		<th>是否被拉黑</th>
		<th>操作</th>
	</tr>
<?php
$sql = "select * from users";
$result = $conn->doQuery($sql);
$i = 0;
foreach($result as $row)
{
	echo "<tr id='$i'>";
	echo "<th>".$row["user_id"]."</th>";
	echo "<th>".$row["user_flag"]."</th>";
	echo "<th>".$row["user_name"]."</th>";
	// echo "<th>".$row["num"]."</th>";
	echo "<th>".$row["user_like_num"]."</th>";
	echo "<th>".$row["shut_flag"]."</th>";
	echo "<th>".$row["black_flag"]."</th>";
?>
	<th>
	    <button type="button" onclick='alter(<?php 
    	    echo '"'.$i.'", ';
    	    echo '"'.$row["user_id"].'", ';
    	    echo '"5", "1"';
    	    ?>)'>禁言</button>
	    <button type="button" onclick='alter(<?php 
    	    echo '"'.$i.'", "';
    	    echo $row["user_id"].'", "6", "1"';
    	    ?>)'>拉黑</button>
	    <button type="button" onclick='alter(<?php 
    	    echo '"'.$i.'", "';
    	    echo $row["user_id"].'", "5", "0"';
    	    ?>)'>解禁</button>
	    <button type="button" onclick='alter(<?php 
	        $temp = $row["user_id"];
    	    echo '"'.$i.'", "';
    	    echo $temp.'", "6", "0"';
    	    ?>)'>恢复</button>
	</th>
<?php
    $i++;
	echo "</tr>";
}
?>
</table>
</center>
