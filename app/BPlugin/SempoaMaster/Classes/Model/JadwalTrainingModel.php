<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JadwalTrainingModel
 *
 * @author efindiongso
 */
class JadwalTrainingModel extends SempoaModel {

    var $table_name = "sempoa__jadwal_training";
    var $main_id = "jt_id";
    //Default Coloms for read
    public $default_read_coloms = "jt_id,jt_trainer_id,jt_level_from,jt_level_to,jt_status,jt_harga,jt_description,jt_mulai_date,jt_akhir_date,jt_ak_id,jt_kpo_id,jt_ibo_id";
//allowed colom in CRUD filter
    public $coloumlist = "jt_id,jt_trainer_id,jt_level_from,jt_level_to,jt_status,jt_harga,jt_description,jt_mulai_date,jt_akhir_date,jt_ak_id,jt_kpo_id,jt_ibo_id";
    public $jt_id;
    public $jt_trainer_id;
    public $jt_level_from;
    public $jt_level_to;
    public $jt_status;
    public $jt_mulai_date;
    public $jt_akhir_date;
    public $jt_harga;
    public $jt_description;
    public $jt_ak_id;
    public $jt_kpo_id;
    public $jt_ibo_id;
    public $removeAutoCrudClick = array();
    public $hideColoums = array("jt_trainer_id", "jt_kpo_id", "jt_ibo_id", "jt_ak_id");

    public function overwriteForm($return, $returnfull) {
        parent::overwriteForm($return, $returnfull);
        $arrJenisTraining = Generic::getJenisTraining();
        $arrLevel = Generic::getAllLevel();
        $arrTrainer = Generic::getAllTrainerWithIDByIBO(AccessRight::getMyOrgID());
        $arrStatus = array("Tidak Aktif", "Aktif");
        if (AccessRight::getMyOrgType() == KEY::$TC) {
            
        }

        $return['jt_trainer_id'] = new \Leap\View\InputSelect($arrTrainer, 'jt_trainer_id', 'jt_trainer_id', $this->jt_trainer_id);
        $return['jt_level_from'] = new \Leap\View\InputSelect($arrLevel, 'jt_level_from', 'jt_level_from', $this->jt_level_from);
//        $return['jt_jenis'] = new \Leap\View\InputSelect($arrJenisTraining, 'jt_jenis', 'jt_jenis', $this->jt_jenis);
        if ($this->jt_level_to == "") {
            $return['jt_level_to'] = new \Leap\View\InputSelect($arrLevel, 'jt_level_to', 'jt_level_to', $this->jt_level_from);
//      
        } else {
            $return['jt_level_to'] = new \Leap\View\InputSelect($arrLevel, 'jt_level_to', 'jt_level_to', $this->jt_level_to);
//      
        }
        $return['jt_mulai_date'] = new Leap\View\InputText("date", "jt_mulai_date", "jt_mulai_date", $this->jt_mulai_date);
        $return['jt_akhir_date'] = new Leap\View\InputText("date", "jt_akhir_date", "jt_akhir_date", $this->jt_akhir_date);
        $return['jt_status'] = new Leap\View\InputSelect($arrStatus, "jt_status", "jt_status", $this->jt_status);
        $return['jt_ak_id'] = new Leap\View\InputText("hidden", "jt_ak_id", "jt_ak_id", Generic::getMyParentID(Generic::getMyParentID(AccessRight::getMyOrgID())));

        if (AccessRight::getMyOrgType() == KEY::$KPO) {
            $return['jt_kpo_id'] = new Leap\View\InputText("hidden", "jt_kpo_id", "jt_kpo_id", ((AccessRight::getMyOrgID())));
        } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {
            $return['jt_ibo_id'] = new Leap\View\InputText("hidden", "jt_ibo_id", "jt_ibo_id", ((AccessRight::getMyOrgID())));
        }

        return $return;
    }

    public function overwriteRead($return) {

        parent::overwriteRead($return);
        $arrJenisTraining = Generic::getJenisTraining();
        $arrLevel = Generic::getAllLevel();
        $arrStatus = array("Tidak Aktif", "Aktif");
        if (AccessRight::getMyOrgType() == KEY::$IBO) {
            $arrTrainer = Generic::getAllTrainerWithIDByIBO(AccessRight::getMyOrgID());
        } else if (AccessRight::getMyOrgType() == KEY::$TC) {
            $arrTrainer = Generic::getAllTrainerWithIDByIBO(Generic::getMyParentID(AccessRight::getMyOrgID()));
        }
//        pr($arrTrainer);

        $objs = $return['objs'];
        foreach ($objs as $obj) {
            $obj->jt_trainer_id = $arrTrainer[$obj->jt_trainer_id];
            $obj->jt_level_from = $arrLevel[$obj->jt_level_from];
            $obj->jt_level_to = $arrLevel[$obj->jt_level_to];
//            $obj->jt_jenis = $arrJenisTraining[$obj->jt_jenis];
            $obj->jt_status = $arrStatus[$obj->jt_status];
            $obj->jt_harga = idr($obj->jt_harga);
            if ($obj->jt_mulai_date == "1970-01-01") {
                $obj->jt_mulai_date = "";
            }
            if ($obj->jt_akhir_date == "1970-01-01") {
                $obj->jt_akhir_date = "";
            }
        }
        return $return;
    }

    public function constraints() {
        //err id => err msg
        $err = array();
        if (($this->jt_harga == 0)) {
            $err['jt_harga'] = Lang::t('Please provide harga');
        }
        return $err;
    }

}
