<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of POItemModel
 *
 * @author efindiongso
 */
class POItemModel extends Model {

    //put your code here
    var $table_name = "transaksi__PO_item";
    var $main_id = "item_id";
    //Default Coloms for read
    public $default_read_coloms = "item_id,po_id,id_barang,qty,harga,total_harga,status,org_id";
//allowed colom in CRUD filter
    public $coloumlist = "item_id,po_id,id_barang,qty,harga,total_harga,status,org_id";
    public $item_id;
    public $po_id;
    public $id_barang;
    public $qty;
    public $harga;
    public $total_harga;
    public $org_id;
    public $status;

}
