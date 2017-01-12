<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/8/16
 * Time: 2:34 PM
 */

class PushAgentUtil {

    public static function save_device(){

        $device_id = addslashes($_POST['device_id']);
        $type = addslashes($_POST['type']);


        //completion check
        if($device_id == "" || $type == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "Incomplete Request";
            echo json_encode($json);
            die();
        }

        IMBAuth::checkOAuth();


        //check account..
        $acc = isset($_POST['acc_id'])?addslashes($_POST['acc_id']):0;


        $dn = new DeviceModelAgentApp();
        $dnquery = new DeviceModelAgentApp();

        // langkah 1 , device ID ada device type ada

        $arrs = $dnquery->getWhere("device_id = '$device_id' AND device_type = '$type'");
        $dn = $arrs[0];

        if($dn->did ==""){

            $dn = new DeviceModelAgentApp();
            $dn->device_id = $device_id;
            $dn->device_type = $type;
            $dn->acc_id = $acc;
            $dn->firstlogin = leap_mysqldate();


        }else{
            //kalau device id ada, acc di update
            $dn->load = 1;
            $dn->acc_id = $acc;
        }

        $dn->dev_lng = addslashes($_REQUEST['lng']);
        $dn->dev_lat = addslashes($_REQUEST['lat']);
        $dn->logindate = leap_mysqldate();


        if($dn->save()) {
            $json['save_status'] = 1;

        }
        else
            $json['save_status'] = 0;

        $json['status_code'] = 1;
        echo json_encode($json);
        die();
    }
} 