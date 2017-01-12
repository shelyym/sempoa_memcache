<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JenisBukuModel
 *
 * @author efindiongso
 */
class JenisBukuModel extends SempoaModel {

    //put your code here
    var $table_name = "sempoa__jenis_buku";
    var $main_id = "id_jenis_buku";
    //Default Coloms for read
    public $default_read_coloms = "id_jenis_buku,kode_buku,nama_buku,level,ak_id,kpo_id,ibo_id,tc_id";
//allowed colom in CRUD filter
    public $coloumlist = "id_jenis_buku,kode_buku,nama_buku,level,ak_id,kpo_id,ibo_id,tc_id";
    public $id_jenis_buku;
    public $kode_buku;
    public $nama_buku;
    public $level;
    public $ak_id;
    public $kpo_id;
    public $ibo_id;
    public $tc_id;

    public function overwriteForm($return, $returnfull) {
        $return = parent::overwriteForm($return, $returnfull);
        $myOrgID = AccessRight::getMyOrgID();
          $arrLevel = Generic::getAllLevel();
        if (AccessRight::getMyOrgType() == KEY::$KPO) {
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myOrgID);
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['tc_id']->setReadOnly();
            $arrIBO = Generic::getAllMyIBO($myOrgID);
            $label = implode(",", $arrIBO);
            $value = implode(",", array_keys($arrIBO));

            $return['ibo_id'] = new Leap\View\InputFieldToken("text", 'ibo_id', 'ibo_id', $value, $label, $this->ibo_id);
        } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {
            $myParentID = Generic::getMyParentID($myOrgID);
            $myGrandParentID = Generic::getMyParentID($myParentID);
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myOrgID);
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['tc_id']->setReadOnly();
        } elseif (AccessRight::getMyOrgType() == KEY::$TC) {
            $myParentID = Generic::getMyParentID($myOrgID);
            $myGrandParentID = Generic::getMyParentID($myParentID);
            $myGrandGrandParentID = Generic::getMyParentID($myGrandParentID);
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myOrgID);
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['tc_id']->setReadOnly();
        }
        $return['level'] = new Leap\View\InputSelect($arrLevel, 'level', 'level', $this->level);
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
