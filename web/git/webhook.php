<?php
/**
 * GETEE HOOK 测试服务器端代码
 *
 * @author   hb1707 <hb1707@live.cn>
 */


$git = "git"; //默认是用git全局变量，有的环境可能要指明具体安装路径
$branch = "master"; // 
$logName = "/www/wwwroot/www.4gnote.com/git_data"; //本地日志名称，与当前php文件在同一目录
$savePath = "/www/wwwroot/www.4gnote.com/masterfuture/"; //网站根目录，初次克隆确保目录为空
$gitSSHPath  = "git@github.com:hexiao17/masterfuture.git";//代码仓库SSH地址
$secret = "abcd1234"; //在GITEE设置的密码
$is_test = false;//测试模式，true打开,无需密码，平时false关闭
$isCloned = true;//设置是否已经Clone到本地,true:已经clone,直接pull,false:先clone.

//如果已经clone过,则直接拉去代码
if ($isCloned) {
    $requestBody = file_get_contents("php://input");
    if (empty($requestBody) && empty($is_test)) {
        die('send fail');
    }

    //解析码云发过来的JSON信息
    $content = json_decode($requestBody, true);
    //若是主分支且提交数大于0
    //密码要正确
    if($is_test || (!$is_test && verySecret($secret))){       
            if ($content['ref'] == "refs/heads/$branch" ) {
                $cmd = "cd $savePath && $git reset --hard && $git clean -f && $git pull origin $branch 2>&1";
		$result = shell_exec($cmd); //关键命令，拉取代码，2>&1后台执行
                $res_log = "[ PULL START ]" . PHP_EOL;
                if($is_test){
                    $res_log .= date('Y-m-d H:i:s') . '执行测试！'. PHP_EOL;
                }else{
                    $res_log .= date('Y-m-d H:i:s') . '向' . $content['repository']['name'] . '项目的' . $content['ref'] . '分支push了' . $content['repository']['size'] . '个commit：'. PHP_EOL;
                }
                $res_log .= $cmd. PHP_EOL;
                $res_log .= $result. PHP_EOL;
                $res_log .= "[ PULL END ]" . PHP_EOL;
                $res_log .= PHP_EOL . PHP_EOL;
                file_put_contents($logName.".log", $res_log, FILE_APPEND);//写入日志
                echo $result;
            }
        
    } else {
        file_put_contents($logName.".log", '密码错误!', FILE_APPEND);
        echo '密码错误!';
    }

}else {
    $res = "[ CLONE START ]".PHP_EOL;
    $res .= shell_exec("$git clone $gitSSHPath $savePath").PHP_EOL;
    $res .= "[ CLONE END ]".PHP_EOL;
    file_put_contents($logName.".log", $res, FILE_APPEND);//写入日志
}
 //校验secret 密码
 function verySecret($secret){
	$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
	if ($signature) {
		$data = file_get_contents('php://input');
		$hash = "sha1=" . hash_hmac('sha1', $data, $secret);
		//echo 'hash:'.$hash;	
		if (strcmp($signature, $hash) == 0) {
			return true;
		} 
	} 
	return false;
 }
