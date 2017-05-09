<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 3/11/17
 * Time: 1:20 PM
 */
class CoretCoret extends WebService
{

    function potongBulan()
    {

//        SELECT * FROM sempoa__iuran_bulanan where bln_murid_id=6681 ORDER BY `bln_tahun`, `bln_mon` DESC
        $a = "03-2017";
        $ib = new IuranBulanan();
        $ib->getWhereOne("bln_murid_id=6681 ORDER BY bln_tahun DESC");
        if (is_null($ib->bln_id)) {
//            $bln = date("n");
//        $thn = date("Y");
            $thn = date("Y");
        } else {
            $thn = $ib->bln_tahun;
        }
        $ib->getWhereOne("bln_murid_id=6681 AND bln_tahun=$thn ORDER BY bln_mon DESC");
        pr($ib->bln_mon . " " . $ib->bln_tahun);

        $arr = explode("-", $a);
        pr($arr);
    }

    public function viewRole(){

        pr($_SESSION);
        $lvl = "ibo";
        $webclass = "UserWeb3";
        $obj = new SempoaRole();
        $id = AccessRight::getMyOrgID();
        $obj->read_filter_array = array("role_org_id"=>AccessRight::getMyOrgID());
        $obj->hideColoums = array("role_org_id","role_level");
        $obj->role_level = strtolower($lvl);
        $obj->cname = $webclass;
        $obj->fktname = "update_user_grup_".$lvl;
        $obj->removeAutoCrudClick = array("role_edit_ar");

        pr($obj);
    }

    public function testLaporanWeb(){


        global $memcache;
        $mc = $memcache->memcache;
        $cacheAvailable = $memcache->cacheAvailable;
        echo "Memcached <br>";
        pr($mc);
        pr($cacheAvailable);

        $a = new LaporanWeb();
        $a->create_operasional_pembayaran_iuran_bulanan_tc();

    }
}