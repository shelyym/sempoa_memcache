<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TransaksiStockMode
 *
 * @author efindiongso
 */
class StockModel extends SempoaModel {

    var $table_name = "transaksi__stock";
    var $main_id = "stock_id";
    //put your code here
    //Default Coloms for read
    public $default_read_coloms = "stock_id,id_barang,org_id,jumlah_stock,jumlah_stock_hold";
//allowed colom in CRUD filter
    public $coloumlist = "stock_id,id_barang,org_id,jumlah_stock,jumlah_stock_hold";
    public $stock_id;
    public $id_barang;
    public $org_id;
    public $jumlah_stock;
    public $jumlah_stock_hold;

    function retourStock($id_barang, $org_id){
        $stock = new StockModel();
        $stock->getWhereOne("id_barang=$id_barang  AND org_id=$org_id");
        if(!is_null($stock->stock_id)){
            $stock->jumlah_stock = $stock->jumlah_stock + 1;
            $stock->save(1);
        }
    }

}
