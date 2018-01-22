<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 1/19/18
 * Time: 8:59 AM
 */
class WSSempoaApp extends WebService
{

    public function registerParent()
    {


        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();

        $parent_fullname = addslashes($_POST['parent_fullname']);
        $parent_email = addslashes($_POST['parent_email']);
        $parent_hp_nr = addslashes($_POST['parent_hp_nr']);
        $parent_pwd = addslashes($_POST['parent_pwd']);

        $objParent = new ParentSempoa();
        if ($parent_fullname == "") {
            Generic::errorMsg("Fullname harus diisi");
        }

        if ($parent_email == "") {
            Generic::errorMsg("Email harus diisi");
        } else {
            // cek email valid;
            if (!Generic::isEmailValid($parent_email)) {
                Generic::errorMsg("Email tidak valid");
            } else {
                // cek email sdh pernah dipake
                if (!$objParent->isEmailUsed($parent_email)) {
                    Generic::errorMsg("Email sudah pernah dipakai!");
                }
            }
        }


        if ($parent_hp_nr == "") {
            Generic::errorMsg("No Handphone harus diisi");
        }

        if ($parent_pwd == "") {
            Generic::errorMsg("Password harus diisi");
        }

        $objParent = new ParentSempoa();
        $objParent->parent_fullname = $parent_fullname;
        $objParent->parent_email = $parent_email;
        $objParent->parent_hp_nr = $parent_hp_nr;
        $objParent->parent_pwd = $parent_pwd;
        $objParent->parent_active = 1;
        $objParent->parent_created_date = leap_mysqldate();
        $objParent->parent_last_login = leap_mysqldate();
        $objParent->parent_updated_date = leap_mysqldate();
//        $objParent->parent_last_ip =
        $objParent->save();
        $json['status_code'] = 1;
        $json['status_message'] = "Registrasi berhasil!";
        echo json_encode($json);
        die();
    }

    public function loginParent()
    {
        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();

        $parent_email = addslashes($_POST['parent_email']);
        $parent_pwd = addslashes($_POST['parent_pwd']);
        if ($parent_email == "") {
            Generic::errorMsg("Email harus diisi");
        } else {
            // cek email valid;
            if (!Generic::isEmailValid($parent_email)) {
                Generic::errorMsg("Email tidak valid");
            }
        }

        if ($parent_pwd == "") {
            Generic::errorMsg("Password harus diisi");
        }

        $json = array();
        $objParent = new ParentSempoa();
        $objParent->getWhereOne("parent_email='$parent_email' AND parent_pwd='$parent_pwd'");

        if (is_null($objParent->parent_id)) {
            Generic::errorMsg("Email salah atau password salah");
        }
        $json['status_code'] = 1;
        $json['status_message'] = "Berhasil!";
        echo json_encode($json);
        die();
    }

    public function resetPwdParent()
    {
        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();
        $parent_email = addslashes($_POST['parent_email']);
        if ($parent_email == "") {
            Generic::errorMsg("Email harus diisi");
        } else {
            // cek email valid;
            if (!Generic::isEmailValid($parent_email)) {
                Generic::errorMsg("Email tidak valid");
            }
        }

        $objParent = new ParentSempoa();
        if ($objParent->isEmailUsed($parent_email)) {
            Generic::errorMsg("Email tidak terdaftar!");
        }

        // create email ganti password
        // send email ke parent
    }

    public function sendEmailParent(){

    }

}