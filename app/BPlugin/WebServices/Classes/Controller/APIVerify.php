<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/8/15
 * Time: 10:24 AM
 */

class APIVerify {

    static function verify(){

        $app_id = addslashes($_POST['app_id']);
        $key = addslashes($_POST['key']);

//        echo $app_id;
//        echo $key;

        if($app_id == "" || $key == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "Key Missing";
            die(json_encode($json));
        }

        $app = new AppAccount();
        $app->getByID($app_id);

//        pr($app);

        if($app->app_token != $key){
            $json['status_code'] = 0;
            $json['status_message'] = "Key Mismatched";
            die(json_encode($json));
        }
        return $app;
    }
} 