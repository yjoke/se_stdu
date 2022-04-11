<?php require("ip.php"); ?>
<?php require("token.php"); ?>

<?php require("head.php"); ?>

<title>超级管理界面</title>

<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" >
<link rel="stylesheet" type="text/css" href="css/table.css" >
<script>

// 删除用户
function delAdmin(admin_id) {
    if (window.confirm("你确定要删除这条数据吗?")) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "request/delAdmin.php",
            data: {"admin_id": admin_id, "token": "<?php echo $_POST["token"]; ?>"},
            success: function (res) {
                console.log(res);
				if (res.flag == 1) {
                    $('#' + admin_id).attr({"style":"display:none"});
				}
            },
            error: function(res) {
                console.log(res);
                alert("服务器异常，请稍后重试！");
            }
        });
    }
}

// 添加新管理员
$(function() {
    $("#addDiv").dialog({
    	title: "添加新管理员",
    	autoOpen : false,
    	height : 240,
    	width : 400,
    	modal : true,
    	show: "blind", 
    	hide: "fade",
    	close : function(){
    		$("#id").val("");
    		$("#pw").val("");
    		$("#addTip").val("");
    	}
    });
    
    $("#add").click(function(){
		$.ajax({
            type: "POST",
            dataType: "json",
            url: "request/addAdmin.php",
            data: $("#addForm").serialize(),
            success: function (res) {
                console.log(res);
				if (res.flag == 1) {
				    $("#adminTable").append(res.tr);
				    $("#addDiv").dialog("close");
				} else {
				    $('#addTip').html('未知错误, 添加失败! ');
				}
            },
            error: function(res) {
                console.log(res);
                alert("服务器异常，请稍后重试！");
            }
        });
	});
	$("#addButton").click(function() {
		$("#addDiv").dialog("open");
	});	
});

// 修改管理员密码
$(function() {
    $("#alterDiv").dialog({
    	title: "修改管理员密码",
    	autoOpen : false,
    	height : 150,
    	width : 400,
    	modal : true,
    	show: "blind", 
    	hide: "fade",
    	close : function(){
    	    $("#adminId").val("");
    		$("#newpw").val("");
    		$("#alterTip").html("");
    	}
    });
    
    $("#submitpw").click(function(){
		$.ajax({
            type: "POST",
            dataType: "json",
            url: "request/alterAdmin.php",
            data: $("#alterForm").serialize(),
            success: function (res) {
                console.log(res);
                console.log($("#alterForm").serialize());
                console.log($("#adminId").val());
                console.log($("#newpw").val());
				if (res.flag == 1) {
				    alert("修改成功！");
				    $("#alterDiv").dialog("close");
				} else {
				    $('#alterTip').html('未知错误, 修改失败! ');
				}
            },
            error: function(res) {
                console.log(res);
                console.log($("#adminId").val());
                console.log($("#newpw").val());
                alert("服务器异常，请稍后重试！");
            }
        });
	});	
});
function alterAdmin(alter_id) {
    $("#alterDiv").dialog("open");
    $("#adminId").val(alter_id);
}

// 修改 token
$(function() {
    $("#tokenDiv").dialog({
    	title: "修改token时效",
    	autoOpen : false,
    	height : 150,
    	width : 400,
    	modal : true,
    	show: "blind", 
    	hide: "fade",
    	close : function(){
    		$("#newtimes").val("");
    		$("#tokenTip").val("");
    	}
    });
    
    $("#submitTimes").click(function(){
        console.log($("#tokenForm").serialize());
		$.ajax({
            type: "POST",
            dataType: "json",
            url: "request/alterTimes.php",
            data: $("#tokenForm").serialize(),
            success: function (res) {
                console.log(res);
				if (res.flag == 1) {
				    $("#alterTimes").html($("#newtimes").val())
				    $("#tokenDiv").dialog("close");
				} else if (res.flag == 2) {
				    $('#tokenTip').html('时间过短，禁止修改！');
				} else {
				    $('#tokenTip').html('未知错误, 添加失败! ');
				}
            },
            error: function(res) {
                console.log(res);
                alert("服务器异常，请稍后重试！");
            }
        });
	});
	$("#tokenAlter").click(function() {
		$("#tokenDiv").dialog("open");
	});	
});

// 修改 superpw
$(function() {
    $("#superDiv").dialog({
    	title: "修改超管密码",
    	autoOpen : false,
    	height : 150,
    	width : 400,
    	modal : true,
    	show: "blind", 
    	hide: "fade",
    	close : function(){
    		$("#newsuperpw").val("");
    		$("#superTip").val("");
    	}
    });
    
    $("#submitsuper").click(function(){
        console.log($("#superForm").serialize());
		$.ajax({
            type: "POST",
            dataType: "json",
            url: "request/alterSuper.php",
            data: $("#superForm").serialize(),
            success: function (res) {
                console.log(res);
				if (res.flag == 1) {
				    alert("修改成功！");
				    $("#superDiv").dialog("close");
				} else {
				    $('#superTip').html('未知错误, 添加失败! ');
				}
            },
            error: function(res) {
                console.log(res);
                alert("服务器异常，请稍后重试！");
            }
        });
	});
	$("#superAlter").click(function() {
		$("#superDiv").dialog("open");
	});	
});

</script>

<center>
<h1>轮播图管理界面</h1>
<button type="button" id="addButton" >添加新管理员</button>
<button type="button" id="superAlter" >修改超管密码</button>
<br/><br/>

<!-- token -->
<table style="width: 60%;" class="altrowstable" id="tokenTable">
    <tr>
        <th>token有效时长</th>
        <th id="alterTimes"><?php
            $sql = "select g_value from globals where g_ident = 'times'";
            $result = $conn->doQuery($sql);
            echo $result[0]["g_value"];
        ?></th>
        <th><button type="button" id="tokenAlter" >修改</button></th>
    </tr>
</table>
<br/>

<!-- admin -->
<table style="width: 60%;" class="altrowstable" id="adminTable">
	<tr>
		<th>用户名</th>
		<th>操作</th>
	</tr>
<?php
$sql = "select admin_id from admins";
$result = $conn->doQuery($sql);
// $i = 1;
foreach($result as $row)
{
    $i = $row["admin_id"];
	echo "<tr id='$i'>";
	echo "<th>".$row["admin_id"]."</th>";
?>
	<th>
        <button type="button" onclick="alterAdmin('<?php echo $row["admin_id"] ?>')">修改密码</button>
	    <button type="button" onclick="delAdmin('<?php echo $row["admin_id"] ?>')">删除</button>
    </th>
<?php
    // $i++;
	echo "</tr>";
}
?>
</table>
</center>

<!--addDiv-->
<div id="addDiv" style="display: hidden;">
    <form id="addForm" method="post" enctype="multipart/form-data">
        <input type="hidden" name="token" id="token" value="<?php echo $_POST["token"]; ?>">
        <table style="width: 350px;" class="altrowstable">
            <tr>
                <th><label>用户名: </label></th>
                <th><input type="text" name="id" id="id"></th>
            </tr><tr>
                <th><lable>密码: </lable></th>
                <th><input type="text" name="pw" id="pw"></th>
            </tr><tr>
                <th colspan="2"><input type="button" id="add" value="添加"></th>
            </tr>
        </table>
    </form>
        <span style="color:red;" id="addTip"></span>
</div>

<!--alterDiv-->
<div id="alterDiv" style="display: hidden;">
    <form id="alterForm" method="post">
        <table style="width: 350px;" class="altrowstable">
            <tr>
                <th><lable>新密码: </lable></th>
                <th>
                    <input type="hidden" name="adminId" id="adminId">
                    <input type="hidden" name="token" id="token" value="<?php echo $_POST["token"]; ?>">
                    <input type="text" name="newpw" id="newpw">
                </th>
                <th><input type="button" id="submitpw" value="提交"></th>
            </tr>
        </table>
    </form>
        <span style="color:red;" id="alterTip"></span>
</div>

<!--tokenDiv-->
<div id="tokenDiv" style="display: hidden;">
    <form id="tokenForm" method="post">
        <table style="width: 350px;" class="altrowstable">
            <tr>
                <th><lable>有效时长: </lable></th>
                <th>
                    <input type="hidden" name="token" id="token" value="<?php echo $_POST["token"]; ?>">
                    <input type="text" name="newtimes" id="newtimes">
                </th>
                <th><input type="button" id="submitTimes" value="提交"></th>
            </tr>
        </table>
    </form>
        <span style="color:red;" id="tokenTip"></span>
</div>

<!--superDiv-->
<div id="superDiv" style="display: hidden;">
    <form id="superForm" method="post">
        <table style="width: 350px;" class="altrowstable">
            <tr>
                <th><lable>新密码: </lable></th>
                <th>
                    <input type="hidden" name="token" id="token" value="<?php echo $_POST["token"]; ?>">
                    <input type="text" name="newsuperpw" id="newsupwepw">
                </th>
                <th><input type="button" id="submitsuper" value="提交"></th>
            </tr>
        </table>
    </form>
        <span style="color:red;" id="superTip"></span>
</div>

