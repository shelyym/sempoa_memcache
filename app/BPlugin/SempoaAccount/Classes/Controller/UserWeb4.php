<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/1/16
 * Time: 9:54 PM
 */

class UserWeb4 extends WebService{

    static  $lvl = "tc";
    static  $webclass = "UserWeb4";
    static  $orgModel = "TorgTC";

    /*
     * [0] =>
                            [1] =>
                            [2] => read_user_tc
                            [3] => update_user_tc
                            [4] =>
                            [5] =>
                            [6] =>
                            [7] =>
     */
    function read_user_tc(){
        UserWebContainer::read_user(self::$lvl,self::$webclass);
    }

    function update_user_tc(){
        UserWebContainer::update_user(self::$lvl,self::$webclass,self::$orgModel);
    }
    function delete_user_tc(){

    }
    function create_user_tc(){
        UserWebContainer::create_user(self::$lvl,self::$webclass,self::$orgModel);
    }
    function read_user_grup_tc(){
        UserWebContainer::read_user_grup(self::$lvl,self::$webclass);
    }
    function update_user_grup_tc(){
        UserWebContainer::update_user_grup(self::$lvl);
    }
    function delete_user_grup_tc(){

    }
    function create_user_grup_tc(){
        UserWebContainer::create_user_grup(self::$lvl,self::$webclass);
    }
} 