<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TransaksiTrainingModel
 *
 * @author efindiongso
 */
class TransaksiTrainingModel extends Model {

    //put your code here
    var $table_name = "transaksi__training";
    var $main_id = "tr_id";
    //Default Coloms for read
    public $default_read_coloms = "tr_id,tr_guru_id,tr_tr_id,tr_request_id,tr_harga_id,tr_status,tr_date";
//allowed colom in CRUD filter
    public $coloumlist = "tr_id,tr_guru_id,tr_tr_id,tr_request_id,tr_harga_id,tr_status,tr_date";
    public $tr_id;
    public $tr_guru_id;
    public $tr_tr_id;
    public $tr_owner_id;
    public $tr_request_id;
    public $tr_harga_id;
    public $tr_status;
    public $tr_date;

    public function isGuruBayar($training_id, $guru_id){
        $count =0;
        $count = $this->getJumlah("tr_tr_id = $training_id AND tr_guru_id = $guru_id AND tr_status=1");
        return $count;
    }

    public function isGuruBayarDiscount($training_id, $guru_id){
        $count =0;
        $count = $this->getJumlah("tr_tr_id = $training_id AND tr_guru_id = $guru_id AND (tr_status=1 OR tr_status=2)");
        return $count;
    }
}
