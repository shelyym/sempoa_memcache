<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/1/16
 * Time: 8:39 PM
 */

class UserWeb3 extends WebService{

    static  $lvl = "ibo";
    static  $webclass = "UserWeb3";
    static  $orgModel = "TorgIBO";

    function read_user_ibo(){
        UserWebContainer::read_user(self::$lvl,self::$webclass);
    }

    function update_user_ibo(){
        UserWebContainer::update_user(self::$lvl,self::$webclass,self::$orgModel);
    }
    function delete_user_ibo(){

    }
    function create_user_ibo(){
        UserWebContainer::create_user(self::$lvl,self::$webclass,self::$orgModel);
    }
    function read_user_grup_ibo(){
        UserWebContainer::read_user_grup(self::$lvl,self::$webclass);
    }
    function update_user_grup_ibo(){
        UserWebContainer::update_user_grup(self::$lvl);
    }
    function delete_user_grup_ibo(){

    }
    function create_user_grup_ibo(){
       UserWebContainer::create_user_grup(self::$lvl,self::$webclass);
    }
} 