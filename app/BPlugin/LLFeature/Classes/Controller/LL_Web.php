<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LL_Web
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_Web extends WebService
{

    var $access_LL_Program = "admin";
    public function LL_Program()
    {
        //create the model object
        $cal = new LL_Program();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    var $access_LL_News = "admin";
    public function LL_News()
    {
        //create the model object
        $cal = new LL_News();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

//    var $access_LL_Wishlist = "admin";
    public function LL_Wishlist()
    {
        //create the model object
        $cal = new LL_Wishlist();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

//    var $access_LL_Testimonial = "admin";
    public function LL_Testimonial()
    {
        //create the model object
        $cal = new LL_Testimonial();
        //send the webclass 
        $webClass = __CLASS__;
        if($_GET['sort']=="")$_GET['sort'] = "testi_createdate DESC";
        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    var $access_LL_RewardCatalog = "admin";
    public function LL_RewardCatalog()
    {
        //create the model object
        $cal = new LL_RewardCatalog();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

//    var $access_LL_Tnc = "admin";
    public function LL_Tnc()
    {
        //create the model object
        $cal = new LL_Tnc();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
}
