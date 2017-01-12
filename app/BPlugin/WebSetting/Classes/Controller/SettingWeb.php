<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingWeb
 *
 * @author User
 */
class SettingWeb extends WebService {


//    var $access_efiwebsetting = "admin";
    public function efiwebsetting ()
    {
        //create the model object
        $cal = new Efiwebsetting();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    //to check if update needed or to do force update
    public function appVersion(){

        $userVersion = addslashes($_GET['version']);
        $userType = addslashes($_GET['os']);

        if($userVersion==""||$userType==""){
            $json['status_code'] = 0;
            $json['status_message'] = 'Please provide version and OS';
            echo json_encode($json);
            die();
        }

        $ef = Efiwebsetting::getData("App_Version_iOS");
        $url = Efiwebsetting::getData("App_URL_iOS");

        if($userType == "android"){
            $ef = Efiwebsetting::getData("App_Version_Android");
            $url = Efiwebsetting::getData("App_URL_Android");
        }

        $exp = explode(";",$ef);
        $version = (int)$exp[0];
        $update = 0;

        if($version>$userVersion){
            $update = 1;
        }

        $force = (int)$exp[1];

        $json['status_code'] = 1;
        $json['results']['latest_version'] = $version;
        $json['results']['force_update'] = $force;
        $json['results']['ada_update'] = $update;
        $json['results']['url'] = $url;

        echo json_encode($json);
        die();

    }

}
