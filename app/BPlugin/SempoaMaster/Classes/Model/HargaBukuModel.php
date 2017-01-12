<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BukuModel
 *
 * @author efindiongso
 */
class HargaBukuModel extends SempoaModel {

    //put your code here
    var $table_name = "sempoa__harga_buku";
    var $main_id = "id_harga_buku";
//Default Coloms for read
    public $default_read_coloms = "id_harga_buku,kode_buku,nama_buku,level,harga_buku_kpo,harga_buku_ibo,harga_buku_tc,ak_id,kpo_id,ibo_id,tc_id";
//allowed colom in CRUD filter
    public $coloumlist = "id_harga_buku,kode_buku,nama_buku,level,harga_buku_kpo,harga_buku_ibo,harga_buku_tc,ak_id,kpo_id,ibo_id,tc_id";
    public $id_harga_buku;
    public $kode_buku;
    public $nama_buku;
    public $level;
    public $harga_buku_kpo;
    public $harga_buku_ibo;
    public $harga_buku_tc;
    public $ak_id;
    public $kpo_id;
    public $ibo_id;
    public $tc_id;

    public function overwriteForm($return, $returnfull) {
        $return = parent::overwriteForm($return, $returnfull);
        $myOrg = AccessRight::getMyOrgID();
        $arrLevel = Generic::getAllLevel();
        if (AccessRight::getMyOrgType() == KEY::$AK) {
            $return['ak_id'] = new Leap\View\InputText("text", "ak_id", "ak_id", $myOrg);
        }

        if (AccessRight::getMyOrgType() == KEY::$KPO) {
            $myParentID = Generic::getMyParentID($myOrg);
            $return['ak_id'] = new Leap\View\InputText("text", "ak_id", "ak_id", $myParentID);
            $return['kpo_id'] = new Leap\View\InputText("text", "kpo_id", "kpo_id", $myOrg);
            $return['harga_buku_kpo'] = new Leap\View\InputText("text", "harga_buku_kpo", "harga_buku_kpo", $this->harga_buku_kpo);
            $return['harga_buku_ibo']->setReadOnly();
            $return['harga_buku_tc']->setReadOnly();
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['tc_id']->setReadOnly();
            $arrIBO = Generic::getAllMyIBO($myOrg);
            $label = implode(",", $arrIBO);
            $value = implode(",", array_keys($arrIBO));

            $return['ibo_id'] = new Leap\View\InputFieldToken("text", 'ibo_id', 'ibo_id', $value, $label, $this->ibo_id);
            $return['level'] = new Leap\View\InputSelect($arrLevel, 'level', 'level', $this->level);
        }

        if (AccessRight::getMyOrgType() == KEY::$IBO) {
            $myParentID = Generic::getMyParentID($myOrg);
            $myParentID = Generic::getMyParentID($myOrg);
            $myGrandParentID = Generic::getMyParentID($myParentID);
            $return['harga_buku_kpo'] = new Leap\View\InputText("text", "harga_buku_kpo", "harga_buku_kpo", $this->harga_buku_kpo);
            $return['harga_buku_ibo'] = new Leap\View\InputText("text", "harga_buku_ibo", "harga_buku_ibo", $this->harga_buku_ibo);
            $return['harga_buku_kpo']->setReadOnly();
            $return['ak_id'] = new Leap\View\InputText("text", "ak_id", "ak_id", $myGrandParentID);
            $return['kpo_id'] = new Leap\View\InputText("text", "kpo_id", "kpo_id", $myParentID);
            $return['harga_buku_tc']->setReadOnly();
            $arrGroup = Generic::getGroup($myOrg, "1");
            $return['ibo_id']->setReadOnly();
            $label = implode(",", $arrGroup);
            $value = implode(",", array_keys($arrGroup));
            $return['tc_id'] = new Leap\View\InputFieldToken("text", 'tc_id', 'tc_id', $value, $label, $this->tc_id);
        }
        if (AccessRight::getMyOrgType() == KEY::$TC) {

            $myParentID = Generic::getMyParentID($myOrg);
            $myGrandParentID = Generic::getMyParentID($myParentID);
            $myRootID = Generic::getMyParentID($myGrandParentID);
            $return['harga_buku_kpo'] = new Leap\View\InputText("hidden", "harga_buku_kpo", "harga_buku_kpo", $this->harga_buku_kpo);
            $return['harga_buku_ibo'] = new Leap\View\InputText("text", "harga_buku_ibo", "harga_buku_ibo", $this->harga_buku_ibo);
            $return['harga_buku_ibo']->setReadOnly();
            $return['harga_buku_tc'] = new Leap\View\InputText("text", "harga_buku_tc", "harga_buku_tc", $this->harga_buku_ibo);
            $return['harga_buku_tc']->setReadOnly();
            $return['ibo_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['tc_id']->setReadOnly();
            $return['ak_id']->setReadOnly();
        }
        if (AccessRight::getMyOrgType() != KEY::$KPO) {
            $return['kode_buku']->setReadOnly();
            $return['nama_buku']->setReadOnly();
            $return['harga_buku_kpo']->setReadOnly();
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['level'] = new Leap\View\InputSelect($arrLevel, 'level', 'level', $this->level, 'form-control', 'disabled');
        }


        return $return;
    }

    public function constraints() {
        //err id => err msg
        $err = array();

        if (!isset($this->kode_buku)) {
            $err['kode_buku'] = Lang::t('Please provide kode_buku');
        }
        if (!isset($this->nama_buku)) {
            $err['nama_buku'] = Lang::t('Please provide nama_buku');
        }

        return $err;
    }

}
