<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UjianModel
 *
 * @author efindiongso
 */
class UjianModel extends SempoaModel {

    //put your code here
    var $table_name = "sempoa__ujian";
    var $main_id = "ujian_id";
    //Default Coloms for read
    public $default_read_coloms = "ujian_id,ujian_jenis,ujian_from_level,ujian_to_level,ujian_date,ujian_status,ujian_ibo_id";
//allowed colom in CRUD filter
    public $coloumlist = "ujian_id,ujian_jenis,ujian_from_level,ujian_to_level,ujian_date,ujian_status,ujian_ibo_id";
    public $ujian_id;
    public $ujian_jenis;
    public $ujian_from_level;
    public $ujian_to_level;
    public $ujian_date;
    public $ujian_status;
    public $ujian_ibo_id;

    public $crud_setting = array("add" => 0, "search" => 1, "viewall" => 0, "export" => 1, "toggle" => 1, "import" => 0, "webservice" => 0);


    public $hideColoums = array("ujian_ibo_id");
    public function overwriteForm($return, $returnfull) {
        $t = time();
        $return = parent::overwriteForm($return, $returnfull);
        $arrLevel = Generic::getAllLevel();
        $arrJenisUjian = Generic::getJenisUjian();
        $arrStatus = Generic::getStatusAktiv();
        $return['ujian_from_level'] = new \Leap\View\InputSelect($arrLevel, 'ujian_from_level', 'ujian_from_level', $this->ujian_from_level);
        $return['ujian_to_level'] = new \Leap\View\InputSelect($arrLevel, 'ujian_to_level', 'ujian_to_level', $this->ujian_to_level);

//        $return['ujian_jenis'] = new \Leap\View\InputSelect($arrJenisUjian, 'ujian_jenis', 'ujian_jenis', $this->ujian_jenis);
        $return['ujian_status'] = new \Leap\View\InputSelect($arrStatus, 'ujian_status', 'ujian_status', $this->ujian_status);
        $return['ujian_date'] = new Leap\View\InputText("date", 'ujian_date', 'ujian_date', $this->ujian_date);
        $return['ujian_ibo_id'] = new Leap\View\InputText("hidden", 'ujian_ibo_id', 'ujian_ibo_id', AccessRight::getMyOrgID());
        return $return;
    }

    public function constraints() {
        //err id => err msg
        $err = array();

        return $err;
    }

    public function overwriteRead($return) {
        $objs = $return['objs'];
        $arrLevel = Generic::getAllLevel();
        $arrJenisUjian = Generic::getJenisUjian();
        $arrStatus = Generic::getStatusAktiv();
        foreach ($objs as $obj) {
            if (isset($obj->ujian_from_level)) {
                $obj->ujian_from_level = $arrLevel[$obj->ujian_from_level];
            }
            if (isset($obj->ujian_to_level)) {
                $obj->ujian_to_level = $arrLevel[$obj->ujian_to_level];
            }
//            if (isset($obj->ujian_jenis)) {
//                $obj->ujian_jenis = $arrJenisUjian[$obj->ujian_jenis];
//            }
            if (isset($obj->ujian_status)) {
                $obj->ujian_status = $arrStatus[$obj->ujian_status];
            }

            if (isset($obj->ujian_date)) {
                $obj->ujian_date = date("d-m-Y", strtotime($obj->ujian_date));
            }
        }
        return $return;
    }

}
