<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/1/16
 * Time: 11:20 AM
 */

class TransaksiModel extends Model{

    var $table_name = "acc_akuntransaksi";
    var $main_id = "entry_id";

    //Default Coloms for read
    public $default_read_coloms = "entry_id,entry_akun_id,entry_akunkategori_id,entry_date,entry_debit,entry_credit,entry_keterangan,entry_org_id";

//allowed colom in CRUD filter
    public $coloumlist = "entry_id,entry_akun_id,entry_akunkategori_id,entry_date,entry_debit,entry_credit,entry_keterangan,entry_org_id";
    public $entry_id;
    public $entry_akun_id;
    public $entry_akunkategori_id;
    public $entry_date;
    public $entry_debit;
    public $entry_credit;
    public $entry_keterangan;
    public $entry_org_id;


    public static function entry($buku_id,$keterangan,$debit,$credit,$org_id){

        $tm = new TransaksiModel();
        $tm->entry_akun_id = $buku_id;
        $tm->entry_akunkategori_id = substr($buku_id,0,1);
        $tm->entry_keterangan = $keterangan;
        $tm->entry_debit = $debit;
        $tm->entry_credit = $credit;
        $tm->entry_org_id = $org_id;
        $tm->entry_date = leap_mysqldate();
        $tm->save();
    }
} 