<?php
namespace app\httpd\src;
use app\httpd\src\Out;

class Server {

    private $config;

    public function __construct () {
        $this->_checkEnv ();
        $this->_loadConfig ();
    }

    private function _loadConfig () {
        $systemConfig = include ("app/".$GLOBALS['APPNAME']."/conf/system.php");
        $this->config = $systemConfig['server'];
    }

    private function _checkEnv () {
        if (!extension_loaded('swoole')) {
            throw new \BadFunctionCallException('not support: swoole');
        }
    }

    public function run () {
        $http = new \swoole_http_server($this->config['ip'], $this->config['port']);
        $http->on('request', function ($request, $response) {
            $body = self::route ($request, $response);
            if (isset ($body)) {
                $response->header("Content-Type", $this->config['Content-Type']);
                $response->end($body);
            }
        });
        $http->start();
        Out::println ("Server has started ... ");
    }

    private function route ($request, $response) {
        Out::println ($request->server);
        $request_uri = $request->server['request_uri'];
        $uris = explode('/', $request_uri, PHP_URL_PATH);

        $proj = $uris[1];
        if ($proj == "favicon.ico") {
            // 忽略
            return "";
        }

        $class = $uris[2];
        // require_once ("./".$proj.'/controller/'.$class.'.php');
        $classroute = "app\\".$GLOBALS['APPNAME']."\\".$proj."\\controller\\".$class;
        $object = new $classroute();
        $object->request = $request;
        $object->response = $response;
        $action = $uris[3];
        // $ret = call_user_func_array(array($object, $action), array($action));
        $ret = $object->$action ();
        return $ret;
    }
}
?>
