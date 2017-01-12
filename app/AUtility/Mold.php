<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mold
 * Molding untuk cetakan tampilang supaya einheiltlich...
 *
 * @author Elroy Hardoyo
 */
class Mold {
    /*
     * make mold only for desktop version
     */
    public static function mob ($act, $arr = array ())
    {
        if (count($arr) > 0) {
            extract($arr);
        }
        $pathname = self::explodeSlash($act);
        include $pathname;
    }

    /*
     * make mold only for mobile version
     */

    public static function explodeSlash ($str)
    {
        $exp = explode("/", $str);
        $filename = array_pop($exp);
        $sisanya = implode("/", $exp);
        $arr = array ("filename" => $filename, "path" => $sisanya);
        $pathJadi = _THEMEPATH . "/Mold/" . $arr['path'] . "/mobile-" . $arr['filename'] . ".php";

        return $pathJadi;
    }

    /*
     * make mold only for both mobile and desktop version
     */

    public static function both ($act, $arr = array ())
    {
        if (count($arr) > 0) {
            extract($arr);
        }
        if (Mobile::isMob()) {
            $pathname = self::explodeSlash($act);
            if (!@include $pathname) {
                self::desk($act, $arr);
            }
        } else {
            self::desk($act, $arr);
        }

    }

    public static function desk ($act, $arr = array ())
    {
        if (count($arr) > 0) {
            extract($arr);
        }
       // include _THEMEPATH . "/mold/" . $act . ".php";
        include "Mold/" . $act . ".php";
    }

    public static function plugin ($pluginname, $act, $arr = array ())
    {
        if ($pluginname == "" || !isset($pluginname) || !isset($act)) {
            die('Plugin Name Empty');
        }
        if (count($arr) > 0) {
            extract($arr);
        }
        
        //first check if theme has the mold
        if (!@include _THEMEPATH."/Mold/{$pluginname}/" . $act . ".php") {
               include "app/BPlugin/$pluginname/Mold/" . $act . ".php";
        }
        
    }
    
    public static function theme ($act, $arr = array ())
    {
        
        if (count($arr) > 0) {
            extract($arr);
        }
        include _THEMEPATH."/Mold/" . $act . ".php";
    }
}
