<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/31/16
 * Time: 8:31 PM
 */

class PayWeb extends WebService{


    var $access_VpTransaction = "master_admin";
    public function VpTransaction ()
    {
        //create the model object
        $cal = new VpTransaction();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        Crud::run($cal, $webClass);
    }

    var $access_VpData = "master_admin";
    public function VpData ()
    {
        //create the model object
        $cal = new VpData();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        Crud::run($cal, $webClass);
    }
} 