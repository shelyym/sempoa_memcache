<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LLAccWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LLAccWeb extends WebService{

    var $access_LL_Account = "admin";
    public function LL_Account ()
    {
        //create the model object
        $cal = new LL_Account();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    var $access_LL_Account_Gab = "admin";
    public function LL_Account_Gab ()
    {
        //create the model object
        $cal = new LL_Account_Gab();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    var $access_LL_AccStatement = "admin";
    public function LL_AccStatement ()
    {
        //create the model object
        $cal = new LL_AccStatement();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    var $access_LL_TransactionDetail = "admin";
    public function LL_TransactionDetail ()
    {
        //create the model object
        $cal = new LL_TransactionDetail();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }


}
