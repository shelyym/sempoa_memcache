<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterGuru
 *
 * @author efindiongso
 */
class RegisterGuru extends Model {

    //put your code here
    var $main_id = "transaksi_id";
    var $table_name = "transaksi__register_guru";
    //Default Coloms for read
    public $default_read_coloms = "transaksi_id,transaksi_guru_id,transaksi_status,transaksi_jumlah,transaksi_ak_id,transaksi_kpo_id,transaksi_ibo_id,transaksi_tc_id,transaksi_date";
//allowed colom in CRUD filter
    public $coloumlist = "transaksi_id,transaksi_guru_id,transaksi_status,transaksi_jumlah,transaksi_ak_id,transaksi_kpo_id,transaksi_ibo_id,transaksi_tc_id,transaksi_date";
    public $transaksi_id;
    public $transaksi_guru_id;
    public $transaksi_status;
    public $transaksi_jumlah;
    public $transaksi_ak_id;
    public $transaksi_kpo_id;
    public $transaksi_ibo_id;
    public $transaksi_tc_id;
    public $transaksi_date;

    public function isInvoiceCreated($id_guru){
        $invoice = new $this();
        $invoice->getWhereOne("transaksi_guru_id='$id_guru''");
        return $invoice->transaksi_id;
    }

    public function createInvoice($id_guru, $jumlah, $ak_id, $kpo_id, $ibo_id, $tc_id){
        $invoice = new RegisterGuru();
        $invoice->transaksi_guru_id = $id_guru;
        $invoice->transaksi_date = leap_mysqldate();
        $invoice->transaksi_jumlah= $jumlah;
        $invoice->transaksi_ak_id= $ak_id;
        $invoice->transaksi_kpo_id= $kpo_id;
        $invoice->transaksi_ibo_id= $ibo_id;
        $invoice->transaksi_tc_id= $tc_id;
        $invoice->transaksi_status=0;
        $invoice->save();
    }
}
