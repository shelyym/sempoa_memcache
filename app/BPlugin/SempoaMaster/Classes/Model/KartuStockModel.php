<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KartuStockModel
 *
 * @author efindiongso
 */
class KartuStockModel extends SempoaModel {

    //put your code here
    var $table_name = "transaksi__kartu_stock";
    var $main_id = "kartu_id";
    //Default Coloms for read
    public $default_read_coloms = "kartu_id,id_barang,tanggal_input,type,stock_masuk,keterangan,id_pemilik_barang,id_pembeli_barang,nama_pengeluar_barang,nama_penerima_barang";
//allowed colom in CRUD filter
    public $coloumlist = "kartu_id,id_barang,tanggal_input,type,stock_masuk,keterangan,id_pemilik_barang,id_pembeli_barang,nama_pengeluar_barang,nama_penerima_barang";
    public $kartu_id;
    public $id_barang;
    public $tanggal_input;
    public $type;
    public $stock_masuk;
    public $keterangan;
    public $id_pemilik_barang;
    public $id_pembeli_barang;
    public $nama_pengeluar_barang;
    public $nama_penerima_barang;

}
