<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/26/16
 * Time: 5:26 PM
 */

class SempoaOrgWeb extends WebService{

    public function SempoaOrg ()
    {
        //create the model object
        $cal = new SempoaOrg();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
} 