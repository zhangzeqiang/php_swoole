<?php
namespace app\httpd\src;

class Redis extends Coroutine {

    public $config;
    protected static $instance;

    public function __construct () {
        $this->config = [
            'host' => '127.0.0.1',
            'port' => 6379,
            'user' => '',
            'password' => '',
            'database' => 'db0',
            'expire' => 10
        ];
        $this->swoole_client = new \Swoole\Coroutine\Redis();
        $result = $this->connect ();
        if (!$result) {
            // 连接失败
            Out::println ("Redis连接失败");
        } else {
            Out::println ("Redis连接成功");
        }
    }

    public static function I () {
        if (!isset (Redis::$instance)) {
            Redis::$instance = new Redis ();
        } else {
        }
        return Redis::$instance;
    }

    /**
     * 连接数据库
     */
    protected function connect () {
        return $this->swoole_client->connect($this->config['host'], $this->config['port']);
    }

    /**
     * 默认有效期
     */
    public static function E ($p_expire) {
        $expire = Redis::I ()->config['expire'];
        if ($p_expire != NULL) {
            $expire = $p_expire;
        }
        return $expire;
    }

    public static function Set ($key, $value, $p_expire=NULL) {
        Redis::I ()->getHandler()->set ($key, $value, Redis::E ($p_expire));
    }

    public static function Get ($key) {
        return Redis::I ()->getHandler()->get ($key);
    }
}
?>