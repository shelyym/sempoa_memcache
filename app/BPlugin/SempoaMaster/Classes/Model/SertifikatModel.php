<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SertifikatModel
 *
 * @author efindiongso
 */
class SertifikatModel extends Model {

    //put your code here
    var $table_name = "sempoa__sertifikat";
    var $main_id = "sertifikat_id";
    //Default Coloms for read
    public $default_read_coloms = "sertifikat_id,sertifikat_murid_id,sertifikat_murid_level,sertifikat_status,sertifikat_req_date,sertifikat_kirim_date,sertifikat_ak_id,sertifikat_kpo_id,sertifikat_ibo_id,sertifikat_tc_id";
//allowed colom in CRUD filter
    public $coloumlist = "sertifikat_id,sertifikat_murid_id,sertifikat_murid_level,sertifikat_status,sertifikat_req_date,sertifikat_kirim_date,sertifikat_ak_id,sertifikat_kpo_id,sertifikat_ibo_id,sertifikat_tc_id";
    public $sertifikat_id;
    public $sertifikat_murid_id;
    public $sertifikat_murid_level;
    public $sertifikat_status;
    public $sertifikat_req_date;
    public $sertifikat_kirim_date;
    public $sertifikat_ak_id;
    public $sertifikat_kpo_id;
    public $sertifikat_ibo_id;
    public $sertifikat_tc_id;

    public function createSertifikatTC($tc_id, $murid_id, $level_id) {
        $myIBO = Generic::getMyParentID($tc_id);
        $myKPO = Generic::getMyParentID($myIBO);
        $myAK = Generic::getMyParentID($myKPO);


        $this->sertifikat_tc_id = $tc_id;
        $this->sertifikat_ibo_id = $myIBO;
        $this->sertifikat_kpo_id = $myKPO;
        $this->sertifikat_ak_id = $myAK;
        $this->sertifikat_murid_id = $murid_id;
        $this->sertifikat_req_date = leap_mysqldate();
        $this->sertifikat_status = 0;
        $this->sertifikat_murid_level = $level_id;

        $return = $this->save();

        return $return;
    }

}
