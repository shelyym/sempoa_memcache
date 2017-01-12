<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/1/16
 * Time: 2:19 PM
 */

class RequestModel extends Model{

    var $table_name = "transaksi__kupon_request";
    var $main_id = "req_id";

    //Default Coloms for read
    public $default_read_coloms = "req_id,req_date,req_pengirim_org_id,req_penerima_org_id,req_pengirim_user_id,req_perubah_status_user_id,req_type,req_barang_id,req_jumlah,req_status,req_tgl_ubahstatus";

//allowed colom in CRUD filter
    public $coloumlist = "req_id,req_date,req_pengirim_org_id,req_penerima_org_id,req_pengirim_user_id,req_perubah_status_user_id,req_type,req_barang_id,req_jumlah,req_status,req_tgl_ubahstatus";
    public $req_id;
    public $req_date;
    public $req_pengirim_org_id;
    public $req_penerima_org_id;
    public $req_pengirim_user_id;
    public $req_perubah_status_user_id;
    public $req_type; // kupon, buku, barang
    public $req_barang_id;
    public $req_jumlah;
    public $req_status; //0 = baru, 1 = accepted , 2 = rejected *optional
    var $req_tgl_ubahstatus;
} 