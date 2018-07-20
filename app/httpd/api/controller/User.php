<?php
namespace app\httpd\api\controller;
use app\httpd\common\Access;
use app\httpd\src\Controller;
use app\httpd\src\Mysql;
use app\httpd\src\Session;
use app\httpd\src\Out;

class User extends Controller {
    public function index () {
        $sql = "select * from tb_user";
        // Mysql::SetDefer (false);
        Mysql::I ();
        $res = Mysql::Query ($sql);
        Access::Respond ($this, 1, $res, "收到消息");
    }

    public function set () {
        Access::Respond ($this, 1, array (), "收到消息");
    }

    public function get () {
        // Session::Regenerate ($this);
        // Session::Start ($this);
        $firstInc = new Mysql ();
        $firstInc->_setDefer (true);
        $firstInc->_query ("select sleep(3)");

        $secondInc = new Mysql ();
        $secondInc->_setDefer (true);
        $secondInc->_query ("select sleep(2)");

        $firstInc->_recv ();
        $secondInc->_recv ();
        Access::Respond ($this, 1, array (), "收到消息");
        // return "Hello World";
    }

    public function test () {
        $content = Access::MustParamDetect ($this, "content");
        if (!isset ($content)) {
            return ;
        }
        Access::Respond ($this, 1, array (), $content);
    }
}
?>
