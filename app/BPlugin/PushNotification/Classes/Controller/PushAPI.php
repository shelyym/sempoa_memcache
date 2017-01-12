<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/26/15
 * Time: 4:50 PM
 */

class PushAPI extends WebService{

    //if exists
    function doPushByUserID(){

        $app_id = addslashes($_POST['app_id']);
        $key = addslashes($_POST['key']);
        $ipaddress = $_SERVER['REMOTE_ADDR'];

        $app = new AppAccount();

        if($app_id == "" || $key == ""){
            $json['status_code'] = 0;
            echo json_encode($json);
            die();
        }
        else{

            $app->getByID($app_id);

//            $acc = new Account();
//            $acc->getByID($app->app_client_id);

            if($app->app_token != $key){
                $json['status_code'] = 0;
                $json['status_message'] = "wrong key";
                echo json_encode($json);
                die();
            }



            if($app->app_allowed_ip != "" && $app->app_allowed_ip != $ipaddress){
                $json['status_code'] = 0;
                $json['status_message'] = "wrong ip, your ip is ".$ipaddress;
                echo json_encode($json);
                die();
            }
        }

        //actual coding begin here ....
        //only get device IDS and do it in the other function
        $ids = addslashes($_POST['ids']);
        $arrIds = explode(",",$ids);

        $all = array();
        foreach($arrIds as $id){
            $devs = new DeviceModel();
            $arrDevs = $devs->getWhere("dev_app_id = '$app_id' AND acc_id = '$id'");

            foreach($arrDevs as $d){
                $all[] = $d->device_id;
            }
        }

        $_POST['devs'] = implode(",",$all);
        $this->doPushByDevID();

    }

    function doPushByDevID(){

        /*
         * apa yang dibutuhkan
         */
        $client_id = addslashes($_POST['client_id']);
        $app_id = addslashes($_POST['app_id']);
        $key = addslashes($_POST['key']);
        $ipaddress = $_SERVER['REMOTE_ADDR'];

//        pr($_POST['devs']);

        $app = new AppAccount();

        if($app_id == "" || $key == ""){
            $json['status_code'] = 0;
            echo json_encode($json);
            die();
        }
        else{

            $app->getByID($app_id);

//            $acc = new Account();
//            $acc->getByID($app->app_client_id);

            if($app->app_token != $key){
                $json['status_code'] = 0;
                $json['status_message'] = "wrong key";
                echo json_encode($json);
                die();
            }



            if($app->app_allowed_ip != "" && $app->app_allowed_ip != $ipaddress){
                $json['status_code'] = 0;
                $json['status_message'] = "wrong ip, your ip is ".$ipaddress;
                echo json_encode($json);
                die();
            }
        }


        $start = addslashes($_POST['start']);
        $devs = addslashes($_POST['devs']);

        $client_camp_id = addslashes($_POST['camp_id']);

        $camp_name = addslashes($_POST['camp_name']);
        $camp_title = addslashes($_POST['camp_title']); //yg hrs ada cuman camp_title
        $camp_msg = addslashes($_POST['camp_msg']);
        $camp_url = addslashes($_POST['camp_url']);

        $camp_create_by = "API_".$ipaddress;
        $camp_active = 1;
        $camp_status = 0;

        $camp_send_date = leap_mysqldate();




        $array_ids = explode(",",$devs);


        $isTest = addslashes($_POST['isTest']);
        //check pulsa
        if(count($array_ids)>$app->app_pulsa) {
            $json['status_code'] = 0;
            $json['status_message'] = "Pulsa tidak cukup";
            echo json_encode($json);
            die();
        }
        else {

            //  check isTest , test max ke 2 devices
            if($isTest != ""){
                if(count($array_ids)>5){
                    $json['status_code'] = 0;
                    $json['status_message'] = "Test can only use 5 IDS";
                    echo json_encode($json);
                    die();
                }
            }

            //create local campaign
            $cm = new PushNotCamp();
            $cm->camp_client_id = $client_camp_id; //ini buat id nya di client
            $cm->camp_app_id = $app_id;
            $cm->camp_start = leap_mysqldate();
            $cm->camp_hour = 0;
            $cm->camp_name = $camp_name;
            $cm->camp_title = $camp_title;
            $cm->camp_msg = $camp_msg;
            $cm->camp_url = $camp_url;
            $cm->camp_create_by = $camp_create_by;
            $cm->camp_active = $camp_active;
            $cm->camp_status = $camp_status;
            $cm->camp_dev_ids = $devs;
            $camp_id = $cm->save();



            $cm->camp_id = $camp_id;


            $res = self::push($app, $array_ids, $camp_title, $camp_url,$camp_id);


            $json = self::processGCM($res, $app_id, $cm,$array_ids,$app,$isTest);
            echo json_encode($json);
            die();
        }
    }


    function doPushByDevIDwithFile(){

        /*
         * apa yang dibutuhkan
         */
//        $client_id = addslashes($_POST['client_id']);
        $app_id = addslashes($_POST['app_id']);
        $key = addslashes($_POST['key']);
        $ipaddress = $_SERVER['REMOTE_ADDR'];

//        pr($_POST['devs']);

        $app = new AppAccount();

        if($app_id == "" || $key == ""){
            $json['status_code'] = 0;
            echo json_encode($json);
            die();
        }
        else{

            $app->getByID($app_id);

//            $acc = new Account();
//            $acc->getByID($app->app_client_id);

            if($app->app_token != $key){
                $json['status_code'] = 0;
                $json['status_message'] = "wrong key";
                echo json_encode($json);
                die();
            }



            if($app->app_allowed_ip != "" && $app->app_allowed_ip != $ipaddress){
                $json['status_code'] = 0;
                $json['status_message'] = "wrong ip, your ip is ".$ipaddress;
                echo json_encode($json);
                die();
            }
        }


        $start = addslashes($_POST['start']);
        $dest_url = addslashes($_POST['devs']);

        $devs = file_get_contents($dest_url);

        $client_camp_id = addslashes($_POST['camp_id']);

        $camp_name = addslashes($_POST['camp_name']);
        $camp_title = addslashes($_POST['camp_title']); //yg hrs ada cuman camp_title
        $camp_msg = addslashes($_POST['camp_msg']);
        $camp_url = addslashes($_POST['camp_url']);

        $camp_create_by = "API_".$ipaddress;
        $camp_active = 1;
        $camp_status = 0;

        $camp_send_date = leap_mysqldate();




        $array_ids = explode(",",$devs);


        $isTest = addslashes($_POST['isTest']);
        //check pulsa
        if(count($array_ids)>$app->app_pulsa) {
            $json['status_code'] = 0;
            $json['status_message'] = "Pulsa tidak cukup";
            echo json_encode($json);
            die();
        }
        else {

            //  check isTest , test max ke 2 devices
            if($isTest != ""){
                if(count($array_ids)>5){
                    $json['status_code'] = 0;
                    $json['status_message'] = "Test can only use 5 IDS";
                    echo json_encode($json);
                    die();
                }
            }

            //create local campaign
            $cm = new PushNotCamp();
            $cm->camp_client_id = $client_camp_id; //ini buat id nya di client
            $cm->camp_app_id = $app_id;
            $cm->camp_start = leap_mysqldate();
            $cm->camp_hour = 0;
            $cm->camp_name = $camp_name;
            $cm->camp_title = $camp_title;
            $cm->camp_msg = $camp_msg;
            $cm->camp_url = $camp_url;
            $cm->camp_create_by = $camp_create_by;
            $cm->camp_active = $camp_active;
            $cm->camp_status = $camp_status;
            $cm->camp_dev_ids = $devs;
            $camp_id = $cm->save();



            $cm->camp_id = $camp_id;


            $res = self::push($app, $array_ids, $camp_title, $camp_url,$camp_id);


            $json = self::processGCM($res, $app_id, $cm,$array_ids,$app,$isTest);
            echo json_encode($json);
            die();
        }

    }

    var $access_push = "master_admin";

    static function push($app,$array_id,$msg,$url,$camp_id)
    {

        // API access key from Google API's Console
//        define('API_ACCESS_KEY', 'AIzaSyB9xx9AEJhINwTaxCEwCD7XLrV0nQ6tzjY');
        $api_key = $app->app_api_access_key;

        $registrationIds = $array_id;

        if(count($registrationIds)>=1000){
            //dibagi 1000 an...how ?
            $chunks = array_chunk($registrationIds, 999);
        }
        else{
            $chunks = array($registrationIds);
        }

        $array_results = array();
        foreach($chunks as $ids) {
            // prep the bundle
            $data = array
            (
                'message' => $msg,
                'url' => $url,
                'action' => 'url',
                'camp_id'=>$camp_id
            );

            $notifications = array(
                "sound" => "default",
                "badge" => "1",
                "title" => $app->app_pushname,
                "body" => $msg,
                "url" => $url,
                "camp_id"=>$camp_id
            );

            $fields = array
            (
                'registration_ids' => $ids,
                'notification' => $notifications,
                'data' => $data,
//                'content_available' => 1,
//                'aps' => array('content-available' => 1, 'content_available' => 1)
            );

            $headers = array
            (
                'Authorization: key=' . $api_key,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = json_decode(curl_exec($ch));
            curl_close($ch);

            //TBD : logger goes here



            $array_results[] = $result;
        }
        return $array_results;
    }

    var $access_processGCM = "master_admin";

    static function processGCM($arrhasil,$app_id,$psn,$array_ids,$app,$isTest = 0){


        $json['status_code'] = 1;
        $json['status_message'] = "Success";

        $json['result'] = $arrhasil;


        foreach($arrhasil as $numw=>$hasil) {
            //simpan hasil
            $gcm = new GCMResult();
            $gcm->multicast_id = $hasil->multicast_id;
            $gcm->success = $hasil->success;
            $gcm->failure = $hasil->failure;
            $gcm->results = serialize($hasil->results);
            $gcm->canonical_ids = $hasil->canonical_ids;
            $gcm->camp_id = $psn->camp_id;
            $gcm->gcm_date = leap_mysqldate();
            $gcm->gcm_test = $isTest;
            $gcm->app_id = $app_id;
            $gcm->client_camp_id = $psn->camp_client_id;
            $gcm->client_id = $app->app_client_id;
            $gcm->save();

            if(!$isTest) {
                //kurangin pulsa ...
                $old = $app->app_pulsa;
                $app->app_pulsa = $app->app_pulsa - $hasil->success;
                $app->load = 1;
                $app->save();

                //save transactions
                $tt = new AppPulsa();
                $tt->pulsa_acc_id = Account::getMyID();
                $tt->pulsa_action = "debit";
                $tt->pulsa_app_id = $app_id;
                $tt->pulsa_date = leap_mysqldate();
                $tt->pulsa_jumlah = $hasil->success;
                $tt->pulsa_new = $app->app_pulsa;
                $tt->pulsa_old = $old;
                $tt->pulsa_camp_id = $psn->camp_id;
                $tt->save();
//
            }
//            echo "ID : ".$hasil->multicast_id."<br>";
//            echo "Success : ".$hasil->success."<br>";
//            echo "Failure : ".$hasil->failure."<br>";
//            echo "<a target='_blank' href='"._SPPATH."PushNotResults/res?id={$psn->camp_id}&token=".IMBAuth::createOAuth()."' class='btn btn primary'>Complete Results</a><br><br>";

            $page = 999 * $numw;

            foreach($hasil->results as $num=>$res){
                if(isset($res->error)){
                    //error
                    $status = 0;
                    $log_text = $res->error;

                    //delete device_id from table
                    $dv = new DeviceModel();
                    global $db;
                    //repaired using update
                    $q = "UPDATE  {$dv->table_name} SET dev_not_send = 1 WHERE device_id = '".$array_ids[$page+$num]."'";

                    if($_GET['test']) {
                        echo "<br>query : " . $q . "<br>";
                        echo "delete succ :" . $db->query($q, 0);
                        echo "<br>";
                    }

                }else{
                    //success
                    $status = 1;
                    $log_text = $res->message_id;
                }
                // repaired macc id cannot get
                PushLogger::savelog($psn->camp_id,$array_ids[$num],$app->app_client_id,$status,$log_text,$hasil->multicast_id,$app_id,$psn->camp_client_id);
            }
        }

        $psn->camp_status = 1;
        $psn->camp_send_date = leap_mysqldate();
        $psn->load = 1;
        $psn->save();
        return $json;
    }
} 