<?php
require_once ("./Autostart.php");

if ($argc != 2) {
    throw new \Exception('param lack!');
}

// 定义应用名
$GLOBALS['APPNAME'] = $argv[1];

// 加载所有app/*/start.php，以便启动所有服务
foreach(glob(__DIR__.'/app/'.$GLOBALS['APPNAME'].'/start*.php') as $start_file)
{
    require_once $start_file;
}
?>