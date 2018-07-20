<?php
namespace app\httpd\src;
use app\httpd\src\Out;
use app\httpd\src\Coroutine;

class Mysql extends Coroutine {
    private $config;
    protected static $instance;

    public function __construct () {
        $this->config = [
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'root',
            'password' => '123',
            'database' => 'test',
        ];
        $this->swoole_client = new \Swoole\Coroutine\MySQL();
        $result = $this->connect ();
        if (!$result) {
            // 连接失败
            Out::println ("Mysql连接失败");
        } else {
            Out::println ("Mysql连接成功");
        }
    }

    public static function I () {
        if (!isset (Mysql::$instance)) {
            Mysql::$instance = new Mysql ();
        } else {
        }
        return Mysql::$instance;
    }

    /**
     * 连接数据库
     */
    protected function connect () {
        return $this->swoole_client->connect($this->config);
    }

    /*
     * 协程同步
     */
    public static function Recv () {
        $instance = Mysql::I ();
        $res = $instance->_recv ();
        return $res;
    }

    /**
     * 查询
     */
    public function _query ($sql) {
        $res = $this->swoole_client->query ($sql);
        return $res;
    }

    public static function Query ($sql) {
        $instance = Mysql::I ();
        $res = $instance->_query ($sql);
        return $res;
    }

    public static function SetDefer ($is_defer=true) {
        $instance = Mysql::I ();
        $res = $instance->_setDefer ($is_defer);
        return $res;
    }
}
?>
