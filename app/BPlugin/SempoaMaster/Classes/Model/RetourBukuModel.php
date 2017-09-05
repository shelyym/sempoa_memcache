<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 9/3/17
 * Time: 2:48 PM
 */
class RetourBukuModel extends Model
{
    //put your code here
    var $table_name = "sempoa__retour_buku";
    var $main_id = "retour_id";

    //Default Coloms for read
    public $default_read_coloms = "retour_id,retour_no,retour_buku_no,retour_buku_no_pengganti_tc,retour_buku_no_pengganti_ibo,retour_buku_no_pengganti_murid,retour_id_buku,retour_level_buku,retour_status_kpo,retour_status_ibo,retour_status_tc,retour_status_murid,retour_tgl_masuk_kpo,retour_tgl_masuk_ibo,retour_tgl_keluar_ibo,retour_tgl_masuk_tc,retour_tgl_keluar_tc,retour_tgl_masuk_murid,retour_tgl_keluar_murid,retour_jenis,retour_respon_kpo,retour_respon_ibo,retour_respon_tc,retour_respon_murid,retour_kpo,retour_ibo,retour_tc,retour_murid,retour_keterangan";

//allowed colom in CRUD filter
    public $coloumlist = "retour_id,retour_no,retour_buku_no,retour_buku_no_pengganti_tc,retour_buku_no_pengganti_ibo,retour_buku_no_pengganti_murid,retour_id_buku,retour_level_buku,retour_status_kpo,retour_status_ibo,retour_status_tc,retour_status_murid,retour_tgl_masuk_kpo,retour_tgl_masuk_ibo,retour_tgl_keluar_ibo,retour_tgl_masuk_tc,retour_tgl_keluar_tc,retour_tgl_masuk_murid,retour_tgl_keluar_murid,retour_jenis,retour_respon_kpo,retour_respon_ibo,retour_respon_tc,retour_respon_murid,retour_kpo,retour_ibo,retour_tc,retour_murid,retour_keterangan";
    public $retour_id;
    public $retour_no;
    public $retour_buku_no;
    public $retour_buku_no_pengganti_tc;
    public $retour_buku_no_pengganti_ibo;
    public $retour_buku_no_pengganti_murid;
    public $retour_id_buku;
    public $retour_level_buku;
    public $retour_status_kpo;
    public $retour_status_ibo;
    public $retour_status_tc;
    public $retour_status_murid;
    public $retour_tgl_masuk_kpo;
    public $retour_tgl_masuk_ibo;
    public $retour_tgl_keluar_ibo;
    public $retour_tgl_masuk_tc;
    public $retour_tgl_keluar_tc;
    public $retour_tgl_masuk_murid;
    public $retour_tgl_keluar_murid;
    public $retour_jenis;
    public $retour_respon_kpo;
    public $retour_respon_ibo;
    public $retour_respon_tc;
    public $retour_respon_murid;
    public $retour_kpo;
    public $retour_ibo;
    public $retour_tc;
    public $retour_murid;
    public $retour_keterangan;

    //$stock_id_buku;
//    public $stock_grup_level;

    public function createRetourNo($org_id, $org_type){
        $bln = date("n");
        $thn = date("Y");
        if($org_type == KEY::$KPO){
            $jumlah = $this->getJumlah("MONTH(retour_tgl_masuk_tc)=$bln AND YEAR(retour_tgl_masuk_tc) = $thn AND retour_tc=$org_id");
        }
        elseif($org_type == KEY::$IBO){
            $jumlah = $this->getJumlah("MONTH(retour_tgl_masuk_tc)=$bln AND YEAR(retour_tgl_masuk_tc) = $thn AND retour_tc=$org_id");
        }
        elseif($org_type == KEY::$TC){
            $jumlah = $this->getJumlah("MONTH(retour_tgl_keluar_tc)=$bln AND YEAR(retour_tgl_keluar_tc) = $thn AND retour_tc=$org_id");
        }
        else{

        }
        return "RE/".$thn."/".$bln."/".($jumlah +1);

//        $this->getWhere("month")
    }
}