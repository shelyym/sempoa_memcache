<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BiayaTrainingModel
 *
 * @author efindiongso
 */
class BiayaTrainingModel extends Model {

    //put your code here
    var $table_name = "sempoa__biaya_training";
    var $main_id = "by_id";
    //Default Coloms for read
    public $default_read_coloms = "by_id,by_level,by_type,by_harga,by_ak_id,by_kpo_id,by_ibo_id";
//allowed colom in CRUD filter
    public $coloumlist = "by_id,by_level,by_type,by_harga,by_ak_id,by_kpo_id,by_ibo_id";
    public $by_id;
    public $by_level;
    public $by_type;
    public $by_harga;
    public $by_ak_id;
    public $by_kpo_id;
    public $by_ibo_id;
    public $owner;

    public function overwriteForm($return, $returnfull) {
        $return = parent::overwriteForm($return, $returnfull);


        if (AccessRight::getMyOrgType() == KEY::$KPO) {

            if (($this->by_type == KEY::$INDEX_TRAINING_PAKET) || ($this->by_type == "")) {
                $owner = KEY::$KPO;
                $arrJenisTrainingKPO[KEY::$INDEX_TRAINING_PAKET] = KEY::$TRAINING_PAKET;
                $arrGroup = Generic::getLevelGroup();

                $return['by_type'] = new Leap\View\InputSelect($arrJenisTrainingKPO, "by_type", "by_type", $this->by_type);
                $return['by_level'] = new Leap\View\InputSelect($arrGroup, "by_level", "by_level", $this->by_level);
                $return['by_kpo_id'] = new \Leap\View\InputText("text", "by_ibo_id", "by_ibo_id", AccessRight::getMyOrgID());
                $return['by_ak_id'] = new \Leap\View\InputText("text", "by_ak_id", "by_ak_id", Generic::getMyParentID(Generic::getMyParentID(AccessRight::getMyOrgID())));
            } elseif ($this->by_type == KEY::$INDEX_TRAINING_SATUAN) {
                $owner = KEY::$IBO;
                $arrJenisTraining = Generic::getJenisBiayaTraining();
                $arrLevel = Generic::getAllLevel();
                $return['by_type'] = new Leap\View\InputSelect($arrJenisTraining, "by_type", "by_type", $this->by_type);
                $return['by_level'] = new Leap\View\InputSelect($arrLevel, "by_level", "by_level", $this->by_level);
            }
        } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {

            if (($this->by_type == KEY::$INDEX_TRAINING_PAKET)) {
                $owner = KEY::$KPO;
                $arrJenisTrainingKPO[KEY::$INDEX_TRAINING_PAKET] = KEY::$TRAINING_PAKET;
                $arrGroup = Generic::getLevelGroup();

                $return['by_type'] = new Leap\View\InputSelect($arrJenisTrainingKPO, "by_type", "by_type", $this->by_type);
                $return['by_level'] = new Leap\View\InputSelect($arrGroup, "by_level", "by_level", $this->by_level);
            } elseif (($this->by_type == KEY::$INDEX_TRAINING_SATUAN) || ($this->by_type == "")) {
                $owner = KEY::$IBO;
                $arrJenisTraining[KEY::$INDEX_TRAINING_SATUAN] = KEY::$TRAINING_SATUAN;
                $arrLevel = Generic::getAllLevel();
                $return['by_type'] = new Leap\View\InputSelect($arrJenisTraining, "by_type", "by_type", $this->by_type);
                $return['by_level'] = new Leap\View\InputSelect($arrLevel, "by_level", "by_level", $this->by_level);
                $return['by_ibo_id'] = new \Leap\View\InputText("text", "by_ibo_id", "by_ibo_id", AccessRight::getMyOrgID());
                $return['by_ak_id'] = new \Leap\View\InputText("text", "by_ak_id", "by_ak_id", Generic::getMyParentID(Generic::getMyParentID(AccessRight::getMyOrgID())));
                $return['by_kpo_id'] = new \Leap\View\InputText("text", "by_kpo_id", "by_kpo_id", Generic::getMyParentID(AccessRight::getMyOrgID()));
            }
        }

        return $return;
    }

    public function overwriteRead($return) {
        $objs = $return['objs'];
        $arrJenisTraining = Generic::getJenisBiayaTraining();
        $arrLevel = Generic::getAllLevel();
        foreach ($objs as $obj) {
            if (AccessRight::getMyOrgType() == KEY::$KPO) {

                if (($obj->by_type == KEY::$INDEX_TRAINING_PAKET)) {
                    $obj->by_type = KEY::$TRAINING_PAKET;
                    if (isset($obj->by_level)) {
                        $arrGroup = Generic::getLevelGroup();
                        $obj->by_level = $arrGroup[$obj->by_level];
                    }
                } else if (($obj->by_type == KEY::$INDEX_TRAINING_SATUAN)) {
                    $obj->by_type = KEY::$TRAINING_SATUAN;
                    if (isset($obj->by_level)) {
                        $obj->by_level = $arrLevel[$obj->by_level];
                    }
                }
            } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {
                if (($obj->by_type == KEY::$INDEX_TRAINING_PAKET)) {
                    $obj->by_type = KEY::$TRAINING_PAKET;
                    if (isset($obj->by_level)) {
                        $arrGroup = Generic::getLevelGroup();
                        $obj->by_level = $arrGroup[$obj->by_level];
                    }
                } else if (($obj->by_type == KEY::$INDEX_TRAINING_SATUAN)) {
                    $obj->by_type = KEY::$TRAINING_SATUAN;
                    if (isset($obj->by_level)) {
                        $obj->by_level = $arrLevel[$obj->by_level];
                    }
                }
            }
            if (isset($obj->by_harga)) {
                $obj->by_harga = idr($obj->by_harga);
            }
        }
        return $return;
    }

}
