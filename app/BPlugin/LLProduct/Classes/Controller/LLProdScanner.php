<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LLProdScanner
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LLProdScanner extends WebService{
    
    public function scan(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();

        $id = addslashes($_GET['id']);
        //$type = addslashes($_GET['type']);
        //if($id == "")die("no id");
        if($id == "" || $id <1){
            $json['status_code'] = 0;
            $json['status_message'] = "No ID";
            echo json_encode($json);
            die();
        }
        $ean = new LL_Article_EAN();
        $ean->getByID($id);

        if($ean->var_id != "" && $ean->var_id>0) {


            $ll = new LL_Article_WImage();
            $ll->getByID($ean->var_id);
//        $arr = $ll->getWhere("VariantINACode = '$id' LIMIT 0,1");
//        $sel = $arr[0];
            if ($ll->BaseArticleID != "") {
                $sel = $ll;
                $json['status_code'] = 1;

                //isi yang asli
                $obj2 = new LL_Article_WImage();
                $exp2 = explode(",", $obj2->crud_webservice_allowed);

                $sem = array();
                foreach ($exp2 as $attr2) {
                    $sem[$attr2] = $sel->$attr2;
                }
                $json['results'] = $sem;

                //biar tidak hitung ulang
                if ($sel->ArticleType == 'Base') {
                    $json['base'] = $sem;
                } else {
                    //isi base
                    $arrID = $sel->BaseArticleID;
                    $arr2 = $ll->getWhere("BaseArticleID = '$arrID' AND ArticleType = 'Base'  LIMIT 0,1");
                    $base = $arr2[0];

                    $sem2 = array();
                    foreach ($exp2 as $attr2) {
                        $sem2[$attr2] = $base->$attr2;
                    }
                    $json['base'] = $sem2;
                }


                echo json_encode($json);
                die();

            } else {
                $json['status_code'] = 0;
                $json['status_message'] = "No Results found";
                echo json_encode($json);
                die();
            }
        }//if ean
        else{
            $json['status_code'] = 0;
            $json['status_message'] = "No Results found";
            echo json_encode($json);
            die();
        }
    }
}
