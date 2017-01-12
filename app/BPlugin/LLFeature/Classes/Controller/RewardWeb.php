<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RewardWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class RewardWeb extends WebService{
    
    public function findMy(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();


        $id = isset($_GET['id'])?addslashes($_GET['id']):0;
        
        if(!$id){
            $json['status_code'] = 0;
            $json['status_message'] = "No ID Found";
            echo json_encode($json);
            die();
        }
        
        $acc = new LL_Account();
        $acc->getByID($id);
        
        $rew = new LL_RewardCatalog();
        //old masi pakai active
       // $arrReward = $rew->getWhere("rew_active = 1 ORDER BY rew_point DESC");
        
        $arrReward = $rew->getWhere("CURDATE() between rew_start and rew_end ORDER BY rew_point DESC");
        
        $arrStatus = $rew->arrStatus;
        
        $poin = (int)$acc->macc_points;
        $status = $acc->macc_lyb_status;
//        print_r($status);
        
        //echo "pts ".$poin." ".$status;
        
        $my_status = 0;
        foreach($arrStatus as $statid=>$val){
            if($val == $status){
                $my_status = $statid;
            }
        }
//        pr($arrStatus);
        //pr($arrStatus);
        //echo "<br>mystatus ".$my_status;
        //expiry blom di consider krn nanti di cron job...
        $taruhbawah = array();
        $taruhatas = array();
        //urutkan sesuai yang bisa dan tidak bisa
        foreach($arrReward as $rew){
            if($rew->rew_status > $my_status){
                //kalau statusnya tidak cukup tinggi
                $taruhbawah[] = $rew;
                $rew->rew_problem = 3;//"gak_cukup_status";
            }
            else{
                if($rew->rew_point > $poin){
                    $rew->rew_problem = 2;//"gak_cukup_poin";
                    $taruhbawah[] = $rew;
                }else {
                    $taruhatas[] = $rew;
                    $rew->rew_problem = 1; //all clear
                }
            }
        }
        
        $json = array();
        //masukan ke satu array dan kirim
        $json['status_code'] = 1;
        foreach($taruhatas as $rew){
            $arrbaru = array();
            $arrbaru['id'] = $rew->rew_id;
            $arrbaru['pic'] = _PHOTOURL.$rew->rew_pic;
            $arrbaru['status'] = $rew->rew_problem;
            $arrbaru['point'] = $rew->rew_point;
            $arrbaru['member_type'] = $rew->rew_status;
            $arrbaru['aktif'] = $rew->rew_active;
            $arrbaru['rew_start'] = $rew->rew_start;
            $arrbaru['rew_end'] = $rew->rew_end;
            $json['results'][] = $arrbaru; 
        }
        foreach($taruhbawah as $rew){
            $arrbaru = array();
            $arrbaru['id'] = $rew->rew_id;
            $arrbaru['pic'] = _PHOTOURL.$rew->rew_pic;
            $arrbaru['status'] = $rew->rew_problem;
            $arrbaru['point'] = $rew->rew_point;
            $arrbaru['member_type'] = $rew->rew_status;
            $arrbaru['aktif'] = $rew->rew_active;
            $arrbaru['rew_start'] = $rew->rew_start;
            $arrbaru['rew_end'] = $rew->rew_end;
            $json['results'][] = $arrbaru; 
        }
        echo json_encode($json);
        die();
    }
}
