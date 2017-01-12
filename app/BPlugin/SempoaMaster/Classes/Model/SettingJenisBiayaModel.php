<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JenisPembayaranModel
 *
 * @author efindiongso
 */
class SettingJenisBiayaModel extends Model {

    var $table_name = "sempoa__jenis_biaya";
    var $main_id = "id_jenis_biaya";
//Default Coloms for read
    public $default_read_coloms = "id_jenis_biaya,id_biaya,jenis_biaya,jenis_biaya_desc,ak_rule,kpo_rule,ibo_rule,tc_rule";
//allowed colom in CRUD filter
    public $coloumlist = "id_jenis_biaya,id_biaya,jenis_biaya,jenis_biaya_desc,ak_rule,kpo_rule,ibo_rule,tc_rule";
    public $id_jenis_biaya;
    public $id_biaya;
    public $jenis_biaya;
    public $jenis_biaya_desc;
    public $ak_rule;
    public $kpo_rule;
    public $ibo_rule;
    public $tc_rule;

    public function overwriteForm($return, $returnfull) {

        $return = parent::overwriteForm($return, $returnfull);

        if ($this->id_biaya == "") {
            $return['id_biaya'] = new \Leap\View\InputText("text", 'id_biaya', 'id_biaya', $idBiaya);
            $return['id_biaya']->setReadOnly();
        }
       
        return $return;
    }

    public function constraints() {
        //err id => err msg
        $err = array();
        if (!isset($this->jenis_biaya)) {
            $err['jenis_biaya'] = Lang::t('Please provide jenis biaya');
        }
        return $err;
    }

}
