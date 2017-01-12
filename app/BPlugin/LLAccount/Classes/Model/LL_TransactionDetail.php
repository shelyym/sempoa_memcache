<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/13/15
 * Time: 10:43 AM
 */

class LL_TransactionDetail extends Model{

    //Nama Table
    public $table_name = "ll_transaction_details";

    //Primary
    public $main_id = 'detail_id';

    //Default Coloms for read
    public $default_read_coloms = "detail_id,detail_trans_id,detail_macc_id,detail_varian_id,detail_qty,detail_price";

//allowed colom in CRUD filter
    public $coloumlist = "detail_id,detail_trans_id,detail_macc_id,detail_varian_id,detail_qty,detail_price,detail_price_total";
    public $detail_id;
    public $detail_trans_id;
    public $detail_macc_id;
    public $detail_varian_id;
    public $detail_qty;
    public $detail_price;
    public $detail_price_total;
//ll_transaction_details
} 