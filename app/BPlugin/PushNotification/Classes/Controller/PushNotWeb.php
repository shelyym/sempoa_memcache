<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/20/15
 * Time: 11:03 PM
 */

class PushNotWeb extends WebService
{

    function save(){

        $device_id = addslashes($_POST['device_id']);
        $type = addslashes($_POST['type']);
        $app_id = isset($_POST['app_id'])?addslashes($_POST['app_id']):0;

        //completion check
        if($device_id == "" || $type == "" || $app_id == 0){
            $json['status_code'] = 0;
            $json['status_message'] = "Incomplete Request";
            echo json_encode($json);
            die();
        }

        $appAcc = new AppAccount();
        $appAcc->getByID($app_id);

        //verify app active
        if($appAcc->app_active!=2){
            $json['status_code'] = 0;
            $json['status_message'] = "Please activate App";
            echo json_encode($json);
            die();
        }

        //verify token
        $token = addslashes($_POST['app_token']);
        if($token != $appAcc->app_token){
            $json['status_code'] = 0;
            $json['status_message'] = "Token Mismatched";
            echo json_encode($json);
            die();
        }

        //check account..
        $acc = isset($_POST['acc_id'])?addslashes($_POST['acc_id']):0;

        IMBAuth::checkOAuth();

        $dn = new DeviceModel();
        $dnquery = new DeviceModel();

        // langkah 1 , device ID ada device type ada

        $arrs = $dnquery->getWhere("device_id = '$device_id' AND device_type = '$type' AND dev_app_id = '$app_id'");
        $dn = $arrs[0];

        if($dn->did ==""){

            $dn = new DeviceModel();
            $dn->device_id = $device_id;
            $dn->device_type = $type;
            $dn->acc_id = $acc;
            $dn->firstlogin = leap_mysqldate();
            $dn->dev_app_id = $app_id;

        }else{
            //kalau device id ada, acc di update
            $dn->load = 1;
            $dn->acc_id = $acc;
        }

        $dn->dev_lng = addslashes($_POST['lng']);
        $dn->dev_lat = addslashes($_POST['lat']);
        $dn->logindate = leap_mysqldate();


        if($dn->save()) {
            $json['save_status'] = 1;

            //logged all device login 19 nov 2015 roy
//            $logged = new DeviceLogger();
//            $logged->log_acc_id = $dn->acc_id;
//            $logged->log_date = leap_mysqldate();
//            $logged->log_dev_id = $dn->device_id;
//            $logged->log_dev_type = $dn->device_type;
//            $logged->save();
        }
        else
            $json['save_status'] = 0;

        $json['status_code'] = 1;
        echo json_encode($json);
        die();
    }

    function save_capsule(){

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


        $dn = new DeviceModelCapsule();
        $dnquery = new DeviceModelCapsule();

        // langkah 1 , device ID ada device type ada

        $arrs = $dnquery->getWhere("device_id = '$device_id' AND device_type = '$type'");
        $dn = $arrs[0];

        if($dn->did ==""){

            $dn = new DeviceModelCapsule();
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

            //logged all device login 19 nov 2015 roy
//            $logged = new DeviceLogger();
//            $logged->log_acc_id = $dn->acc_id;
//            $logged->log_date = leap_mysqldate();
//            $logged->log_dev_id = $dn->device_id;
//            $logged->log_dev_type = $dn->device_type;
//            $logged->save();
        }
        else
            $json['save_status'] = 0;

        $json['status_code'] = 1;
        echo json_encode($json);
        die();
    }


    function getNotifications(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();

        $app_id = addslashes($_POST['app_id']);
        $page = addslashes($_GET['page']);

//        echo $page;

        if($app_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "Incomplete Request";
            echo json_encode($json);
            die();
        }

        if($page == "" || $page < 1) $page = 1;


        $limit = 20;
        $begin = ($page-1)*$limit;

        $psl = new PushLogger();
        $arrGab = $psl->getWhereFromMultipleTable("log_app_id = '$app_id' AND log_camp_id = camp_id AND log_active = 1 ORDER BY log_date DESC LIMIT {$begin},{$limit}",array("PushNotCamp"));

//        echo "log_macc_id = '$macc_id' AND log_camp_id = camp_id ORDER BY log_date DESC LIMIT {$begin},{$limit}";
//        pr($arrGab);

        $list = array();

        foreach($arrGab as $gab){

            $obj = array();
            $obj['lid'] = $gab->log_id;
            $obj['camp_title'] = $gab->camp_title;
//            $obj['camp_msg'] = $gab->camp_msg;
            $obj['camp_date'] = $gab->log_date; //pakai log date

            $obj['camp_id'] = $gab->camp_id;

            $url2push = _BPATH."WebViewer/messages/".$gab->camp_id;

            //penambahan atas permintaan tbs 10 sept 2015, bisa push url
            if($gab->camp_url!=""){
                $url2push = $gab->camp_url;
            }
            $obj['url'] = $url2push;

            $list[] = $obj;

        }

        if(count($list)<1){
            $json['status_message'] = "No Notifications";
            $json['results'] = $list;
        }
        else {
            $json['results'] = $list;
            $json['status_message'] = "Success";
        }
        $json['status_code'] = 1;
        echo json_encode($json);
        die();
    }

    function deleteByLogID(){
        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();

        $app_id = addslashes($_POST['app_id']);
        $lid = addslashes($_POST['lid']);

        $psl = new PushLogger();
        $psl->getByID($lid);

        $json['status_code'] = 0;

        if($psl->log_app_id == $app_id){
            //tidak active lagi
            $psl->log_active = 0;
            $psl->load = 1;
            if($psl->save())
                $json['status_code'] = 1;
        }

        echo json_encode($json);
        die();
    }


}