<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/1/16
 * Time: 3:58 PM
 */
class KuponSatuan extends Model {

    var $table_name = "transaksi__kupon_satuan";
    var $main_id = "kupon_id";
    //Default Coloms for read
    public $default_read_coloms = "kupon_id,kupon_owner_id,kupon_bundle_id,kupon_status,kupon_pemakaian_date,kupon_pemakaian_id,bck_owner_id";
//allowed colom in CRUD filter
    public $coloumlist = "kupon_id,kupon_owner_id,kupon_bundle_id,kupon_status,kupon_pemakaian_date,kupon_pemakaian_id,bck_owner_id";
    public $kupon_id;
    public $kupon_owner_id;
    public $kupon_bundle_id;
    public $kupon_status;
    public $kupon_pemakaian_date;
    public $kupon_pemakaian_id;
    public $bck_owner_id;

    function getJmlhKpnfreeByOrg($bln, $thn, $org_id) {
        $kuponSatuan = new KuponSatuan();
        $arrKupon = $kuponSatuan->getWhere("kupon_owner_id='$org_id' AND kupon_status=0 AND YEAR(kupon_pemakaian_date)= $thn AND MONTH(kupon_pemakaian_date)= $bln ");
        return count($arrKupon);
    }

    function getJmlhKpnNFreeByOrg($bln, $thn, $org_id) {
        $kuponSatuan = new KuponSatuan();
        $arrKupon = $kuponSatuan->getWhere("kupon_owner_id='$org_id' AND kupon_status=1 AND YEAR(kupon_pemakaian_date)= $thn AND MONTH(kupon_pemakaian_date)= $bln ORDER by kupon_id ASC");
        return count($arrKupon);
    }

    function getJumlahKuponTerpakaiByTC($bln, $thn, $tc_id) {
        $count = $this->getJumlah("kupon_owner_id=$tc_id AND  kupon_status=1 AND YEAR(kupon_pemakaian_date)= $thn AND MONTH(kupon_pemakaian_date)= $bln ");
        return $count;
    }

    function retourKupon($kupon_id){
        $kuponSatuan = new KuponSatuan();
        $kuponSatuan->getWhereOne("kupon_id=$kupon_id AND kupon_status=1");
        if(!is_null($kuponSatuan->kupon_id)){
            $kuponSatuan->kupon_status = 0;
            $kuponSatuan->kupon_pemakaian_date = KEY::$TGL_KOSONG;
            $kuponSatuan->save(1);
        }
    }

    function jumlahKuponTersedia($id_owner){
        $jumlah = $this->getJumlah("kupon_owner_id='$id_owner' AND kupon_status =0");
        return $jumlah;
    }

}
