<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/26/16
 * Time: 10:51 PM
 */
class TorgKPO extends SempoaOrg {

//    var $removeAutoCrudClick = array("org_type");
    function __construct() {
//        parent::__construct();
//        print "In SubClass constructor\n";
        //set org_parent_id
        $this->org_type = KEY::$KPO;
        $this->org_parent_id = AccessRight::getMyOrgID();
    }

    function form_constraints() {

        //err id => err msg
        $err = array();

        if (!isset($this->org_kode) || $this->org_kode == "") {
            $err['org_kode'] = KEY::$ERROR_ORG_IBO_KOSONG;
        }
        if (isset($this->org_kode)) {
            if (strlen($this->org_kode) < 1) {
                $err['org_kode'] =  KEY::$ERROR_ORG_IBO_KURANG_2;
            }
        }
        if (!isset($this->nama) || $this->nama == "") {
            $err['nama'] = KEY::$ERROR_NAMA;
        }
        if (!isset($this->alamat) || $this->alamat == "") {
            $err['alamat'] = KEY::$ERROR_ALAMAT;
        }

        if (!isset($this->nomor_telp) || $this->nomor_telp == "") {
            $err['nomor_telp'] = KEY::$ERROR_TEL;
        }

        if (!isset($this->propinsi) || $this->propinsi == "") {
            $err['propinsi'] = KEY::$ERROR_PROPINSI;
        }

        if (!isset($this->email) || $this->email == "") {
            $err['email'] = KEY::$ERROR_EMAIL;
        }
        return $err;
    }

}
