<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/1/16
 * Time: 9:56 PM
 */
class TorgTC extends SempoaOrg {

//    var $removeAutoCrudClick = array("org_type");
    function __construct() {
//        parent::__construct();
//        print "In SubClass constructor\n";
        //set org_parent_id
//        $this->org_type = "TC";
        $this->org_type = KEY::$TC;

        $this->org_parent_id = AccessRight::getMyOrgID();
    }

    function form_constraints() {

        //err id => err msg
        
        $org_code = new SempoaOrg();
        $org_code->getByID($this->org_parent_id);
        $err = array();

        if (!isset($this->org_kode) || $this->org_kode == "") {
            $err['org_kode'] = KEY::$ERROR_ORG_TC_KOSONG;
        }
        if (isset($this->org_kode)) {
            if (strlen($this->org_kode) < 5) {
                $err['org_kode'] = KEY::$ERROR_ORG_TC_KURANG_5;
            } else {
                $parent_id_hlp = substr($this->org_kode, 0, 2);
                if ($parent_id_hlp != $org_code->org_kode) {
                    $err['org_kode'] =  KEY::$ERROR_ORG_TC_TDK_SAMA_IBO;
                }
            }
        }
        if (!isset($this->nama) || $this->nama == "") {
            $err['nama'] = KEY::$ERROR_NAMA;
        }
        if (!isset($this->alamat) || $this->alamat == "") {
            $err['alamat'] =KEY::$ERROR_ALAMAT;
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
