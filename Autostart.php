<?php
class Autostart {
    public static function __LoadClass ($class) {
        $file = $class.'.php';

        // 替换\为\\
        $file = str_replace("\\", "/", $file);
        if (is_file ($file)) {
            require_once ($file);
        } else {
        }
    }
}
spl_autoload_register (array('Autostart', '__LoadClass'));
?>