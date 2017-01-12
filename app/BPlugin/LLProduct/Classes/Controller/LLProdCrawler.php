<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LLProdCrawler
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LLProdCrawler extends WebService{

    var $ip_address = "http://192.168.0.35:8280/";
    function __construct() {
        $this->ip_address = Efiwebsetting::getData('GoldAPI');
    }
    function article(){
        //$LL = new LL_Article;
        //$LL->printColumlistAsAttributes();
        
        $url = "http://192.168.0.86:8180/goldwebapi/ecommerce/article";
        $data = file_get_contents($url);
        $data = json_decode($data, true); // Turns it into an array, change the last argument to false to make it an ob
        
        //pr($data);
        
        foreach($data as $ro){
            $ll = new LL_Article();
           
            $ll->fill($ro);
            pr($ll);
            $ll->save();
        }
    }
    //
    
    function articletagging(){
        $LL = new LL_ArticleTagging();
        $LL->printColumlistAsAttributes();
        
        $url = "http://192.168.0.86:8180/goldwebapi/ecommerce/articletagging";
        $data = file_get_contents($url);
        $data = json_decode($data, true); // Turns it into an array, change the last argument to false to make it an ob
        
        //pr($data);
        
        foreach($data as $ro){
            $ll = new LL_ArticleTagging();
           
            $ll->fill($ro);
            $ll->rel_id = $ro['ArticleID']."_".$ro['TaggingLevel3ID'];
            $ll->save();
            pr($ll);
        }
    }
    
    
    function articleWImage(){
        //$LL = new LL_Article;
        //$LL->printColumlistAsAttributes();
        $ll = new LL_Article_WImage();
        if($_GET['truncate'])$ll->truncate();

        $ean2 = new LL_Article_EAN();
        if($_GET['truncate'])$ean2->truncate();

//        $url = "http://192.168.0.86:8180/goldwebapi/ecommerce/article";
        //$url = "http://192.168.0.86:8880/goldwebapi/ecommerce/article";
        $url = $this->ip_address."GOLDEcomm/Article";
        $data = file_get_contents($url);
        $data = json_decode($data, true); // Turns it into an array, change the last argument to false to make it an ob
        
        //pr($data);
        //pr($data);
        $counter = 0;
        $yangdisave = 0;
        $eandisave = 0;
        $eandicrawl = 0;
        foreach($data as $ro){
            $ll = new LL_Article_WImage();
           
            $ll->fill($ro);
           pr($ll);
            if($ll->save()){
//                echo $ll->VariantID."<br>";
//                echo $ll->VariantEAN."<br>";
                $yangdisave++;
                //split EAN ke table EAN


                $split = explode(";",$ll->VariantEAN);
                foreach($split as $ee){
                    $eandicrawl++;
//                    echo "ean : ".$ee." ";
                    $ean = new LL_Article_EAN();
                    $ean->ean_id = $ee;
                    $ean->var_id = $ll->VariantID;
                    if($ean->save()){
                        $eandisave++;
                    }else{
                        echo "eanfailed ".$ee." <br>";
                    }
//                    echo "<br>";
                }

            }else{
                echo "gagal ".$ll->VariantID."<br>";
            }
            $counter++;
        }
        echo "Jumlah yang di crawl : ".$counter."<br>";
        echo "Jumlah yang di save : ".$yangdisave."<br>";
        echo "Jumlah EAN yang di crawl : ".$eandicrawl."<br>";
        echo "Jumlah EAN yang di save : ".$eandisave."<br>";
    }
    function tagging(){
        $LL = new LL_Tagging();
        //$LL->printColumlistAsAttributes();
        if($_GET['truncate'])$LL->truncate();
        
//        $url = "http://192.168.0.86:8880/goldwebapi/ecommerce/tagging";
//        $url = "http://192.168.0.86:8180/goldwebapi/ecommerce/tagging";
        $url = $this->ip_address."GOLDEcomm/Tagging";

        $data = file_get_contents($url);
        $data = json_decode($data, true); // Turns it into an array, change the last argument to false to make it an ob
        
        //pr($data);
        $counter = 0;
        $yangdisave = 0;
        foreach($data as $ro){
            $ll = new LL_Tagging();
           
            $ll->fill($ro);
            //pr($ll);
            $ll->reltag_id = $ro['TaggingLevel1ID']."_".$ro['TaggingLevel2ID']."_".$ro['TaggingLevel3ID'];
            if($ll->save()){
                echo $ll->reltag_id."<br>";
                $yangdisave++;
            }
            $counter++;
        }
        echo "Jumlah yang di crawl : ".$counter."<br>";
        echo "Jumlah yang di save : ".$yangdisave."<br>";
    }
    
    
    
    function articletaggingWBase(){
        $LL = new LL_ArticleTagging_wbase();
        //$LL->printColumlistAsAttributes();
        if($_GET['truncate'])$LL->truncate();
        
//        $url = "http://192.168.0.86:8180/goldwebapi/ecommerce/articletagging";
//        $url = "http://192.168.0.86:8880/goldwebapi/ecommerce/articletagging";
        $url = $this->ip_address."GOLDEcomm/ArticleTagging";
        $data = file_get_contents($url);
        $data = json_decode($data, true); // Turns it into an array, change the last argument to false to make it an ob
        
        //pr($data);
        $counter = 0;
        $yangdisave = 0;
        foreach($data as $ro){
            $ll = new LL_ArticleTagging_wbase();
           
            $ll->fill($ro);
            $ll->rel_id = $ro['BaseArticleID']."_".$ro['TaggingLevel3ID'];
            if($ll->save()){
                echo $ll->rel_id."<br>";
                $yangdisave++;
            }
            $counter++;
            //pr($ll);
        }
        echo "Jumlah yang di crawl : ".$counter."<br>";
        echo "Jumlah yang di save : ".$yangdisave."<br>";
    }
}
