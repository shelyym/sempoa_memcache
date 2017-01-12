<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TorgAK
 *
 * @author efindiongso
 */
class TorgAK extends SempoaOrg {

//    var $removeAutoCrudClick = array("org_type");
    function __construct() {
//        parent::__construct();
//        print "In SubClass constructor\n";
        //set org_parent_id
//        $this->org_type = "IBO";
        $this->org_type = KEY::$AK;
        $this->org_parent_id = 1;
    }

    function form_constraints() {

        //err id => err msg
        $err = array();

        if (!isset($this->org_kode) || $this->org_kode == "") {
            $err['org_kode'] = Lang::t('err kode empty');
        }
        if (isset($this->org_kode)) {
            if (strlen($this->org_kode) < 2) {
                $err['org_kode'] = Lang::t('err Panjang organisasi harus 2');
            } else {
                $kode_ibo = substr($this->org_kode, 0, 2);
            }
        }
       
        if (!isset($this->nama) || $this->nama == "") {
            $err['nama'] = Lang::t('err nama empty');
        }
        if (!isset($this->alamat) || $this->alamat == "") {
            $err['alamat'] = Lang::t('err alamat empty');
        }
        if (!isset($this->nomor_telp) || $this->nomor_telp == "") {
            $err['nomor_telp'] = Lang::t('err nomor_telp empty');
        }

        if (!isset($this->propinsi) || $this->propinsi == "") {
            $err['propinsi'] = Lang::t('err propinsi empty');
        }

        if (!isset($this->email) || $this->email == "") {
            $err['email'] = Lang::t('err email empty');
        }
        return $err;
    }

}
