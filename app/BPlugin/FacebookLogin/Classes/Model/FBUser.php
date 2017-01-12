<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FBUser
 *
 * @author User
 */
class FBUser extends Model {
    public $table_name = "core__fb_userdata";
    public $main_id = "data_id";
    
    var $default_read_coloms = "data_id,email,name";
    var $coloumlist = "data_id,email,name,link";
    public $data_id;
    public $email;
    public $first_name;
    public $last_name;
    public $name;
    public $fb_id;
    public $link;
    public $locale;
    public $timezone;
    public $updated_time;
    public $verified;
    public $tm_logintime;
    public $tm_creationdate;
    public $data_pass;
    
    public function saveFromJS(){
        $user = json_decode($_POST['user']);
        //pr($user);
        $fb = new FBUser();
        $fb->fill(toRow($user));
        //pr($fb);
        $fb->save();
        $fb->saveToSession();
    }
    public function saveToSession(){
        //perlu ga ya ?
        $_SESSION['fblogged'] = 1;
        $_SESSION['fbuser'] = $this;
        //pr($_SESSION);
    }
    public function checkIfLogged(){
        return $_SESSION['fblogged'];
    }
    public function getCurrentUser(){
        return $_SESSION['fbuser'];
    }
    public function getCurrentID(){
        return $_SESSION['fbuser']->data_id;
    }
    public static function register(){
        $fname = addslashes($_POST['fname']);
        $lname = addslashes($_POST['lname']);
        $emailadd = addslashes($_POST['emailadd']);
        $p1 = addslashes($_POST['p1']);
        $p2 = addslashes($_POST['p2']);
        
        $fbuser = new FBUser();
        $fbuser->email = $emailadd;
        $fbuser->first_name = $fname;
        $fbuser->last_name = $lname;
        $fbuser->name = $fname." ".$lname;
        $fbuser->data_pass = $p1;
        return $fbuser->save();
    }
    public static function login(){
        $emailadd = addslashes($_POST['emailadd']);
        $p1 = addslashes($_POST['p1']);
        $fbuser = new FBUser();
        $arr = $fbuser->getWhere("email = '$emailadd' AND data_pass = '$p1'");
        if(count($arr)>0){
            $user = $arr[0];
            $_SESSION['user'] = $user;
            $_SESSION["admin_session"] = 1;
        }
    }
}
