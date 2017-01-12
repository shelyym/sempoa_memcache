<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/22/15
 * Time: 3:14 PM
 */

class PaymentBE extends WebService {

    var $access_PaymentConfirm = "admin";
    public function PaymentConfirm ()
    {
        //create the model object
        $cal = new PaymentConfirm();
        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
} 