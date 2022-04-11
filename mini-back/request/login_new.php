<?php echo "{" ?>
<?php
require("../class/user/CUserHome.php");
require("../class/mydb/CDbMysql.php");

// 获取前端数据
$code = $_POST['code'];
if(mb_strlen($code) == 0) {
    die("\"error\": \"未能检测到 code 信息\"}");
}

$conn = new CDbMysql();
if(!$conn->connect())
{
	die("\"error\": \"数据库连接失败\"}");
}

// 获取 openid 
$appid = "";
$appsecret = "";
$grant_type = "";
$url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$code."&grant_type=".$grant_type;

$do_get = curl_init();
curl_setopt($do_get, CURLOPT_URL, $url);
curl_setopt($do_get, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($do_get);
curl_close($do_get);

// 解码从微信端获取的数据
$response = json_decode($response, true);
$user_id = $response["openid"];

// 返回用户数据
echo "\"user\": ";
$user = new CUserHome();
$sql = "select user_flag, shut_flag, black_flag from users where user_id = '".$user_id."'";
$result = $conn->doQuery($sql);
if(count($result) == 0) {
    $insert = "insert users (user_id) values ('".$user_id."')";
    if(!$conn->doInsert($insert)) {
        echo "\"保存用户信息失败，error\"";
    } else {
        $user->setUserId($user_id);
        $user->setUserFlag(0);
        $user->echoUserHome();
    }
    echo ", \"shutFlag\": \"0\", \"blackFlag\": \"0\"";
} else {
    $user->setUserId($user_id);
    $user->setUserFlag($result[0]['user_flag']);
    $user->echoUserHome();
    echo ", \"shutFlag\": \"".$result[0]['shut_flag']."\", \"blackFlag\": \"".$result[0]['black_flag']."\"";
}

?>
<?php echo "} " ?>
