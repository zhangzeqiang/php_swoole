<?php
namespace app\httpd {

use lib\IApp;
use app\httpd\src\Server;

/**
 * Swoole框架学习
 */
class Entry implements IApp {
    public function onCreate () {
        echo "Create!\n";
    }

    public function onDestroy () {
        echo "Destroy!\n";
    }

    public function onRun () {
        echo "Run!\n";
        $server = new Server ();
        $server->run ();
    }
}

$obj = new Entry();
$obj->onCreate();
$obj->onRun ();
$obj->onDestroy ();
}
?>