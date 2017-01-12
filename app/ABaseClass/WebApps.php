<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebApps
 *
 * @author User
 */
class WebApps extends \Leap\Control\WebApps {
    //put your code here
    function p404 ()
    {
        PageError::p404();
    }
}
