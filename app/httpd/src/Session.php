<?php
namespace app\httpd\src;

class Session {

    protected static $instance;
    protected $env;

    private static function GetConfig () {
        $config = [
            "prefix" => "sess_",
            "name" => "PHPSESSION",
            "expire" => "3600"
        ];
        return $config;
    }

    /**
     * 生成唯一UUID码
     */
    private static function _uuid ($prefix="") {
        $str = md5(uniqid(mt_rand(), true));   
        $uuid  = substr($str,0,8) . '-';   
        $uuid .= substr($str,8,4) . '-';   
        $uuid .= substr($str,12,4) . '-';   
        $uuid .= substr($str,16,4) . '-';   
        $uuid .= substr($str,20,12);   
        return $prefix.$uuid;
    }
    
    /*
     * 启动Session
     */
    public static function Start ($env, $key=NULL, $value=NULL) {
        $config = self::GetConfig();
        if (!isset ($key) || !isset ($value)) {
            $value = self::_uuid ();
            $key = $config["name"];
        }
        $request = $env->request;
        $response = $env->response;
        if (property_exists($request, "cookie") && array_key_exists($config["name"], $request->cookie)) {
            // 存在cookie, 则使用客户端发过来的cookie
            $value = $request->cookie[$key];
        } else {
        }
        $response->cookie ($key, $value, time()+$config["expire"]);
    }

    /**
     * 重新生成SessionId
     */
    public static function Regenerate ($env) {
        $config = self::GetConfig();
        $response = $env->response;
        $value = self::_uuid ();
        $key = $config["name"];

        self::Empty ($env);           // 删除所有cookie
        $response->cookie ($key, $value, time()+$config["expire"]); // 重新新建cookie
    }

    /**
     * 删除所有cookie
     */
    private static function Empty ($env) {
        $config = self::GetConfig();
        $request = $env->request;
        $response = $env->response;

        if (property_exists($request, "cookie")) {
            Out::println ("cookie start!");
            // 存在cookie, 则使用客户端发过来的cookie
            Out::println ($request->cookie);
            foreach ($request->cookie as $key => $value) {
                # code...
                $response->cookie ($key, null, (time()-3600));
            }
            Out::println ("cookie end!");
        } else {
            Out::println ("no cookie!");
        }
    }

    /**
     * 删除Session
     */
    public static function Destroy () {
    }

    /**
     * 设置Session的值
     */
    public static function Set () {
    }

    /**
     * 获取Session的值
     */
    public static function Get () {
    }
}
?>
