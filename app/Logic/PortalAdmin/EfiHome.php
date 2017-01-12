<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author User
 */
class EfiHome extends WebApps {
    
    
    var $access_home = "admin";
    function home ()
    {
        //echo "in";
        Registor::redirectOpenLW("EfiHome", "EfiHome/homeLoad");
    }

    /*
     * Default Landing Page as User Got Into admin site
     */
    function homeLoad ()
    {
        //Mold::both("mainmenu");
        
        exit();
    }

    function p404 ()
    {

        echo $_GET['msg'];
        die();
    }

   
}
