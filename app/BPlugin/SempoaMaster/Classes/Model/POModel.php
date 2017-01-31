<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of POModel
 *
 * @author efindiongso
 */
class POModel extends Model {

    //put your code here
    var $table_name = "transaksi__PO";
    var $main_id = "po_id";
    //Default Coloms for read
    public $default_read_coloms = "po_id,po_user_id_pengirim,po_tanggal,po_pengirim,po_penerima,po_status,po_keterangan";
//allowed colom in CRUD filter
    public $coloumlist = "po_id,po_user_id_pengirim,po_tanggal,po_pengirim,po_penerima,po_status,po_keterangan";
    public $po_user_id_pengirim;
    public $org_id;
    public $po_tanggal;
    public $po_pengirim;
    public $po_penerima;
    public $po_status;
    public $po_keterangan;
    public $po_total_harga;

}
