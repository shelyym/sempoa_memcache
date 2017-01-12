<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RekapSiswaIBOModel
 *
 * @author efindiongso
 */
class RekapSiswaIBOModel extends Model {

    //put your code here
    var $table_name = "bi__rekap_siswa_ibo";
    var $main_id = "bi_rekap_siswa_id";
    //Default Coloms for read
    public $default_read_coloms = "bi_rekap_siswa_id,bi_rekap_ak_id,bi_rekap_kpo_id,bi_rekap_ibo_id,bi_rekap_tc_id,bi_rekap_kode_tc,bi_rekap_nama_tc,bi_rekap_nama_director,bi_rekap_siswa_waktu,bi_rekap_bln,bi_rekap_tahun,bi_rekap_bl,bi_rekap_baru,bi_rekap_keluar,bi_rekap_cuti,bi_rekap_lulus,bi_rekap_aktiv,bi_rekap_kupon,bi_rekap_buku,bi_rekap_jumlah_guru";
//allowed colom in CRUD filter
    public $coloumlist = "bi_rekap_siswa_id,bi_rekap_ak_id,bi_rekap_kpo_id,bi_rekap_ibo_id,bi_rekap_tc_id,bi_rekap_kode_tc,bi_rekap_nama_tc,bi_rekap_nama_director,bi_rekap_siswa_waktu,bi_rekap_bln,bi_rekap_tahun,bi_rekap_bl,bi_rekap_baru,bi_rekap_keluar,bi_rekap_cuti,bi_rekap_lulus,bi_rekap_aktiv,bi_rekap_kupon,bi_rekap_buku,bi_rekap_jumlah_guru";
    public $bi_rekap_siswa_id;
    public $bi_rekap_ak_id;
    public $bi_rekap_kpo_id;
    public $bi_rekap_ibo_id;
    public $bi_rekap_tc_id;
    public $bi_rekap_kode_tc;
    public $bi_rekap_nama_tc;
    public $bi_rekap_nama_director;
    public $bi_rekap_siswa_waktu;
    public $bi_rekap_bln;
    public $bi_rekap_tahun;
    public $bi_rekap_bl;
    public $bi_rekap_baru;
    public $bi_rekap_keluar;
    public $bi_rekap_cuti;
    public $bi_rekap_lulus;
    public $bi_rekap_aktiv;
    public $bi_rekap_kupon;
    public $bi_rekap_buku;
    public $bi_rekap_jumlah_guru;

    function getDaten($bln, $thn, $nama_tc) {
        $arrData = $this->getWhere("bi_rekap_bln=$bln AND bi_rekap_tahun=$thn AND bi_rekap_nama_tc='$nama_tc'");
        return $arrData;
    }

    function getCountSiswaAktivBulanLalu($bln, $thn, $tc_id){
        $obj = new $this();
        if($bln == 1){
            $bln = 12;
            $thn = $thn - 1;

        }
        else{
            $bln = $bln - 1;
        }
        $obj->getWhereOne("bi_rekap_tc_id=$tc_id AND bi_rekap_bln=$bln AND bi_rekap_tahun=$thn");
        return $obj->bi_rekap_aktiv;
    }
}
