<?php
namespace app\httpd\src;

class Out {

    public static function println ($string) {
        if (is_string($string)) {
            echo $string."\n";
        } else if (is_array($string) || is_object($string)) {
            var_dump($string);
        }
        return ;
    }
}
?>