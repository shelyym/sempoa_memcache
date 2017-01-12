<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/31/16
 * Time: 8:42 PM
 */

class KomisiWeb extends WebService{

    var $access_BagiKomisi = "master_admin";
    public function BagiKomisi ()
    {
        //create the model object
        $cal = new BagiKomisi();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        Crud::run($cal, $webClass);
    }
    var $access_BonusKomisi = "master_admin";
    public function BonusKomisi ()
    {
        //create the model object
        $cal = new BonusKomisi();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        Crud::run($cal, $webClass);
    }
    var $access_KomisiModel = "master_admin";
    public function KomisiModel ()
    {
        //create the model object
        $cal = new KomisiModel();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        Crud::run($cal, $webClass);
    }
} 