<?php
namespace lib;

/**
 * 应用接口
 */
interface IApp {
    public function onCreate ();    // 创建
    public function onDestroy ();   // 销毁
    public function onRun ();       // 执行
}
?>
