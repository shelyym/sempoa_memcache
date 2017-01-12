<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BIRekapKuponModel
 *
 * @author efindiongso
 */
class BIRekapKuponModel extends Model {

    //put your code here
    var $table_name = "bi__rekap_kupon";
    var $main_id = "bi_kupon_id";
    //Default Coloms for read
    public $default_read_coloms = "bi_kupon_id,bi_kupon_bln,bi_kupon_thn,bi_kupon_waktu,bi_kupon_stock,bi_kupon_kupon_masuk,bi_kupon_trs_bln,bi_kupon_stock_akhir,bi_kupon_murid_aktiv,bi_kupon_ak_id,bi_kupon_kpo_id,bi_kupon_ibo_id,bi_kupon_tc_id";
//allowed colom in CRUD filter
    public $coloumlist = "bi_kupon_id,bi_kupon_bln,bi_kupon_thn,bi_kupon_waktu,bi_kupon_stock,bi_kupon_kupon_masuk,bi_kupon_trs_bln,bi_kupon_stock_akhir,bi_kupon_murid_aktiv,bi_kupon_ak_id,bi_kupon_kpo_id,bi_kupon_ibo_id,bi_kupon_tc_id";
    public $bi_kupon_id;
    public $bi_kupon_bln;
    public $bi_kupon_thn;
    public $bi_kupon_waktu;
    public $bi_kupon_stock;
    public $bi_kupon_kupon_masuk;
    public $bi_kupon_trs_bln;
    public $bi_kupon_stock_akhir;
    public $bi_kupon_murid_aktiv;
    public $bi_kupon_ak_id;
    public $bi_kupon_kpo_id;
    public $bi_kupon_ibo_id;
    public $bi_kupon_tc_id;

    function getDatenPrevMonth($bln, $thn, $ak_id, $kpo_id, $ibo_id, $tc_id) {
        if ($bln == 1) {
            $bln = 12;
            $thn = $thn - 1;
        } else {
            $bln = $bln - 1;
        }
        $res = 0;
        $objRekapKupon = new BIRekapKuponModel();
        $arrResult = $objRekapKupon->getWhere("bi_kupon_ak_id=$ak_id AND bi_kupon_kpo_id=$kpo_id AND bi_kupon_ibo_id=$ibo_id AND bi_kupon_tc_id=$tc_id AND bi_kupon_bln=$bln AND bi_kupon_thn=$thn");
//        pr($arrResult[0]->bi_kupon_stock_akhir);
        if (count($arrResult) == 0) {
            return $res;
        }
        $res = $arrResult[0]->bi_kupon_stock_akhir;
        return $res;
    }

}
