<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/1/16
 * Time: 3:54 PM
 */
class KuponBundle extends Model {

    var $table_name = "transaksi__kupon_bundle";
    var $main_id = "bundle_id";
    //Default Coloms for read
    public $default_read_coloms = "bundle_id,bundle_start,bundle_end,bundle_org_id,bundle_req_id,bundle_size,kpo_id,ibo_id,tc_id";
//allowed colom in CRUD filter
    public $coloumlist = "bundle_id,bundle_start,bundle_end,bundle_org_id,bundle_req_id,bundle_size,kpo_id,ibo_id,tc_id";
    public $bundle_id;
    public $bundle_start;
    public $bundle_end;
    public $bundle_org_id;
    public $bundle_req_id;
    public $bundle_size;
    public $kpo_id;
    public $ibo_id;
    public $tc_id;

     function getJumlahKuponByTC($bln, $thn, $tc_id) {
        $transaksi_kupon = new RequestModel();
        global $db;
        $q = "SELECT *  FROM $this->table_name bundle INNER JOIN {$transaksi_kupon->table_name} kupon ON bundle.bundle_req_id=kupon.req_id WHERE bundle.tc_id = $tc_id  AND YEAR(kupon.req_tgl_ubahstatus)=$thn AND MONTH(kupon.req_tgl_ubahstatus)=$bln";
     
        $arrResult = $db->query($q, 2);
         $jumlahKupon = 0;
        if(count($arrResult) == 0){
            return $jumlahKupon;
        }
       
        foreach($arrResult as $val){
            $jumlahKupon += $val->bundle_size;
        }
        return $jumlahKupon;
    }
    
  
    
}
