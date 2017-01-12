<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/26/15
 * Time: 4:28 PM
 */

class AppLog extends WebService{

    function pertama(){

        $app_id = addslashes($_POST['app_id']);
        $key = addslashes($_POST['key']);

        $device_id = addslashes($_POST['device_id']);
        $type = addslashes($_POST['type']);

        $lat = addslashes($_POST['lat']);
        $lng = addslashes($_POST['long']);


        if($device_id == "" || $type == ""){
            $json['status_code'] = 0;
            echo json_encode($json);
            die();
        }

        if($app_id == "" || $key == ""){
            $json['status_code'] = 0;
            echo json_encode($json);
            die();
        }
        else{
            //check if this app belongs to right owner
            $app = new AppAccount();
            $app->getByID($app_id);

//            $acc = new Account();
//            $acc->getByID($app->app_client_id);

            if($app->app_token != $key){
                $json['status_code'] = 0;
                $json['status_message'] = "wrong key";
                echo json_encode($json);
                die();
            }
        }



        $log_page_id = addslashes($_POST['page_id']);
        $acc = isset($_POST['acc_id'])?addslashes($_POST['acc_id']):0;

        $dn = new DeviceModel();
        $dnquery = new DeviceModel();

        // langkah 1 , device ID ada device type ada

        $arrs = $dnquery->getWhere("device_id = '$device_id' AND device_type = '$type'");
        $dn = $arrs[0];

        if($dn->did ==""){

            $dn = new DeviceModel();
            $dn->device_id = $device_id;
            $dn->device_type = $type;
            $dn->acc_id = $acc;
            $dn->firstlogin = leap_mysqldate();
            $dn->dev_lat = $lat;
            $dn->dev_lng = $lng;
            $dn->dev_app_id = $app_id;

        }else{
            //kalau device id ada, acc di update
            $dn->load = 1;
            $dn->acc_id = $acc;
        }

        $dn->dev_lng = $lng;
        $dn->dev_app_id = $app_id;
        $dn->logindate = leap_mysqldate();


        if($dn->save()) {
            $json['save_status'] = 1;

            //logged all device login 19 nov 2015 roy
            $logged = new DeviceLogger();
            $logged->log_acc_id = $dn->acc_id;
            $logged->log_date = leap_mysqldate();
            $logged->log_dev_id = $dn->device_id;
            $logged->log_dev_type = $dn->device_type;
            $logged->log_app_id = $app_id;
            $logged->log_lat = $lat;
            $logged->log_lng = $lng;
            $logged->log_page_id = $log_page_id;
            $logged->save();
        }
        else
            $json['save_status'] = 0;

        $json['status_code'] = 1;
        echo json_encode($json);
        die();
    }

    function selanjutnya(){

        $app_id = addslashes($_POST['app_id']);
        $key = addslashes($_POST['key']);

        $device_id = addslashes($_POST['device_id']);
        $type = addslashes($_POST['type']);

        $lat = addslashes($_POST['lat']);
        $lng = addslashes($_POST['long']);

        $acc = isset($_POST['acc_id'])?addslashes($_POST['acc_id']):0;

        $log_page_id = addslashes($_POST['page_id']);


        if($device_id == "" || $type == ""){
            $json['status_code'] = 0;
            echo json_encode($json);
            die();
        }

        if($app_id == "" || $key == ""){
            $json['status_code'] = 0;
            echo json_encode($json);
            die();
        }
        else{
            $app = new AppAccount();
            $app->getByID($app_id);

//            $acc = new Account();
//            $acc->getByID($app->app_client_id);

            if($app->app_token != $key){
                $json['status_code'] = 0;
                $json['status_message'] = "wrong key";
                echo json_encode($json);
                die();
            }
        }


        $logged = new DeviceLogger();
        $logged->log_acc_id = $acc;
        $logged->log_date = leap_mysqldate();
        $logged->log_dev_id = $device_id;
        $logged->log_dev_type = $type;
        $logged->log_app_id = $app_id;
        $logged->log_lat = $lat;
        $logged->log_lng = $lng;
        $logged->log_page_id = $log_page_id;
        $logged->save();

        $json['status_code'] = 1;
        echo json_encode($json);
        die();
    }
} 