<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WishlistWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class WishlistWeb extends WebService{
    
    public function get(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();
        
        $json['status_code'] = 1;
        $macc_id = addslashes($_GET['macc_id']);
        if(!$macc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "No ID Found";
            echo json_encode($json);
            die();
        }
        $llTesti = new LL_Wishlist();
        $arrW = $llTesti->getWhereFromMultipleTable("wl_acc_id = '$macc_id' AND wl_articlenr = VariantID ORDER BY VariantNameINA ASC", array("LL_Article_WImage"));
        //pr($arrW);
        $llacc = new LL_Article_WImage();
        //$llacc->VariantID
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
            //
            $sudah = array();
            
            //filter
            foreach($arrW as $o){
               if(in_array($o->VariantID, $sudah))continue;
               $sudah[] = $o->VariantID;
               
               
               $sem = array();
               
               foreach($exp as $attr){
                   if(in_array($attr, $arrPicsToAddPhotoUrl)){
                       $sem[$attr] = _PHOTOURL.$o->$attr;
                   }
                   else
                   $sem[$attr] = $o->$attr;
               }
               foreach($exp2 as $attr){
                   //if($attr == "macc_ll_customer_id")break;
                   if(in_array($attr, $arrPicsToAddPhotoUrl2)){
                       $sem[$attr] = _PHOTOURL.$o->$attr;
                   }
                   else
                   $sem[$attr] = $o->$attr;
               }
               
               //wImage
               //kalau base
               
               if($o->ArticleType == 'Base'){
                   $sem['base'] = $sem;
               }else{
                    $arrID = $o->BaseArticleID;
                    $arr2 = $llacc->getWhere("BaseArticleID = '$arrID' AND ArticleType = 'Base'  LIMIT 0,1");
                    $base = $arr2[0];

                    $sem2 = array();
                    foreach($exp2 as $attr2){
                        $sem2[$attr2] = $base->$attr2;
                    }
                    $sem['base'] = $sem2;
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
