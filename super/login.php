<!DOCTYPE html>
<?php require("ip.php"); ?>
<html>
<head>
    <title>石铁大校园论坛登录</title>
    <meta http-equiv= "Content-Type" content= "text/html; charset=utf-8" />
    
    <link rel="stylesheet" type="text/css" href="css/css_login.css">
    
    <?php require("head.php"); ?>
    
    <script type="text/javascript">
    function login() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "request/checkAdmin.php",
            data: $('#form_sub_a').serialize(),
            success: function (res) {
				if (res.flag == 0) {
                    $('#info').html('账号或密码错误');
				} else {
					if (res.flag == 1) {
						params = {"token": res.token};
						$('#info').html('登录成功');
						Post("admin.php", params);
					} else {
						$('#info').html('登录过于频繁，请稍后重试');
					}
				}
            },
            error: function(res) {
                alert("服务器异常，请稍后重试！");
            }
        });
    }
    document.onkeydown = cdk; 
    function cdk(){ 
        if(event.keyCode == 13){
            login();
        }
    }
    </script>
</head>

<body>
<CENTER>
<div id ="container">
	<div id ="title_nav"></div><!-- 占位置, 卡中间 -->
	<div id="content">
		<div id="form_sub">
			<p id = "manage_tx">石铁大校园论坛超级管理员</p>
			<form id = "form_sub_a" onsubmit="return false" action = "##" method = "post" >
				<p class="tx_01">帐号:  <input class="input_va" type = "text" name = "username" required/></p>
				<p class="tx_01">密码:  <input class="input_va" type = "password" name = "password" required/></p>
				<p><label id="info"></label></p>
				<input class = "btn_s" type = "button" onclick="login()" value = "登录"/>
			</form>
		</div>
	</div>
</div>
</CENTER>
</body>

</html>