<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/31/16
 * Time: 1:13 PM
 */

class AppearMe extends WebService{

    public function getSetting(){

        IMBAuth::checkOAuth();

        $app_id = addslashes($_POST['app_id']);
        $app_token = addslashes($_POST['app_token']);

        $app = new AppAccount();
        $app->getByID($app_id);

        if($app_token != $app->app_token){
            $json['status_code'] = 0;
            $json['status_message'] = "Token Mismatched";
            echo json_encode($json);
            die();
        }

        $str =  file_get_contents(_PHOTOPATH."json/".$app->app_keywords.".json");
//        pr($str);
        $json = json_decode($str);
//        pr($json);

        //ditambahi
        $json->powered_by_link = Efiwebsetting::getData("Powered_By_Link");
        $json->status_code = 1;

        echo json_encode($json);
        die();

    }
} 