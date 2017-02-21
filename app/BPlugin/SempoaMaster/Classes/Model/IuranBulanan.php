<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/13/16
 * Time: 9:45 AM
 */

class IuranBulanan extends Model{

    var $table_name = "sempoa__iuran_bulanan";
    var $main_id = "bln_id";

    //Default Coloms for read
    public $default_read_coloms = "bln_id,bln_murid_id,bln_date_pembayaran,bln_date,bln_mon,bln_tahun,bln_status,bln_kupon_id,bln_tc_id,bln_ibo_id,bln_kpo_id,bln_ak_id,bln_no_urut_in,bln_no_invoice,bln_create_date";

//allowed colom in CRUD filter
    public $coloumlist = "bln_id,bln_murid_id,bln_date,bln_date_pembayaran,bln_mon,bln_tahun,bln_status,bln_kupon_id,bln_tc_id,bln_ibo_id,bln_kpo_id,bln_ak_id,bln_cara_bayar,bln_no_urut_in,bln_no_invoice,bln_create_date";
    public $test;
    public $bln_id;
    public $bln_murid_id;
    public $bln_date_pembayaran;
    public $bln_date;
    public $bln_mon;
    public $bln_tahun;
    public $bln_status;
    public $bln_kupon_id;
    public $bln_tc_id;
    public $bln_ibo_id;
    public $bln_kpo_id;
    public $bln_ak_id;
    public $bln_cara_bayar;
    public $bln_no_urut_inv;
    public $bln_no_invoice;
    public $bln_create_date;
//    public $bln_urutan_invoice_murid;

    function getJumlahKuponTerjualPerBulanByTC($bln, $thn, $tc_id){
        $count = $this->getJumlah("bln_tc_id=$tc_id AND MONTH(bln_date_pembayaran)=$bln AND YEAR((bln_date_pembayaran))=$thn AND bln_status=1");
        
//        bln_date_pembayaran
//        $count = $this->getWhereOne("bln_tc_id=$tc_id AND bln_mon=$bln AND bln_tahun=$thn AND bln_status=1");
        return $count;
        
    }

    function getLastNoUrutInvoice($thn, $bln, $tc_id){
        $nourut = new $this();
        $nourut->getWhereOne("bln_tc_id=$tc_id AND MONTH(bln_date_pembayaran)=$bln AND YEAR((bln_date_pembayaran))=$thn  AND bln_no_urut_inv != 0 ORDER BY bln_date_pembayaran DESC");
        $urut =  $nourut->bln_no_urut_inv + 1;
        return $urut;
    }
} 