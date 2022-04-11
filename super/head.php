<?php // 阻止页面缓存 ?>
<meta http-equiv="Expires" CONTENT="0">
<meta http-equiv="Cache-Control" CONTENT="no-cache">
<meta http-equiv="Pragma" CONTENT="no-cache">
<?php // 防止页面后退 ?>
<script language="javascript">
    history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });
</script>
<?php // 导入库和函数 ?>
<script type="text/javascript" src="js/jquery.3.6.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/myjs.js"></script>
<?php // 传送token ?>
<script type="text/javascript">
    function skip(url) {
        params = {"token": <?php echo '"'.$token.'"' ?>};
        Post(url, params);
    }
</script>
