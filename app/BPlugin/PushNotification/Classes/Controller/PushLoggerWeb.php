<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/27/15
 * Time: 10:12 AM
 */

class PushLoggerWeb extends WebService{

    function viewed(){

        $app_id = addslashes($_POST['app_id']);
        $key = addslashes($_POST['key']);

        $app = new AppAccount();

        if($app_id == "" || $key == ""){
            $json['status_code'] = 0;
            echo json_encode($json);
            die();
        }
        else{

            $app->getByID($app_id);

            if($app->app_token != $key){
                $json['status_code'] = 0;
                $json['status_message'] = "wrong key";
                echo json_encode($json);
                die();
            }

        }

        $client_camp_id = addslashes($_POST['camp_id']);
        $device_id = addslashes($_POST['device_id']);

        $dl = new PushLogger();
        global $db;

        $q = "UPDATE {$dl->table_name} SET log_seen = 1, log_seen_date = '".leap_mysqldate()."' WHERE log_app_id = '$app_id' AND log_device_id = '$device_id' AND log_client_id = '$client_camp_id' ";

//        echo $q;
        $db->query($q,0);

        $gcm = new GCMResult();
        $arr = $gcm->getWhere("client_camp_id = '$client_camp_id' AND app_id = '$app_id' LIMIT 0,1");

        $total = 0;
        foreach($arr as $up){
            $q = "SELECT count(*) AS nr FROM {$dl->table_name} WHERE log_camp_id = '{$up->camp_id}' AND log_seen = 1";
            $nr = $db->query($q,1);
            $total += $nr->nr;

            //get GCM and Update

            $up->seen_by = $nr->nr;
            $up->load = 1;
            $up->save();
        }

        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        $json['total_dilihat'] = $total;
        echo json_encode($json);
        die();
    }
} 