<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GuruWeb4Model
 *
 * @author efindiongso
 */
class GuruWeb4Model extends Model {

    //put your code here
    //sempoa__status_guru
    var $table_name = "sempoa__status_guru";
    var $main_id = "id_status_guru";
    //Default Coloms for read
    public $default_read_coloms = "id_status_guru,status_guru";
//allowed colom in CRUD filter
    public $coloumlist = "id_status_guru,status_guru";
    public $id_status_guru;
    public $status_guru;

    public function overwriteForm($return, $returnfull) {
        $return = parent::overwriteForm($return, $returnfull);

        return $return;
    }

    public function constraints() {
        //err id => err msg
        $err = array();
        if (!isset($this->status_guru)) {
            $err['status_guru'] = Lang::t('Please provide Status guru');
        }
        return $err;
    }

}
