<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MuridWeb2Model
 *
 * @author efindiongso
 */
class MuridWeb2Model extends Model {

//put your code here
    var $table_name = "sempoa__status_murid";
    var $main_id = "id_status_murid";
    public $default_read_coloms = "id_status_murid, status";
//allowed colom in CRUD filter
    public $coloumlist = "id_status_murid, status";
    public $id_status_murid;
    public $status;
    

    public function overwriteForm($return, $returnfull) {
        return $return;
    }

    public function constraints() {
        //err id => err msg
        $err = array();
        if (!isset($this->status)) {
            $err['status'] = Lang::t('Please provide status');
        }
        return $err;
    }

}
