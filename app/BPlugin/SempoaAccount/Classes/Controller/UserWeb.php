<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/28/16
 * Time: 2:12 PM
 */

class UserWeb extends WebService{

    static  $lvl = "kpo";
    static  $webclass = "UserWeb";
    static  $orgModel = "TorgKPO";

    function read_user_kpo(){
        UserWebContainer::read_user(self::$lvl,self::$webclass);
    }

    function update_user_kpo(){
        UserWebContainer::update_user(self::$lvl,self::$webclass,self::$orgModel);
    }
    function delete_user_kpo(){

    }
    function create_user_kpo(){
        UserWebContainer::create_user(self::$lvl,self::$webclass,self::$orgModel);
    }
    function read_user_grup_kpo(){
        UserWebContainer::read_user_grup(self::$lvl,self::$webclass);
    }
    function update_user_grup_kpo(){
        UserWebContainer::update_user_grup(self::$lvl);
    }
    function delete_user_grup_kpo(){

    }
    function create_user_grup_kpo(){
        UserWebContainer::create_user_grup(self::$lvl,self::$webclass);
    }


} 