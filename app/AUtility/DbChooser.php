<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DbChooser
 *
 * @author User
 */
class DbChooser {

    public static function setDBSelected ()
    {
        $sekolah = (isset($_POST['sekolah']) ? addslashes($_POST['sekolah']) : "");

        if ($sekolah != "") {
            $_SESSION['school'] = $sekolah;
        }
        if (!isset($_SESSION['school'])) {
            $_SESSION['school'] = "mhssd"; //default db value atau lihat di access aja ya ?
        }
    }

    public static function setCookie ()
    {
        setcookie("school", self::getDBSelected(), time() + 60 * 60 * 24 * 365, '/');
    }

    public static function getDBSelected ()
    {
        return $_SESSION['school'];
    }

    public static function setDBChooser ($id)
    {
        $_SESSION['school'] = $id;
    }

    public static function getCookie ()
    {
        return (isset($_COOKIE['school']) ? $_COOKIE['school'] : self::getDBSelected());
    }
}
