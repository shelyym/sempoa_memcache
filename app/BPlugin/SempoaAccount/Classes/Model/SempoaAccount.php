<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/27/16
 * Time: 2:55 PM
 */

class SempoaAccount extends Account{

    var $default_read_coloms = "admin_id,admin_username,admin_nama_depan,admin_email,admin_role,admin_org_type,admin_org_id,admin_ak_id,admin_kpo_id,admin_ibo_id,admin_tc_id";
//masi copy paste
var $uname_min = 5;
var $uname_max = 15;

var $passwd_min = 5;
var $passwd_max = 15;

    var $admin_ak_id;
    var $admin_kpo_id;
    var $admin_ibo_id;
    var $admin_tc_id;

    var $coloumlist = "admin_id,admin_username,admin_nama_depan,admin_password,admin_lastupdate,admin_reg_date,admin_aktiv,admin_email,admin_role,admin_type,admin_webpassword,admin_org_type,admin_org_id,admin_ak_id,admin_kpo_id,admin_ibo_id,admin_tc_id";
    public $hideColoums = array("admin_kpo_id");

    function form_constraints(){

        //err id => err msg
        $err = array ();

        if (!isset($this->admin_email) || $this->admin_email == "") {
            $err['admin_email'] = Lang::t('err admin_email empty');
        }else{
            if (!filter_var($this->admin_email, FILTER_VALIDATE_EMAIL)) {
                $err['admin_email'] =  "Invalid Email Address";
            }
        }
        if (!isset($this->admin_nama_depan) || $this->admin_nama_depan == "") {
            $err['admin_nama_depan'] = Lang::t('err admin_nama_depan empty');
        }
        if (!isset($this->admin_org_id) || $this->admin_org_id == "") {
            $err['admin_org_id'] = Lang::t('err admin_org_id empty');
        }
        if (!isset($this->admin_org_type) || $this->admin_org_type == "") {
            $err['admin_org_type'] = Lang::t('err admin_org_type empty');
        }
        if (!isset($this->admin_password) || $this->admin_password == "") {
            $err['admin_password'] = Lang::t('err admin_password empty');
        }else{
            if(strlen($this->admin_password)<$this->passwd_min || strlen($this->admin_password)>$this->passwd_max){
                $err['admin_password'] = "The password has the wrong length. Min {$this->passwd_min} Max {$this->passwd_max} Characters.";
            }
        }
        if (!isset($this->admin_password2) || $this->admin_password2 == "") {
            $err['admin_password2'] = Lang::t('err admin_password2 empty');
        }else{
            if(strlen($this->admin_password2)<$this->passwd_min || strlen($this->admin_password2)>$this->passwd_max){
                $err['admin_password2'] = "The password has the wrong length. Min {$this->passwd_min} Max {$this->passwd_max} Characters.";
            }else{
                if($this->admin_password == $this->admin_password2){
                    $crypt = Account::cryptPassword($this->admin_password);
                    $this->admin_password = $crypt;
                    $this->admin_webpassword = $crypt;
                }else{
                    $err['admin_password'] = "Password mismatched";
                    $err['admin_password2'] = "Password mismatched";
                }
            }
        }
        if (!isset($this->admin_role) || $this->admin_role == "") {
            $err['admin_role'] = Lang::t('err admin_role empty');
        }
//        pr($this);pr($err);
        /*if (!isset($this->admin_id)) {
            $err['admin_username'] = Lang::t('Create New User Not Allowed');
        }*/
        if(count($err)<1){
            //cari apakah username terpakai
            $nr = $this->getJumlah("admin_email = '{$this->admin_email}'");
            if ($nr > 0) {
                $err['admin_email'] = Lang::t("Email is already being registered.");
            }else{
                $this->admin_username = $this->admin_email;
                $this->admin_aktiv = 1;
                $this->admin_lastupdate = leap_mysqldate();
                $this->admin_reg_date = leap_mysqldate();
            }
        }

        return $err;

    }

    function form_constraints_edit(){

        //err id => err msg
        $err = array ();

//        if (!isset($this->admin_id) || $this->admin_id == "") {
//            $err['all'] = Lang::t('err admin_id empty');
//        }
//        else{
//            $this->getByID($this->admin_id);
//        }
        if (!isset($this->admin_email) || $this->admin_email == "") {
            $err['admin_email'] = Lang::t('err admin_email empty');
        }else{
            if (!filter_var($this->admin_email, FILTER_VALIDATE_EMAIL)) {
                $err['admin_email'] =  "Invalid Email Address";
            }
        }
        if (!isset($this->admin_nama_depan) || $this->admin_nama_depan == "") {
            $err['admin_nama_depan'] = Lang::t('err admin_nama_depan empty');
        }
        if (!isset($this->admin_org_id) || $this->admin_org_id == "") {
            $err['admin_org_id'] = Lang::t('err admin_org_id empty');
        }
        if (!isset($this->admin_org_type) || $this->admin_org_type == "") {
            $err['admin_org_type'] = Lang::t('err admin_org_type empty');
        }
        if ($this->admin_password != "" && $_POST['admin_password']!="") {

            if(strlen($this->admin_password)<$this->passwd_min || strlen($this->admin_password)>$this->passwd_max){
                $err['admin_password'] = "The password has the wrong length. Min {$this->passwd_min} Max {$this->passwd_max} Characters.";
            }else{
                $crypt = Account::cryptPassword($this->admin_password);
                $this->admin_password = $crypt;
                $this->admin_webpassword = $crypt;
            }
        }
//        if ($this->admin_password2 != "") {
//
//            if(strlen($this->admin_password2)<$this->passwd_min || strlen($this->admin_password2)>$this->passwd_max){
//                $err['admin_password2'] = "The password has the wrong length. Min {$this->passwd_min} Max {$this->passwd_max} Characters.";
//            }else{
//                if($this->admin_password == $this->admin_password2){
//                    $crypt = Account::cryptPassword($this->admin_password);
//                    $this->admin_password = $crypt;
//                    $this->admin_webpassword = $crypt;
//                }else{
//                    $err['admin_password'] = "Password mismatched";
//                    $err['admin_password2'] = "Password mismatched";
//                }
//            }
//        }
        if (!isset($this->admin_role) || $this->admin_role == "") {
            $err['admin_role'] = Lang::t('err admin_role empty');
        }
//        pr($this);pr($err);
        /*if (!isset($this->admin_id)) {
            $err['admin_username'] = Lang::t('Create New User Not Allowed');
        }*/
        if(count($err)<1){
            //cari apakah username terpakai

                $this->admin_username = $this->admin_email;
//                $this->admin_aktiv = 1;
//                $this->admin_lastupdate = leap_mysqldate();
//                $this->admin_reg_date = leap_mysqldate();
                $this->load = 1;

        }

        return $err;

    }
    public function onSaveNewItemSuccess($id){
        $acc = new SempoaAccount();
        $acc->getByID($id);
        //add role to role2account
        $role2acc = new Role2Account();
        $role2acc->role_admin_id = $id;
        $role2acc->role_id = $acc->admin_role;
        $role2acc->account_username = $acc->admin_username;
        $role2acc->save();
    }

    public function overwriteRead ($return)
    {
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->admin_aktiv)) {
                $obj->admin_aktiv = $this->arrayYesNO[$obj->admin_aktiv];
            }
            if (isset($obj->admin_org_id)) {
                $org = new SempoaOrg();
                $org->getByID($obj->admin_org_id);
                $obj->admin_org_id = $org->nama;
            }
//            $arrType = ['admin', 'user', 'store'];
//            $obj->admin_type = $arrType[$obj->admin_type];

        }

        //pr($return);
        return $return;
    }
} 