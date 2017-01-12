<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TextP
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TextP {
    public static function getP($id,$default_value = ''){
        $a = isset($_GET[$id])?addslashes($_GET[$id]):$default_value;
        return $a;
    }
    public static function postP($id,$default_value = ''){
        $a = isset($_POST[$id])?addslashes($_POST[$id]):$default_value;
        return $a;
    }
    public static function reqP($id,$default_value = ''){
        $a = isset($_REQUEST[$id])?addslashes($_REQUEST[$id]):$default_value;
        return $a;
    }
}
