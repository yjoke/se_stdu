<?php require("token.php"); ?>

<?php require("head.php"); ?>

<title>帖子详细界面</title>

<link rel="stylesheet" type="text/css" href="css/table.css" >
<script>
function delPost(post_id) {
    if (window.confirm("你确定要删除这条数据吗?")) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "request/delPost.php",
            data: {"post_id": post_id, "token": "<?php echo $_POST["token"]; ?>"},
            success: function (res) {
                console.log(res);
                skip("post.php");
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
function delComment(id, comment_id) {
    // console.log(params);
    if (window.confirm("你确定要删除这条数据吗?")) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "request/delComment.php",
            data: {"comment_id": comment_id, "token": "<?php echo $_POST["token"]; ?>"},
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
<br/><br/>
<button type="button" onclick="skip('post.php')">回帖子界面</button>
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
$p_id = $_GET["post_id"];
$sql = "select * from posts join users on posts.user_id = users.user_id where post_id = $p_id";
$result = $conn->doQuery($sql);
$i = 0;
foreach($result as $row)
{
	echo "<tr id='$i'>";
	echo "<th>".$row["post_id"]."</th>";
	echo "<th>".$row["user_name"]."</th>";
	echo "<th>".$row["post_time"]."</th>";
	echo "<th>".$row["post_type"]."</th>";
	echo "<th>".$row["post_title"]."</th>";
	echo "<th>".$row["post_like_num"]."</th>";
?>
	<th>
	    <button type="button" onclick='delPost(<?php
	        echo '"'.$row["post_id"].'"';
	        ?>)'>删除</button>
    </th>
<?php
	$i++;
	echo "</tr>";
}
?>

<tr>
    <td colspan="7"><?php 
    $a = str_replace(PHP_EOL, "<br/>", $result[0]["post_text"]);
    echo $a; 
    ?></td>
</tr><tr>
    <td colspan="7"><?php 
    $imgs = explode(";",$result[0]["post_img"]);
    $j = 0;
    foreach ($imgs as $img) {
        if ($img != "") {
            echo "<img src='$img' width='200px' height='200px'/>&nbsp;&nbsp;";
            $j++;
            if ($j % 4 == 0) {
                echo "<br/><br/>";
            }
        }
    }
    ?></td>
</tr>
</table>
<br/>
<table style="width: 60%;" class="altrowstable">
	<tr>
		<!--<th>评论id</th>-->
		<th>评论人</th>
		<th>回复人</th>
		<th>评论内容</th>
		<th>操作</th>
	</tr>
<?php
$p_id = $_GET["post_id"];
$sql = "select * from comments where del_flag = 0 and post_id = $p_id";
$result = $conn->doQuery($sql);
foreach($result as $row)
{
	echo "<tr id='$i'>";
// 	echo "<th>".$row["comment_id"]."</th>";
	echo "<th>".$row["user_id"]."</th>";
	echo "<th>".$row["reply_id"]."</th>";
	echo "<th>".$row["comment_text"]."</th>";
?>
	<th>
	    <button type="button" onclick='delComment(<?php
	        echo '"'.$i.'", '; 
	        echo '"'.$row["comment_id"].'"';
	        ?>)'>删除</button>
    </th>
<?php
	$i++;
	echo "</tr>";
}
?>
</table>
</center>
