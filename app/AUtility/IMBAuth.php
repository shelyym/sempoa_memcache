<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/2/15
 * Time: 4:38 PM
 */

class IMBAuth {

    public static $array_names = array("acel","jhomponk","budi","cikun","abui");

    public static function createOAuth(){

        $rand_keys = array_rand(self::$array_names, 1);
        $r = self::$array_names[$rand_keys];
//        pr($rand_keys); echo $rand_keys;
//        echo "<br>r : ".$r."<br>";
        $t = gmdate("Y-m-d");
        return md5($r.$t);
    }
    public static function checkOAuth(){
        if(Efiwebsetting::getData('checkOAuth') == "yes") {
            $text = addslashes($_GET['token']);

            $arr = array();
            $t = gmdate("Y-m-d");
            foreach (self::$array_names as $name) {
//            echo $name."<br>";
                $arr[] = md5($name . $t);
            }
//        pr($arr);
            if (!in_array($text, $arr)) {
                $json['status_code'] = 0;
                $json['status_message'] = "Invalid Token";
                echo json_encode($json);
                die();
            }
        }
    }
} 