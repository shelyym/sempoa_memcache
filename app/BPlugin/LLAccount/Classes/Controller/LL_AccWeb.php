<?php

/*
 * Sementara blom di kerjakan...
 */

/**
 * Description of LL_AccWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_AccWeb extends WebService{
    
    public function test(){
        $ll = new LL_Account();
        //$ll->printColumlistAsAttributes();
    }


    public function signInWCardnBday(){
        
        $cardNr = addslashes($_POST['card']);
        $dob = addslashes($_POST['dob']);

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();
        /*
         * $macc_foto = addslashes($_POST['macc_foto']);
            $macc_fb_id = addslashes($_POST['macc_fb_id']);
         * di handle di CustMapper/parseToLLAccount
         */
        
         
        if($cardNr == "" || $dob == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "Card or DOB Not Found";
            echo json_encode($json);
            die();
        }
        
        $VRO = VRCustModel::findByCard($cardNr);

        /*
         * Tambahan roy 9 Nov 2015
         * buat handle kalau token status adalah 4, atau tidak 1, kita minta nomor baru
         *
         */


        $json = VRCustMapper::kerjakan($VRO,$dob);
        echo json_encode($json);
        die();
        //pr($ll);
    }
    /*
     * fungsi untuk updateFB ID yang depan
     */
    public function updateFB(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();


        $fb_id = addslashes($_POST['macc_fb_id']);
        $macc_id = addslashes($_POST['macc_id']);
        //$fb_id = addslashes($_POST['macc_fb_id']);
        if($fb_id == "" || $macc_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "Invalid FB/LL ID";
            echo json_encode($json);
            die();
        }
        //update di lokal saja
        $ll = new LL_Account();
        $ll->getByID($macc_id);
        
        $ll->macc_fb_id = $fb_id;
        $ll->load = 1;
        if($ll->save()){
            $json['status_code'] = 1;
            $json['status_message'] = "FB ID From $macc_id updated to ".$fb_id;
        }
        else{
            $json['status_code'] = 0;
            $json['status_message'] = "Save Failed";
            
        }
        echo json_encode($json);
        die();
    }
    
    /*
     * get By FB ID
     */
    public function getByFB(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();


        $fb_id = addslashes($_POST['macc_fb_id']);
        $json = array();
        //$fb_id = addslashes($_POST['macc_fb_id']);
        if($fb_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "Invalid FB ID";
            echo json_encode($json);
            die();
        }
        //update di lokal saja
        $ll = new LL_Account();
        $arrLL = $ll->getWhere("macc_fb_id = '$fb_id' LIMIT 0,1");
        
        //kalau sudah terdaftar
        if(count($arrLL)>0){
            $ll = $arrLL[0];
            //ambil dari ll dengan macc_id ini untuk update status
            $VRO = VRCustModel::findByID($ll->macc_id);        
            $json = VRCustMapper::kerjakan($VRO);
            echo json_encode($json);
            die();
        }        
        else{
            $json['status_code'] = 0;
            $json['status_message'] = "User with this FB ID not Found";            
        }
        
        echo json_encode($json);
        die();
    }
    /*
     * SIGN UP as STC
     */
    public function signup(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();


        $macc_fb_id = addslashes($_POST['macc_fb_id']);
        $macc_last_name = addslashes($_POST['macc_last_name']);
        $macc_first_name = addslashes($_POST['macc_first_name']);
        $macc_gender  = addslashes($_POST['macc_gender']);
        $macc_dob  = addslashes($_POST['macc_dob']);
        $macc_email  = addslashes($_POST['macc_email']);
        $macc_phone  = addslashes($_POST['macc_phone']);
        $macc_foto  = addslashes($_POST['macc_foto']);
        
        //extra kirim dob dan card nr
        $VRO = VRCustModel::addauto();

        if($_GET['test'])
            pr($VRO);

        $response = (string)$VRO->ARTSHeader->Response['ResponseCode'];

        if($_GET['test'])
            echo $response;

        if($response != "Rejected"){
            //echo $response;
            $json = VRCustMapper::kerjakan($VRO,"",1);
            echo json_encode($json);
            die();
        }
        else{
            $id = (string)$VRO->CustomerBody->CustomerID;
            $fmsg = $VRO->CustomerBody->FailureMessage;
            $arr = array();
            foreach($fmsg as $msg){
                $arr[] = (string) $msg;
            }
            $json['status_code'] = 0;
            $json['macc_id'] = $id;
            $json['status_message'] = Efiwebsetting::getData('Constant_detail_used');
            $json['ll_message'] = $arr;
            echo json_encode($json);
            die();
        }
        
    }
    /*
     * update
     */
    public function update(){
        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();

        $macc_email  = addslashes($_POST['macc_email']);
        $macc_phone  = addslashes($_POST['macc_phone']);
        $macc_foto  = addslashes($_POST['macc_foto']);
        $macc_id  = addslashes($_POST['macc_id']);
        
        if($macc_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "Invalid ID";
            echo json_encode($json);
            die();
        }
        $VRO = VRCustModel::update();

        //cek apakah status benar
//        pr($VRO);
        $response_code = (string)$VRO->ARTSHeader->Response['ResponseCode'];


        if($response_code != 'OK'){
            $json['status_code'] = 0;
//            $exp = explode(" by customer id",(string)$VRO->CustomerBody->Failure->FailureMessage);
            $json['status_message'] = Efiwebsetting::getData('Constant_detail_used');
            echo json_encode($json);
            die();

        }else {
            $json = VRCustMapper::kerjakan($VRO);
            echo json_encode($json);
            die();
        }
    }
}
