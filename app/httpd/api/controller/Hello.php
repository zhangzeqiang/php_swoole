<?php
namespace app\httpd\api\controller;
use app\httpd\src\Controller;
use app\httpd\common\Access;
use app\httpd\src\Redis;

class Hello extends Controller {
    public function set () {
        Redis::Set ('swoole:hello', rand(1000, 9999));
        return "<h1>Hello index. #".rand(1000, 9999)."</h1>";
    }

    public function get () {
        $val = Redis::Get ('swoole:hello');
        Access::Respond ($this, 1, array (), $val);
    }
}
?>