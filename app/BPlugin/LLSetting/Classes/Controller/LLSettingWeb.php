<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/10/15
 * Time: 10:34 AM
 */

class LLSettingWeb extends WebService{

    var $access_LLSetting = "admin";
    public function LLSetting()
    {
        //create the model object
        $cal = new LLSetting();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    public function getLLSetting(){
//        $json['status_code'] = 1;
//        $prod_id = addslashes($_GET['prod_id']);
//        if(!$prod_id){
//            $json['status_code'] = 0;
//            $json['status_message'] = "No ID Found";
//            echo json_encode($json);
//            die();
//        }
        $ll = new LLSetting();
        $ll->loadToSession();

//        pr($_SESSION['LLSetting']);

        $json = $_SESSION['LLSetting'];
        $json['status_code'] = 1;
        echo json_encode($json);
        die();
    }
} 