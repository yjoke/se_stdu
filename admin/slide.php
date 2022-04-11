<?php require("token.php"); ?>

<?php require("head.php"); ?>

<title>轮播图管理界面</title>

<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" >
<link rel="stylesheet" type="text/css" href="css/table.css" >
<script>
// 修改顺序
function alterSlide(slide_id, order) {
    console.log(slide_id);
    if (window.confirm("你确定修改顺序吗?")) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "request/alterSlide.php",
            data: {"slide_id": slide_id, "order": order, "token": "<?php echo $_POST["token"]; ?>"},
            success: function (res) {
                console.log(res);
				if (res.flag == 1) {
				    $('#' + slide_id + ' th:nth-child(4)').html(order);
				    if (res.alter_id != "") {
    				    $('#' + res.alter_id + ' th:nth-child(4)').html(0);
				    }
				}
            },
            error: function(res) {
                console.log(res);
                alert("服务器异常，请稍后重试！");
            }
        });
    }
}

// 删除图片
function delSlide(slide_id) {
    if (window.confirm("你确定要删除这条数据吗?")) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "request/delSlide.php",
            data: {"slide_id": slide_id, "token": "<?php echo $_POST["token"]; ?>"},
            success: function (res) {
                console.log(res);
				if (res.flag == 1) {
                    $('#' + slide_id).attr({"style":"display:none"});
				}
            },
            error: function(res) {
                console.log(res);
                alert("服务器异常，请稍后重试！");
            }
        });
    }
}

// 上传图片
$(function() {
    $("#uploadDiv").dialog({
    	title: "上传图片",
    	autoOpen : false,
    	height : 240,
    	width : 400,
    	modal : true,
    	show: "blind", 
    	hide: "fade",
    	close : function(){
    		$("#name").val("");
    		$("#file").val("");
    		$("#link").val("");
    		$("#uploadTip").html("");
    	}
    });
    
    $("#upload").click(function(){
        var formData = new FormData(); 
        var name = $('#name').val();
        var file = document.getElementById("file").files[0];
        var link = $('#link').val();
        formData.append("name", name);
        formData.append("file", file);
        formData.append("link", link);
        formData.append("token", "<?php echo $_POST["token"]; ?>");
		$.ajax({
            type: "POST",
            dataType: "json",
            url: "request/upload.php",
            processData: false,
            contentType: false,
            data: formData,
            success: function (res) {
                console.log(res);
				if (res.flag == 1) {
				    $("#slideTable").append(res.tr);
				    $("#uploadDiv").dialog("close");
				} else if (res.flag == 2) {
				    $('#uploadTip').html('图片大于20M, 上传失败! ');
				} else {
				    $('#uploadTip').html('未知错误, 上传失败! ');
				}
            },
            error: function(res) {
                console.log(res);
                alert("服务器异常，请稍后重试！");
            }
        });
	});
	$("#uploadButton").click(function() {
		$("#uploadDiv").dialog("open");
	});	
});

// 修改链接
$(function() {
    $("#linkDiv").dialog({
    	title: "修改链接地址",
    	autoOpen : false,
    	height : 150,
    	width : 400,
    	modal : true,
    	show: "blind", 
    	hide: "fade",
    	close : function(){
    	    $("#linkId").val("");
    		$("#newLink").val("");
    		$("#linkTip").html("");
    	}
    });
    
    $("#submitLink").click(function(){
		$.ajax({
            type: "POST",
            dataType: "json",
            url: "request/alterLink.php",
            data: $("#linkForm").serialize(),
            success: function (res) {
                console.log(res);
                console.log($("#linkId").val());
                console.log($("#newLink").val());
				if (res.flag == 1) {
				    var link = $("#newLink").val();
				    var linkStr = "<a href='" + link + "' target='_blank' >" + link + "</a>";
				    $('#' + $("#linkId").val() + ' th:nth-child(3)').html(linkStr);
				    $("#linkDiv").dialog("close");
				} else {
				    $('#linkTip').html('未知错误, 上传失败! ');
				}
            },
            error: function(res) {
                console.log(res);
                console.log($("#linkId").val());
                console.log($("#newlink").val());
                alert("服务器异常，请稍后重试！");
            }
        });
	});
// 	$("#uploadButton").click(function() {
// 		$("#uploadDiv").dialog("open");
// 	});	
});
function alterLink(alter_id) {
    $("#linkDiv").dialog("open");
    $("#linkId").val(alter_id);
}

</script>

<center>
<h1>轮播图管理界面</h1>
<button type="button" onclick="skip('post.php')">管理帖子</button>
<button type="button" onclick="skip('user.php')">管理用户</button>
<button type="button" onclick="skip('suggest.php')">查看建议</button>
<br/><br/>
<button type="button" id="uploadButton">上传图片</button>

<table style="width: 60%;" class="altrowstable" id="slideTable">
	<tr>
	    <!--<th>序号</th>-->
	    <!--<th>图片id</th>-->
		<th>图片名字</th>
		<th>图片</th>
		<th>图片的链接地址</th>
		<th>当前轮播顺序</th>
		<th>操作</th>
	</tr>
<?php
$sql = "select * from slides where del_flag = 0";
$result = $conn->doQuery($sql);
// $i = 1;
foreach($result as $row)
{
    $i = $row["slide_id"];
	echo "<tr id='$i'>";
// 	echo "<th>".$i."</th>";
// 	echo "<th>".$row["slide_id"]."</th>";
	echo "<th>".$row["slide_name"]."</th>";
	echo "<th/><img src='".$row["slide_url"]."' height='150' width='300'/></th>";
// 	echo "<th>".$row["slide_url"]."</th>";
	echo "<th><a href='".$row["slide_link"]."' target='_blank' />".$row["slide_link"]."</a></th>";
	echo "<th>".$row["slide_flag"]."</th>";
?>
	<th>
	    <button type="button" onclick="alterSlide('<?php echo $i ?>', '1')">1</button>
	    <button type="button" onclick="alterSlide('<?php echo $i ?>', '2')">2</button>
	    <button type="button" onclick="alterSlide('<?php echo $i ?>', '3')">3</button>
	    <button type="button" onclick="alterSlide('<?php echo $i ?>', '4')">4</button>
	    <br/>
        <button type="button" onclick="alterLink('<?php echo $i ?>')">修改链接地址</button>
	    <button type="button" onclick="delSlide('<?php echo $i ?>')">删除</button>
    </th>
<?php
    // $i++;
	echo "</tr>";
}
?>
</table>
</center>

<div id="uploadDiv" style="display: hidden;">
    <form id="uploadForm" method="post" enctype="multipart/form-data">
        <table style="width: 350px;" class="altrowstable">
            <tr>
                <th><label>图片名: </label></th>
                <th><input type="text" name="name" id="name"></th>
            </tr><tr>
                <th><laber>选择文件: </laber></th>
                <th><input type="file" name="file" id="file"></th>
            </tr><tr>
                <th><lable>链接地址: </lable></th>
                <th><input type="text" name="link" id="link"></th>
            </tr><tr>
                <th colspan="2"><input type="button" id="upload" value="上传"></th>
            </tr>
        </table>
    </form>
        <span style="color:red;" id="uploadTip"></span>
</div>

<div id="linkDiv" style="display: hidden;">
    <form id="linkForm" method="post">
        <table style="width: 350px;" class="altrowstable">
            <tr>
                
                <th><lable>链接地址: </lable></th>
                <th>
                    <input type="hidden" name="linkId" id="linkId">
                    <input type="hidden" name="token" id="token" value="<?php echo $_POST["token"]; ?>">
                    <input type="text" name="newLink" id="newLink">
                </th>
                <th colspan="2"><input type="button" id="submitLink" value="提交"></th>
            </tr>
        </table>
    </form>
        <span style="color:red;" id="linkTip"></span>
</div>

