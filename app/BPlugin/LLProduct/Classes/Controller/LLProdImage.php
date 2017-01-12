<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LLProdImage
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LLProdImage extends WebService{
    
    
    public function getImage(){
        $id = addslashes($_GET['id']);
        $type = addslashes($_GET['type']);
        //if($id == "")die("no id");
        if($id == "" || $id <1){
            $json['status_code'] = 0;
            $json['status_message'] = "No ID";
            echo json_encode($json);
            die();
        }
        $ll = new LL_Article_WImage();
        $ll->getByID($id);
        
        if($type != 1)$type = 2;
        
        if($type == 1)$dipil = "BaseArticleImageFile";
        else $dipil = "VariantImageFile";
        
//        $remoteImage = "http://192.168.0.86/ImageRepository/Article/Images/".$ll->$dipil;
        $remoteImage = Efiwebsetting::getData('ImageRepositoryURL').$ll->$dipil;
        $imginfo = getimagesize($remoteImage);
        header("Content-type: ".$imginfo['mime']);
        readfile($remoteImage);
        exit();
    }
    
    public function getImageWithBaseArticleID(){
        $id = addslashes($_GET['id']);
        $type = addslashes($_GET['type']);
        //if($id == "")die("no id");
        if($id == "" || $id <1){
            $json['status_code'] = 0;
            $json['status_message'] = "No ID";
            echo json_encode($json);
            die();
        }
        $ll = new LL_Article_WImage();
        $arr = $ll->getWhere("BaseArticleID = '$id' AND ArticleType = 'Base' LIMIT 0,1");
        $ll = $arr[0];
        
        if($type != 1)$type = 2;
        
        if($type == 1)$dipil = "BaseArticleImageFile";
        else $dipil = "VariantImageFile";
        
//        $remoteImage = "http://192.168.0.86/ImageRepository/Article/Images/".$ll->$dipil;
        $remoteImage = Efiwebsetting::getData('ImageRepositoryURL').$ll->$dipil;
        $imginfo = getimagesize($remoteImage);
        header("Content-type: ".$imginfo['mime']);
        readfile($remoteImage);
        exit();
    }
    
    public function getImageJPG($args){
        //$id = addslashes($_GET['id']);
        list($id) = $args;
        //echo $id;
        //$type = addslashes($_GET['type']);
        //if($id == "")die("no id");
        if($id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No ID";
            echo json_encode($json);
            die();
        }
        /*$ll = new LL_Article_WImage();
        $arr = $ll->getWhere("BaseArticleID = '$id' AND ArticleType = 'Base' LIMIT 0,1");
        $ll = $arr[0];
        
        if($type != 1)$type = 2;
        
        if($type == 1)$dipil = "BaseArticleImageFile";
        else $dipil = "VariantImageFile";
        */
//        $remoteImage = "http://192.168.0.86/ImageRepository/Article/Images/".$id;
        $remoteImage = Efiwebsetting::getData('ImageRepositoryURL').$id;
        $imginfo = getimagesize($remoteImage);
        header("Content-type: ".$imginfo['mime']);
        readfile($remoteImage);
        exit();
    }
}
