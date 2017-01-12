<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StoreCrawler
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class StoreCrawlerWeb extends WebService{
    //put your code here
    public $url = "http://portal.thebodyshop.co.id/StorePortalWeb/StorePortal?cmd=ws&mws=getall";
    
    public function renew(){
        //echo  "in";
        $data = file_get_contents($this->url);
        $data = json_decode($data, true);
        //pr($data);
        
        foreach($data['results'] as $r){
            $store = new StorePortal();
            $store->getByID($r['No']);
            if($store->Site == "")$store->load = 0;
            $store->fill($r);
            //pr($store);
            echo $store->Site." : ".$store->save()."<br>";
            //exit();
        }
    }
    public function langsung(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();

        $url = Efiwebsetting::getData("Portal_IP")."PortalWeb/StorePortal?cmd=ws&mws=getall";

        $data = file_get_contents($url);
        echo $data;
        exit();
    }
}
