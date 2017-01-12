<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/26/16
 * Time: 11:13 PM
 */

class KPOProcessor extends WebService{

    function add_kpo(){

        IMBAuth::checkOAuth();

        $json['post'] = $_POST;
        $json['status_code'] = 1;
        $json['status_message'] = "halo";
        echo json_encode($json);
        die();
    }




} 