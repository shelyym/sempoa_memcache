<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mobile
 *
 * @author User
 */
class Mobile {
    public static function setCookie ()
    {
        setcookie("isMobile", self::isMob(), time() + 60 * 60 * 24 * 365, '/');
    }

    public static function isMob ()
    {
        $mob = (isset($_SESSION['isMobile']) ? $_SESSION['isMobile'] : 0);

        return $mob;
    }

    public static function getCookie ()
    {
        return (isset($_COOKIE['isMobile']) ? $_COOKIE['isMobile'] : self::isMob());
    }

    public static function checkGetMobile ()
    {
        if (isset($_GET['tomobile'])) {
            if ($_GET['tomobile'] == 1) {
                Mobile::setMobile(1);
            }
            if ($_GET['tomobile'] == 0) {
                Mobile::setMobile(0);
            }
        }
    }

    public static function setMobile ($set)
    {
        $_SESSION['isMobile'] = $set;
    }
}
