<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LLProdWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LLProdWeb extends WebService{
    var $access_LL_Article = "admin";
    public function LL_Article ()
    {
        //create the model object
        $cal = new LL_Article();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    var $access_LL_ArticleTagging = "admin";
    public function LL_ArticleTagging ()
    {
        //create the model object
        $cal = new LL_ArticleTagging();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    var $access_LL_Tagging = "admin";
    public function LL_Tagging ()
    {
        //create the model object
        $cal = new LL_Tagging();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    
    public function test(){
        $ll = new LL_RewardCatalog();
        $ll->printColumlistAsAttributes();
    }
    public function testPost(){
        $data['test'] = "halo";
        $data['a'] = "bb";
        $data_string = "para1=val1&para2=val2";
        //echo  "hahaha";
        //pr($data_string);
        $url = "http://localhost/leapmobile/LLProdWeb/testSet";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        
        $result = curl_exec($ch);
       //pr($result);
        $result = json_decode($result);
        pr($result);
    }
    public function testSet(){
        
        $li = new LL_Article_WImage();
        $li->printColumlistAsAttributes();
        
        $json = $_POST;
        //$obj = json_decode($json);
        $json['json'] = $json;
        //$json['obj'] = $obj;
        $json['status'] = 1;
        echo json_encode($json);
        die();
    }

//    var $access_LL_Article_WImage = "admin";
    public function LL_Article_WImage ()
    {
        //create the model object
        $cal = new LL_Article_WImage();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    var $access_LL_ArticleTagging_wbase = "admin";
    public function LL_ArticleTagging_wbase ()
    {
        //create the model object
        $cal = new LL_ArticleTagging_wbase();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    
    // custom webservices
    public function get1stLevelCat(){
        $ll = new LL_Tagging();
        global $db;
        $q = "SELECT DISTINCT TaggingLevel1ID,TaggingLevel1Name FROM {$ll->table_name}";
        $arr = $db->query($q,2);
        //pr($arr);
        $obj = $ll;
       
        if(count($arr)<1){
            $json['status_code'] = 0;
            $json['status_message'] = "Not Found";
            echo json_encode($json);
            die();
        }

        $obj->default_read_coloms = $obj->crud_webservice_allowed;
        $main_id = $obj->main_id;
        $exp = explode(",",$obj->crud_webservice_allowed);
        
        $json = array();
        $json['status_code'] = 1;
        
        //filter
        foreach($arr as $o){
           $sem = array();
           foreach($exp as $attr){
               $sem[$attr] = $o->$attr;
           }
           $json["results"][] = $sem;
        }
        if(count($arr)<1){
            $json['status_code'] = 0;
            $json['status_message'] = "No Elements Found";
        }

        echo json_encode($json);
        die();
    }
    
    // custom webservices
    public function get2ndLevelCat(){
        $firstID = addslashes($_GET['id']);
        if($firstID==""){
            $json['status_code'] = 0;
            $json['status_message'] = "ID Not Found";
            echo json_encode($json);
            die();
        }
        
        $ll = new LL_Tagging();
        global $db;
        $q = "SELECT DISTINCT TaggingLevel2ID,TaggingLevel2Name FROM {$ll->table_name} WHERE TaggingLevel1ID = '$firstID'";
        $arr = $db->query($q,2);
        //pr($arr);
        $obj = $ll;
       
        

        $obj->default_read_coloms = $obj->crud_webservice_allowed;
        $main_id = $obj->main_id;
        $exp = explode(",",$obj->crud_webservice_allowed);
        
        $json = array();
        $json['status_code'] = 1;
        
        //filter
        foreach($arr as $o){
           $sem = array();
           foreach($exp as $attr){
               $sem[$attr] = $o->$attr;
           }
           $json["results"][] = $sem;
        }
        if(count($arr)<1){
            $json['status_code'] = 0;
            $json['status_message'] = "No Elements Found";
        }

        echo json_encode($json);
        die();
    }
    
    // custom webservices
    public function get3rdLevelCat(){
        $firstID = addslashes($_GET['id']);
        if($firstID==""){
            $json['status_code'] = 0;
            $json['status_message'] = "ID Not Found";
            echo json_encode($json);
            die();
        }
        
        $ll = new LL_Tagging();
        global $db;
        $q = "SELECT  * FROM {$ll->table_name} WHERE TaggingLevel2ID = '$firstID'";
        $arr = $db->query($q,2);
        //pr($arr);
        $obj = $ll;
       
        

        $obj->default_read_coloms = $obj->crud_webservice_allowed;
        $main_id = $obj->main_id;
        $exp = explode(",",$obj->crud_webservice_allowed);
        
        $json = array();
        $json['status_code'] = 1;
        
        //filter
        foreach($arr as $o){
           $sem = array();
           foreach($exp as $attr){
               $sem[$attr] = $o->$attr;
           }
           $json["results"][] = $sem;
        }
        if(count($arr)<1){
            $json['status_code'] = 0;
            $json['status_message'] = "No Elements Found";
        }

        echo json_encode($json);
        die();
    }
    
    // custom webservices
    public function getCategory(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();

        $ll = new LL_Tagging();
        
        $arr = $ll->getOrderBy("TaggingLevel1Order ASC, TaggingLevel2Order ASC, TaggingLevel3Order ASC");
        //pr($arr);
        $obj = $ll;
       
        if(count($arr)<1){
            $json['status_code'] = 0;
            $json['status_message'] = "Not Found";
            echo json_encode($json);
            die();
        }
        $sudah = array();
        $detail = array();
        $urutan = array();
        //saveYg1stLevelSama
        foreach($arr as $obj){
            $sudah[$obj->TaggingLevel1ID][$obj->TaggingLevel2ID][] = $obj->TaggingLevel3ID;
            $detail[$obj->TaggingLevel1ID] = $obj->TaggingLevel1Name;
            $detail[$obj->TaggingLevel2ID] = $obj->TaggingLevel2Name;
            $detail[$obj->TaggingLevel3ID] = $obj->TaggingLevel3Name;
            $urutan[$obj->TaggingLevel1ID] = (int)$obj->TaggingLevel1Order;
            $urutan[$obj->TaggingLevel2ID] = (int)$obj->TaggingLevel2Order;
            $urutan[$obj->TaggingLevel3ID] = (int)$obj->TaggingLevel3Order;
        }
        
        
        $json = array();
        $json['status_code'] = 1;
        $json['layer'] = $sudah;
        $json['detail'] = $detail;
        $json['urutan'] = $urutan;
        
        if(count($arr)<1){
            $json['status_code'] = 0;
            $json['status_message'] = "No Elements Found";
        }

        echo json_encode($json);
        die();
    }
    
    public function getItemsUsing3rdTag(){
        $id = addslashes($_GET['id']);
        if($id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "ID Not Found";
            echo json_encode($json);
            die();
        }
        $basetext = "";
        if($_GET['type'] == "base")$basetext = "AND ll__article_with_image.ArticleType = 'Base'";
        $ll = new LL_ArticleTagging_wbase();
        $whereClause = "ll__articletagging_with_base.BaseArticleID = ll__article_with_image.BaseArticleID $basetext AND ll__articletagging_with_base.TaggingLevel3ID = '$id'";
        //echo $whereClause;
        
        $arr = $ll->getWhereFromMultipleTable($whereClause, array("LL_Article_WImage"), "*");
        
        //pr($arr);
        
        //$arr2 = $ll->getWhere("ll__articletagging.TaggingLevel3ID = '$id'");
        //pr($arr2);
        
        $obj2 = new LL_Article_WImage();
        $exp2 = explode(",",$obj2->crud_webservice_allowed);
        
        $obj = $ll;
        $obj->default_read_coloms = $obj->crud_webservice_allowed;
        $main_id = $obj->main_id;
        $exp = explode(",",$obj->crud_webservice_allowed);
        
        $json = array();
        $json['status_code'] = 1;
        
        //filter
        foreach($arr as $o){
           $sem = array();
           foreach($exp as $attr){
               $sem[$attr] = $o->$attr;
               foreach($exp2 as $attr2){
                   $sem[$attr2] = $o->$attr2;
               }
           }
           $json["results"][] = $sem;
        }
        
        if($_GET['type'] == "base" && $_GET['getvar'] == 1){
            $arrsem = array();
            
            foreach($json['results'] as $base){
                $baseID = $base['BaseArticleID'];
                $arr5 = $obj2->getWhere("BaseArticleID = '{$baseID}'");
                
                
                foreach($arr5 as $o){
                    $sem = array();
                    foreach($exp2 as $attr2){
                       $sem[$attr2] = $o->$attr2;
                    }
                    $base['variants'][] = $sem;
                }
                $arrsem[] = $base;
            }            
            $json['results'] = $arrsem;
        }
        
        
        if(count($arr)<1){
            $json['status_code'] = 0;
            $json['status_message'] = "No Elements Found";
        }

        echo json_encode($json);
        die();
    }
    
}
