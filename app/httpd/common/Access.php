<?php
namespace app\httpd\common;

class Access {

    public static function Respond ($env, $code, $data, $msg) {
        $response = $env->response;
        $mes = array();
        $mes['data']=$data;
        $mes['code']=$code;
        $mes['success']=$code;
        $mes['url']='';
        $mes['msg']=$msg;
        $str = json_encode($mes, 256);
        $response->header("Content-Type", "application/json; charset=utf-8");
        $response->end($str);
    }

    /** 
     * 防止SQL注入,对关键字进行过滤 (具体过滤算法后面可优化,很重要)
     **/
    public static function SQLInjectDetect ($content) {
        // $content = addslashes ($content);
        if (isset($content)) {
            if (!get_magic_quotes_gpc()) { // 判断magic_quotes_gpc是否为打开
                $content = addslashes ($content);
                // $content = str_replace("_", "\_", $content); // 把 '_'过滤掉    
                $content = str_replace("%", "\%", $content); // 把' % '过滤掉
                // $content = nl2br($content); // 回车转换
                $content= htmlspecialchars($content); // html标记转换
            } 
            if ($content === "") {
                // $content = "0";
                return ;      // 返回一个未定义的值
            }
        }
        return $content;
    }

    /**
     * 必须参数的获取 
     */
    public static function MustParamDetect ($env, $key) {
        $request = $env->request;

        if (!property_exists($request, "post") || 
            (
                property_exists($request, "post")
                && array_key_exists($request->post, $key)
            )) {
            self::Respond (0, "", "缺少参数".$key);
            return ;
        } else {
            /** 有传递值 */
            $value = "";
            if(isset($request->post[$key])) {
                $value = $request->post[$key];
            }
            else{
                // $value = $request->get[$key];
            }
            // 防止SQL注入
            $value = Access::SQLInjectDetect ($value);

            if (!isset($value) || $value == "") {
                self::Respond (0, "", "参数".$key."不能为空");
            }
            return $value;
        }
    }

    /**
     * 可选参数的获取
     */
    public static function OptionalParam ($env, $key) {
        $request = $env->request;
        if (!property_exists($request, "post") || 
            (
                property_exists($request, "post")
                && array_key_exists($request->post, $key)
            )) {
            return ;
        } else {
            /** 有传递值 */
            $value = "";
            if(isset($request->post[$key])) {
                $value = $request->post[$key];
            }
            else{
                // $value=$_GET[$key];
                // get请求方式不允许使用
            }
            
            // 防止SQL注入
            $value = Access::SQLInjectDetect ($value);
            return $value;
        }
    }

    /**
     * 判断是否存在数组索引
     */
    public static function IfKeyExists ($arr, $key, $def=null) {
        return array_key_exists ($key, $arr)?$arr[$key]:$def;
    }
}
?>