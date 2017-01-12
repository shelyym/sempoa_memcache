<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/3/15
 * Time: 1:52 PM
 */

class MCampBE extends WebService{

    public function AdminCampaignModel ()
    {
        //create the model object
        $cal = new AdminCampaignModel();
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        Crud::run($cal, $webClass);
    }


} 