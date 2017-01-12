<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestiWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TestiWeb extends WebService{
    
    public function get(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();


        $json['status_code'] = 1;
        $prod_id = addslashes($_GET['prod_id']);
        if(!$prod_id){
            $json['status_code'] = 0;
            $json['status_message'] = "No ID Found";
            echo json_encode($json);
            die();
        }
        $llTesti = new LL_Testimonial();
        $arrW = $llTesti->getWhereFromMultipleTable("testi_product_id = '$prod_id' AND testi_acc_id = macc_id AND testi_status = '1' ORDER BY testi_date DESC LIMIT 0,30", array("LL_Account"));
        //pr($arrW);
        $llacc = new LL_Account();
        $exp2 = explode(",",$llacc->crud_webservice_allowed);
        $arrPicsToAddPhotoUrl2 = $llacc->crud_add_photourl;
        
        $obj = $llTesti;
        $obj->default_read_coloms = $obj->crud_webservice_allowed;
            $main_id = $obj->main_id;
            $exp = explode(",",$obj->crud_webservice_allowed);
            $arrPicsToAddPhotoUrl = $obj->crud_add_photourl;
            
            $json = array();
            $json['status_code'] = 1;
            //$json['results_number'] = $obj->getJumlah($query);
            //filter
            foreach($arrW as $o){
               $sem = array();
               foreach($exp as $attr){
                   if(in_array($attr, $arrPicsToAddPhotoUrl)){
                       $sem[$attr] = _PHOTOURL.$o->$attr;
                   }
                   else
                   $sem[$attr] = $o->$attr;
               }
               foreach($exp2 as $attr){
                   if($attr == "macc_ll_customer_id")break;
                   if(in_array($attr, $arrPicsToAddPhotoUrl2)){
                       $sem[$attr] = _PHOTOURL.$o->$attr;
                   }
                   else
                   $sem[$attr] = $o->$attr;
               }
               $json["results"][] = $sem;
            }
            if(count($arrW)<1){
                $json['status_code'] = 0;
                $json['status_message'] = "No Details Found";
            }
            
            echo json_encode($json);
            die();
    }
}
