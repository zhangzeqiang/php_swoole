<?php
namespace app\httpd\src;

class Coroutine {

    protected $swoole_client;

    public function __construct () {
    }

    public function getHandler () {
        return $this->swoole_client;
    }
    
    /*
     * 协程同步
     */
    public function _recv () {
        $res = $this->swoole_client->recv ();
        return $res;
    }

    public function _setDefer ($is_defer=true) {
        $res = $this->swoole_client->setDefer ($is_defer);
        return $res;
    }
}
?>