<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/29/16
 * Time: 2:59 PM
 */

class BnlWeb extends WebService{

    var $access_BannerModel = "admin";
    function BannerModel(){

        $cal = new BannerModel();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

    }

    var $access_LevelModel = "admin";
    function LevelModel(){

        $cal = new LevelModel();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

    }
} 