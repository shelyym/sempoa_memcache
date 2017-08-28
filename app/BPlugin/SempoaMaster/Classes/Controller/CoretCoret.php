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

    public function viewRole()
    {

        pr($_SESSION);
        $lvl = "ibo";
        $webclass = "UserWeb3";
        $obj = new SempoaRole();
        $id = AccessRight::getMyOrgID();
        $obj->read_filter_array = array("role_org_id" => AccessRight::getMyOrgID());
        $obj->hideColoums = array("role_org_id", "role_level");
        $obj->role_level = strtolower($lvl);
        $obj->cname = $webclass;
        $obj->fktname = "update_user_grup_" . $lvl;
        $obj->removeAutoCrudClick = array("role_edit_ar");

        pr($obj);
    }

    public function testLaporanWeb()
    {


        global $memcache;
        $mc = $memcache->memcache;
        $cacheAvailable = $memcache->cacheAvailable;
        echo "Memcached <br>";
        pr($cacheAvailable);
        if ($cacheAvailable) {
            echo "true";
        }

        echo "akhir <br>";
        $a = new LaporanWeb();
        $a->create_operasional_pembayaran_iuran_bulanan_tc();

    }

    public function stockBuku()
    {
//        $a = new StockBuku();
//        $no = $a->getMyLastNummer(28);
//        pr($no);

        $i = 0;
        $stk_masuk = 100;
        for ($i = 0; $i < $stk_masuk; $i++) {
            $stockBuku = new StockBuku();
            $no = $stockBuku->getMyLastNummer(28);
            $stockBuku->createNoBuku(28, $no, AccessRight::getMyOrgID());
            pr($no);
        }

    }

    public function setStatusPO()
    {
        $po_id = 544;
        $po_id = 547;
        $objPO = new POModel();
        global $db;
        $q = "SELECT * FROM {$objPO->table_name} po  WHERE   po.po_id= $po_id";
        $arrPO = $db->query($q, 2);
        $peminta = $arrPO[0]->po_pengirim;
        $objPOItem = new POItemModel();
        $arrPOItems = $objPOItem->getWhere("po_id='$po_id'");
        foreach ($arrPOItems as $val) {
            $res[$val->id_barang]['barang'] = $val->id_barang;
            $res[$val->id_barang]['qty'] = $val->qty;
            $res[$val->id_barang]['peminta'] = $peminta;
            $res[$val->id_barang]['pemilik'] = $val->org_id;
            $res[$val->id_barang]['po_id'] = $val->po_id;
        }
        pr($res);
        pr(AccessRight::getMyOrgType());
        foreach ($res as $val) {
            $anzahlBuku = self::getNoBuku($val['barang'], $val['qty'], $val['pemilik'], AccessRight::getMyOrgType());
            pr($anzahlBuku);
            if ($anzahlBuku >= $val['qty']) {
                echo "asas <br>";
                self::setNoBuku($val['barang'], $val['qty'], $val['pemilik'], $val['peminta'], AccessRight::getMyOrgType(), $val['po_id']);
            }

        }
//        pr($res);

    }

    public function getNoBuku($id_barang, $qty, $org_id_pemilik, $org_type)
    {

        $stockBuku = new StockBuku();
        if ($org_type == KEY::$KPO) {
            $arrStockBuku = $stockBuku->getWhere("stock_id_buku=$id_barang AND stock_buku_status_kpo=1 AND stock_buku_kpo = $org_id_pemilik ORDER BY stock_buku_id ASC LIMIT $qty");

            return count($arrStockBuku);
        } elseif ($org_type == KEY::$IBO) {
            $arrStockBuku = $stockBuku->getWhere("stock_id_buku=$id_barang AND stock_status_ibo=1 AND stock_buku_ibo = $org_id_pemilik ORDER BY stock_buku_id ASC LIMIT $qty");
            return count($arrStockBuku);
        } elseif ($org_type == KEY::$TC) {
            $arrStockBuku = $stockBuku->getWhere("stock_id_buku=$id_barang AND stock_status_tc=1 AND stock_buku_tc = $org_id_pemilik ORDER BY stock_buku_id ASC LIMIT $qty");
            return count($arrStockBuku);
        }

    }

    public function setNoBuku($id_barang, $qty, $org_id_pemilik, $org_id_peminta, $org_type, $po_id)
    {

        $stockBuku = new StockBuku();
        if ($org_type == KEY::$KPO) {
            $arrStockBuku = $stockBuku->getWhere("stock_id_buku=$id_barang AND stock_buku_status_kpo=1 AND stock_buku_kpo = $org_id_pemilik ORDER BY stock_buku_id ASC LIMIT $qty");
            foreach ($arrStockBuku as $val) {
                $val->stock_buku_status_kpo = 0;
                $val->stock_status_ibo = 1;
                $val->stock_buku_tgl_keluar_kpo = leap_mysqldate();
                $val->stock_buku_tgl_masuk_ibo = leap_mysqldate();
                $val->stock_buku_ibo = $org_id_peminta;
                $val->stock_po_pesanan_ibo = $po_id;
                $val->save(1);
            }
        } elseif ($org_type == KEY::$IBO) {

            $arrStockBuku = $stockBuku->getWhere("stock_id_buku=$id_barang AND stock_status_ibo=1 AND stock_buku_ibo = $org_id_pemilik ORDER BY stock_buku_id ASC LIMIT $qty");
            foreach ($arrStockBuku as $val) {
                $val->stock_status_ibo = 0;
                $val->stock_status_tc = 1;
                $val->stock_buku_tgl_keluar_ibo = leap_mysqldate();
                $val->stock_buku_tgl_masuk_tc = leap_mysqldate();
                $val->stock_buku_tc = $org_id_peminta;
                $val->stock_po_pesanan_tc = $po_id;
                $val->save(1);
            }


        } elseif ($org_type == KEY::$TC) {
            $arrStockBuku = $stockBuku->getWhere("stock_id_buku=$id_barang AND stock_status_tc=1 AND stock_buku_kpo = $org_id_pemilik ORDER BY stock_buku_id ASC LIMIT $qty");
            foreach ($arrStockBuku as $val) {
                $val->stock_buku_status_kpo = 0;
                $val->stock_buku_status_ibo = 1;
                $val->stock_buku_tgl_keluar_kpo = leap_mysqldate();
                $val->stock_buku_tgl_masuk_ibo = leap_mysqldate();
                $val->stock_buku_ibo = $org_id_peminta;
                $val->save(1);
            }
        }

    }


    public function getLastNomorBuku()
    {
        $no = "31799999";
        pr($no);
        $awalan = substr($no, 0, 3);
        pr($awalan);
        $help = substr($no, 3, strlen($no));
        pr($help);
        $c = ((int)$help);
        $c++;
        pr($c);
        if (strlen($c) == 1) {
            // 0 ada 4
            pr($awalan . "0000" . $c);
        } else if (strlen($c) == 2) {
            // 0 ada 3
            pr($awalan . "000" . $c);
        } else if (strlen($c) == 3) {
            // 0 ada 2
            pr($awalan . "00" . $c);
        } else if (strlen($c) == 4) {
            // 0 ada 1
            pr($awalan . "0" . $c);
        } else {
            pr($awalan . $c);
        }

        pr(strlen($c));
    }

    public function getLevelByBarangID()
    {


        $id_barang = $_GET['id'];

        $obj = new BarangWebModel();
        $obj->getWhereOne("id_barang_harga=$id_barang");

        if (!(is_null($obj->id_barang_harga))) {
            $kur = $obj->jenis_kurikulum;
            $arrKur = Generic::returnKurikulum();
            echo Generic::getLevelNameByID($obj->level) . " - " . $arrKur[$kur];
        }

//        public $jenis_kurikulum;
//        public $level;

    }

    public function getAllBuku()
    {
        $stockNoBuku = new StockBuku();
        $arrBuku = $stockNoBuku->getWhere("stock_buku_id >=1 GROUP BY stock_id_buku");
        $res = array();
        foreach ($arrBuku as $val) {
            $res[] = $val->stock_id_buku;
        }
        pr($res);
    }

    public function ambilidbarang()
    {
        $arrResLevel = Generic::getLevelKurikulumLama();


        pr($arrResLevel);
        die();

        $brg = new BarangWebModel();

        pr($brg->getNamaBukuByID(3));

        die();
        $next_level = Generic::getMyNextLevelLama(2);

        pr($next_level->id_level_lama);

        die();

        $weiter = true;
        pr($weiter);
        $weiter = $weiter & false;

        pr($weiter);

        die();


        $res = array();

        pr(count($res));

        die();
        // Check No Buku
        $setNoBuku = new StockBuku();
        $resStokBuku = $setNoBuku->setStatusBuku(2, 4, 55, 0);
        pr($resStokBuku);
    }

    public function getBkuNo()
    {

        $a = "21500002";
        $awalan = substr($a, 0, 3);
        pr($awalan);
        $stock = new StockBuku();
        pr($stock->getBukuNoByInvoiceID(2381));
    }

    public function loginidorg()
    {
//        unset($_SESSION);
        pr(Generic::getAllLevel());
        die();

//        pr(AccessRight::getMyOrgID() . " - " . AccessRight::getMyOrgType());
//        pr(AccessRight::getMyAR_All());
//        pr($_SESSION);
//        die();
//        Auth::logout();
        $userid = 104;
        $acc = new SempoaAccount();
        $acc->getByID($userid);
        $row = array();

        foreach ($acc as $key => $value) {
            $row[$key] = $value;
        }


        AuthSempoa::loginSempoaIBO($row);
        if (Auth::isLogged()) {
            pr($_SESSION);
            die();
            header("Location:" . _BPATH . "home?st=dashboard_tc");

        }

    }

    public function getTC()
    {

        $a = new SempoaOrg();
        $a->printColumlistAsAttributes();
        die();
        $noInvoice = "FP/2017/8/7";
        $iuranBuku = new IuranBuku();
        $iuranBuku->getWhereOne("bln_no_invoice='$noInvoice'");
        $id_invoice = $iuranBuku->bln_id;

        pr($id_invoice);
        die();
        $stockBuku = new StockBuku();
        $arrStockBuku = $stockBuku->getWhere("stock_invoice_murid='$id_invoice'");
        pr($arrStockBuku);
        die();

        $invoice_id = 2416;
        $stockBuku = new StockBuku();
        $stockBuku->retourBukuMurid($invoice_id);


        die();
//        $iuranBulanan = new IuranBulanan();
//        $iuranBulanan->getWhereOne("bln_no_invoice='$noInvoice'");
//        $id_invoice = $iuranBulanan->bln_id;
//        $stockBuku = new StockBuku();
//        $arrStockBuku = $stockBuku->getWhere("stock_invoice_murid='$id_invoice'");
//        foreach($arrStockBuku as $buku){
//            $stockBuku = new StockBuku();
//            $stockBuku->retourBukuMurid($id_invoice);
//        }
//

        $id_buku = "3,4";
        $arrIDBuku = explode(",", $id_buku);
        pr($arrIDBuku);
        foreach ($arrIDBuku as $val) {
            $stockBarangBuku = new StockModel();
            $stockBarangBuku->getWhereOne("id_barang = '$val' AND org_id='4'");
            $stockBarangBuku->jumlah_stock = $stockBarangBuku->jumlah_stock - 1;
//            $stockBarangBuku->save();
            $setNoBuku = new StockBuku();
            $resBuNo = $setNoBuku->getBukuYgdReservMurid(2, 4, 13029, 0);
            pr($resBuNo);
//            $setNoBuku->setStatusBuku($resBuNo, $murid_id);
        }
        die();
        pr(_PHOTOPATH);
        pr(_SPPATH . _PHOTOURL);
        $acc = new SempoaAccount();
        $acc->getWhereOne("admin_id='104'");
        pr($acc->admin_username);

        die();
        return $acc->admin_username;


        $obj = new SempoaOrg();

//        pr($IBOid);
        $arr = $obj->getWhere("org_type='tc' AND org_parent_id='3' ORDER BY nama ASC");
//        pr($arr);
        if (count($arr) > 0) {
            foreach ($arr as $val) {
                $arrTC[$val->org_id] = $val->nama;
            }
        }
        pr($arrTC);

        die();
        $arrSortTC = $arrTC;
        sort($arrSortTC);
        $arrNewSort = array();
        foreach ($arrSortTC as $val) {
            $arrNewSort[array_search($val, $arrTC)] = $val;
//            pr($val);
        }
        pr($arrNewSort);
        pr($arrTC);
    }
}