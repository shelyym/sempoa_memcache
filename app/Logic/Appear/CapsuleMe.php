<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/31/16
 * Time: 1:13 PM
 */

class CapsuleMe extends WebService{

    public function login(){

        IMBAuth::checkOAuth();

        $username = addslashes($_POST['username']);
        $password = addslashes($_POST['password']);

        //untuk deviceModel
        $device_id = addslashes($_POST['device_id']);
        $type = addslashes($_POST['type']);

        $acc = new Account();
        $arr = $acc->getWhere("admin_username = '$username' OR admin_email ='$username'");

//        pr($arr);
        if(count($arr)>0){
            $acc = $arr[0];
            if($password == $acc->admin_password){
                $json['status_code'] = 1;
                $json['status_message'] = "Success";
                $json_acc['acc_id'] = $acc->admin_id;
                $json_acc['username'] = $acc->admin_username;
                $json_acc['email'] = $acc->admin_email;
                $json_acc['user_token'] = md5($acc->admin_email.$acc->admin_password);

                $json['account'] = $json_acc;

                //dashboard
                $myid = $acc->admin_id;
                $kom = new KomisiModel();

                $arrKom = $kom->getWhere("komisi_acc_id = '$myid'  ORDER BY komisi_app_date ASC");

                $paid = 0;
                $unpaid = 0;
                $total = 0;

                $free = 0;
                $android = 0;
                $androidios = 0;
                $totalpaketbayar = 0;
                $totalpaket = 0;

                foreach($arrKom as $kom){
                    if($kom->komisi_status == 1){
                        $paid += $kom->komisi_value;
                    }else{
                        $unpaid += $kom->komisi_value;
                    }
                    $total += $kom->komisi_value;

                    if($kom->komisi_paket_id == 1){
                        //free
                        $free++;
                    }
                    if($kom->komisi_paket_id == 2){
                        //free
                        $android++;
                        $totalpaketbayar++;
                    }
                    if($kom->komisi_paket_id == 3){
                        //free
                        $androidios++;
                        $totalpaketbayar++;
                    }
                    $totalpaket++;
                }


                //get applied banner
                $bm = new BannerModel();
                $arrBm = $bm->getWhere("banner_interval_begin <= $totalpaketbayar AND banner_interval_end >= $totalpaketbayar AND banner_active = 1");

                if(count($arrBm)>0){
                    $selBanner = $arrBm[0];
                    $json_banner['banner_img'] = _BPATH._PHOTOURL.$selBanner->banner_img;
                    $json_banner['banner_link_url'] = $selBanner->banner_link_url;
                }

                //get applied level
                $lv = new LevelModel();
                $arrLvl = $lv->getWhere("level_start<=$totalpaketbayar AND level_end>=$totalpaketbayar AND level_active = 1");
                if(count($arrLvl)>0){
                    $selLvl = $arrLvl[0];
                    $json_lvl['level_name'] = $selLvl->level_name;
                    $json_lvl['level_img'] = _BPATH._PHOTOURL.$selLvl->level_img;
                }

                $dashboard['sales_total'] = $totalpaket;
                $dashboard['sales_paid'] = $totalpaketbayar;
                $dashboard['sales_fee'] = $free;
                $dashboard['sales_android'] = $android;
                $dashboard['sales_androidios'] = $androidios;
                $dashboard['money_total'] = $total;
                $dashboard['money_paid'] = $paid;
                $dashboard['money_unpaid'] = $unpaid;

                $dashboard['banner'] = $json_banner;
                $dashboard['level'] = $json_lvl;

                $json['dashboard'] = $dashboard;


                //myapps
                $app2acc = new App2Acc();
                //AND app_active = 1
                $apps = $app2acc->getWhereFromMultipleTable("ac_admin_id = '".$acc->admin_id."' AND ac_app_id = app_id ",array("AppAccount"));
                if(count($apps)>0){

                    foreach($apps as $ap){
                        $rr = array();
                        $rr['app_id'] = $ap->app_id;
                        $rr['app_icon'] = $ap->app_icon;
                        $rr['app_name'] = $ap->app_name;
                        $rr['app_active'] = $ap->app_active;
                        $rr['app_shortdes'] = $ap->app_shortdes;
                        $rr['app_token'] = $ap->app_token;

                        $rr['app_contract_end'] = $ap->app_contract_end;
                        $rr['app_google_play_link'] = $ap->app_google_play_link;
                        $rr['app_google_version'] = $ap->app_google_version;
                        $rr['app_ios_link'] = $ap->app_ios_link;
                        $rr['app_ios_version'] = $ap->app_ios_version;

                        $paket = new Paket();
                        $paket->getByID($ap->app_paket_id);

                        $rr['paket']['paket_id'] = $paket->paket_id;
                        $rr['paket']['paket_name'] = $paket->paket_name;

                        $json['apps'][] = $rr;

                    }

                }else{
                    $json['apps'] = array();
                }

                //update the device id on deviceModelCaps
                $dn = new DeviceModelCapsule();
                $dnquery = new DeviceModelCapsule();

                // langkah 1 , device ID ada device type ada

                $arrs = $dnquery->getWhere("device_id = '$device_id' AND device_type = '$type'");
                $dn = $arrs[0];

                if($dn->did ==""){

                    $dn = new DeviceModelCapsule();
                    $dn->device_id = $device_id;
                    $dn->device_type = $type;
                    $dn->acc_id = $acc->admin_id;
                    $dn->firstlogin = leap_mysqldate();


                }else{
                    //kalau device id ada, acc di update
                    $dn->load = 1;
                    $dn->acc_id = $acc->admin_id;
                }

                $dn->dev_lng = addslashes($_POST['lng']);
                $dn->dev_lat = addslashes($_POST['lat']);
                $dn->logindate = leap_mysqldate();


                if($dn->save()) {
                    $json['save_device_status'] = 1;
                }

                $json['powered_by_link'] = Efiwebsetting::getData("Powered_By_Link_Caps");
                echo json_encode($json);
                die();

            }else{
                $json['status_code'] = 0;
                $json['status_message'] = "Password Mismatched";
                echo json_encode($json);
                die();
            }
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "User Not Found";
            echo json_encode($json);
            die();
        }




    }

    public function registerPushNotif(){

        IMBAuth::checkOAuth();

        $app_id = addslashes($_POST['app_id']);
        $app_token = addslashes($_POST['app_token']);

        $app = new AppAccount();
        $app->getByID($app_id);

        if($app->app_token != $app_token){
            $json['status_code'] = 0;
            $json['status_message'] = "Token Mismatched";
            echo json_encode($json);
            die();
        }

        $acc_id = addslashes($_POST['acc_id']);
        $now = addslashes($_POST['now']);
        $ios = addslashes($_POST['ios']);
        $_GET['ios'] = $ios;

        $push_title = addslashes($_POST['push_title']);
        $push_msg = addslashes($_POST['push_msg']);
        $push_url = addslashes($_POST['push_url']);
        $push_img = addslashes($_POST['push_img']);
        $push_date = date("Y-m-d",strtotime(addslashes($_POST['push_date'])));
        $push_time = (int)addslashes($_POST['push_time']);

        $img = '';
        if($push_img!=''){
            $img = Crud::savePic($push_img);
        }

        $push = new PushNotCamp();
        $push->camp_client_id = $app->app_client_id;
        $push->camp_img = $img;
        $push->camp_name = $push_title;
        $push->camp_title = $push_title;
        $push->camp_active = 1;
        $push->camp_start = $push_date;
        $push->camp_hour = $push_time;
        $push->camp_msg = $push_msg;
        $push->camp_url = $push_url;
        $push->camp_create_by = $acc_id;
        $push->camp_app_id = $app->app_id;
        $camp_id = $push->save();

        if($camp_id){
            $json['status_code'] = 1;
            if($now){

                //langsung do push
                $succ = Pusher::pushbyID($camp_id);

                $json['status_message'] = "Push Notifications Pushed";
                echo json_encode($json);
                die();


            }else{
                $json['status_message'] = "Push Notifications Registration Success";
                echo json_encode($json);
                die();
            }
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Push Notifications Registration Failed";
            echo json_encode($json);
            die();
        }

    }

    public function getMyPushes(){

        IMBAuth::checkOAuth();

        $acc_id = addslashes($_POST['acc_id']);
        $user_token = addslashes($_POST['user_token']);

        $acc = new Account();
        $acc->getByID($acc_id);
//        echo md5($acc->admin_email.$acc->admin_password);

        if(md5($acc->admin_email.$acc->admin_password) != $user_token){
            $json['status_code'] = 0;
            $json['status_message'] = "Token Mismatched";
            echo json_encode($json);
            die();
        }

        $push = new PushNotCamp();
        $arrPush = $push->getWhere("camp_client_id = '$acc_id' AND camp_status = 0 ORDER BY camp_start ASC,camp_hour ASC");

        if(count($arrPush)>0){

            foreach($arrPush as $pus){
                $rr = array();
                $rr['push_title'] = $pus->camp_name;
                $rr['push_msg'] = $pus->camp_msg;
                $rr['push_img'] = $pus->camp_img;
                $rr['push_url'] = $pus->camp_url;
                $rr['push_date'] = $pus->camp_start;
                $rr['push_time'] = $pus->camp_hour;
                $rr['push_id'] = $pus->camp_id;

                $json['pushes'][] = $rr;
            }

            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            echo json_encode($json);
            die();

        }else{
            $json['status_code'] = 1;
            $json['status_message'] = "No Push Found";
            echo json_encode($json);
            die();
        }
    }

    public function deletePush()
    {

        IMBAuth::checkOAuth();

        $id = addslashes($_POST['push_id']);

        $acc_id = addslashes($_POST['acc_id']);
        $user_token = addslashes($_POST['user_token']);

        $acc = new Account();
        $acc->getByID($acc_id);
//        echo md5($acc->admin_email.$acc->admin_password);

        if(md5($acc->admin_email.$acc->admin_password) != $user_token){
            $json['status_code'] = 0;
            $json['status_message'] = "Token Mismatched";
            echo json_encode($json);
            die();
        }

        $push = new PushNotCamp();
        $push->getByID($id);

        if($push->camp_client_id == $acc_id){

            //delete
            $push->delete($id);

            $this->getMyPushes();

//            $json['status_code'] = 1;
//            $json['status_message'] = "Success";
//            echo json_encode($json);
//            die();

        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Ownership Mismatched";
            echo json_encode($json);
            die();
        }
    }

    function getNotifications(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();

        $macc_id = addslashes($_POST['acc_id']);
        $page = addslashes($_REQUEST['page']);

//        echo $page;

        if($macc_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "Incomplete Request";
            echo json_encode($json);
            die();
        }

        if($page == "" || $page < 1) $page = 1;


        $limit = 20;
        $begin = ($page-1)*$limit;

        $psl = new PushLoggerCaps();
        $arrGab = $psl->getWhereFromMultipleTable("log_macc_id = '$macc_id' AND log_camp_id = camp_id AND log_active = 1 ORDER BY log_date DESC LIMIT {$begin},{$limit}",array("PushNotCampCaps"));

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

            $url2push = _BPATH."WebViewerCaps/messages/".$gab->camp_id;

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

        $macc_id = addslashes($_POST['acc_id']);
        $lid = addslashes($_POST['lid']);

        $psl = new PushLoggerCaps();
        $psl->getByID($lid);

        $json['status_code'] = 0;

        if($psl->log_macc_id == $macc_id){
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