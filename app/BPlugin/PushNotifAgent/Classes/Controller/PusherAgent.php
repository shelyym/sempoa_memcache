<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/31/15
 * Time: 9:43 AM
 */

class PusherAgent extends WebService{

    function pushnot(){

        echo "Searching for campaign ...<br><br>";


        $mode = addslashes($_GET['mode']);
        $hour = " AND camp_hour = ". date("G");

        if($mode == "all"){
            $hour = "";
            echo "getting all campaign for today..<br><br>";
        }
        else{
            echo "getting campaign for ".date("G")." o'clock.. <br><br>";
        }
        $psn = new PushNotCampCaps();


        //echo "camp_start = CURDATE() AND camp_active = 1 AND camp_status = 0 $hour";


        $arrPSN = $psn->getWhere("camp_start = CURDATE() AND camp_active = 1 AND camp_status = 0 $hour");

        if($_GET['test'])
        pr($arrPSN);


        //action
        $action = addslashes($_GET['act']);
        if($action == "push"){

            if(count($arrPSN)>0) {
                //translate psn
                foreach ($arrPSN as $psn) {
                    self::kerjakan($psn);
                    $psn->camp_status = 1;
                    $psn->load = 1;
                    //TBD uncomment line dibawah kalau production
//                    $psn->save();
                    echo "<hr>";
                }
            }else{
                echo "no campaign was found ..<br><br>";
            }

        }
        else{
            echo "no action is defined <br><br>";
        }
    }

    static function kerjakan($psn){


        $filtered = trim(rtrim($psn->camp_client_id));

        $dev = new DeviceModelCapsule();
        $arrDevs = array();
        if($filtered == "*"){
            $arrDevs = $dev->getWhere( " dev_not_send = 0 " );
//            $dev->getAll();
        }else{

            $accFilter = explode(",",$filtered);
            if ($_GET['test'])
            pr($filtered);

            foreach($accFilter as $acc_ids){
                $filtext[] = "acc_id = '$acc_ids'";
            }
            $imp = implode(" OR ",$filtext);
            if ($_GET['test'])
            pr($imp);
            $arrDevs = $dev->getWhere( "(".$imp.") AND dev_not_send = 0 " );
        }

        //self::sendUsingAccountArray($arrAcc, $psn);
        $array_id = array();
        if(count($arrDevs)>0) {
            foreach ($arrDevs as $dev) {

                if ($_GET['test']) {
                    echo " acc_id : " . $dev->acc_id;
                    echo "<br> dev_id : " . $dev->device_id;
                    echo "<br> type : " . $dev->device_type;
                    echo "<br>";
                }
                $array_id[] = $dev->device_id;

            }

            $url2push = _BPATH."WebViewerCaps/messages/".$psn->camp_id;

            $arrhasil = self::pushAfteriOS($array_id, $psn->camp_title, $url2push);

            self::simpanHasilGCM($arrhasil,$psn,$array_id,$arrDevs);
        }
    }

    static function pushAfteriOS($array_id,$msg,$url)
    {

        // API access key from Google API's Console
//        define('API_ACCESS_KEY', 'AIzaSyB9xx9AEJhINwTaxCEwCD7XLrV0nQ6tzjY');
        $api_key = Efiwebsetting::getData("PUSH_Api_key_capsule");

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
                'action' => 'url'
            );

            $notifications = array(
                "sound" => "default",
                "badge" => "1",
                "title" => Efiwebsetting::getData("PUSH_default_sender_capsule"),
                "body" => $msg,
                "url" => $url
            );

            $fields = array
            (
                'registration_ids' => $ids,
                'notification' => $notifications,
                'data' => $data,
                'priority'=>"high"
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

    static function simpanHasilGCM($arrhasil,$psn,$array_id,$arrDevs,$isTest = 0){

        if($_GET['test'])
            pr($arrhasil);


        echo  "<h1>Results</h1>";

        foreach($arrhasil as $numw=>$hasil) {
            //simpan hasil
            $gcm = new GCMResultCaps();
            $gcm->multicast_id = $hasil->multicast_id;
            $gcm->success = $hasil->success;
            $gcm->failure = $hasil->failure;
            $gcm->results = serialize($hasil->results);
            $gcm->canonical_ids = $hasil->canonical_ids;
            $gcm->camp_id = $psn->camp_id;
            $gcm->gcm_date = leap_mysqldate();
            $gcm->gcm_test = $isTest;
            $gcm->save();


            echo "ID : ".$hasil->multicast_id."<br>";
            echo "Success : ".$hasil->success."<br>";
            echo "Failure : ".$hasil->failure."<br>";
            echo "<a target='_blank' href='"._SPPATH."PushNotResultsCaps/res?id={$psn->camp_id}&token=".IMBAuth::createOAuth()."' class='btn btn primary'>Complete Results</a><br><br>";

            $page = 999 * $numw;

            foreach($hasil->results as $num=>$res){
                if(isset($res->error)){
                    //error
                    $status = 0;
                    $log_text = $res->error;

                    //delete device_id from table
                    $dv = new DeviceModelCapsule();
                    global $db;
//                    $q = "DELETE FROM {$dv->table_name} WHERE device_id = '".$array_id[$page+$num]."'";
                    $q = "UPDATE {$dv->table_name} SET dev_not_send = 1 WHERE device_id = '".$array_id[$page+$num]."'";

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
                PushLoggerCaps::savelog($psn->camp_id,$array_id[$page+$num],$arrDevs[$page+$num]->acc_id,$status,$log_text,$hasil->multicast_id);
//                PushLogger::savelog($psn->camp_id,$array_id[$page+$num],$arrDevs[$page+$num]->acc_id,$status,$log_text,$hasil->multicast_id);
            }
        }
    }

    //send something ke User2
    static function sendUsingArrayAcc($array_acc,$psn,$isTest = 0){


        $filtered = trim(rtrim($array_acc));

        pr($filtered);

        $dev = new DeviceModelCapsule();
        $arrDevs = array();
        if($filtered == "*"){
            $arrDevs = $dev->getWhere( " dev_not_send = 0 " );
//            $dev->getAll();
        }else{
            $accFilter = explode(",",$filtered);
            foreach($accFilter as $acc_ids){
                $acc_ids = trim(rtrim($acc_ids));
                $filtext[] = "acc_id = '$acc_ids'";
            }
            $imp = implode(" OR ",$filtext);

            $arrDevs = $dev->getWhere( "(".$imp.") AND dev_not_send = 0 " );
        }

        pr($arrDevs);

        //self::sendUsingAccountArray($arrAcc, $psn);
        $array_id = array();
        if(count($arrDevs)>0) {
            foreach ($arrDevs as $dev) {

                if ($_GET['test']) {
                    echo " acc_id : " . $dev->acc_id;
                    echo "<br> dev_id : " . $dev->device_id;
                    echo "<br> type : " . $dev->device_type;
                    echo "<br>";
                }
                $array_id[] = $dev->device_id;

            }

            $url2push = _BPATH."WebViewerCaps/messages/".$psn->camp_id;

            $arrhasil = self::pushAfteriOS($array_id, $psn->camp_title, $url2push);

            self::simpanHasilGCM($arrhasil,$psn,$array_id,$arrDevs, $isTest);
        }
    }

} 