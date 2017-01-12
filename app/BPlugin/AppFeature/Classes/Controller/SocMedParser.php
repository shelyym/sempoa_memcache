<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/28/16
 * Time: 2:22 PM
 */

class SocMedParser extends WebService{

    function fb(){

        $pageID = addslashes($_REQUEST['pid']);

        $json = LeapFacebook::getPostswID($pageID);
//        pr($json);

        echo $json;
        die();
    }

    function tw(){
        $pageID = addslashes($_REQUEST['pid']);

        $json = LeapTwitter::getTweetswID($pageID);

        echo $json;
        die();
    }
    function yt(){
        $pageID = addslashes($_REQUEST['pid']);

        $json = LeapYoutube::getPostswID($pageID);

        echo $json;
        die();
    }
} 