<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 8/3/17
 * Time: 10:27 AM
 */
class StockBuku extends Model
{
    var $table_name = "sempoa__stock_buku";
    var $main_id = "stock_buku_id";

//Default Coloms for read
    public $default_read_coloms = "stock_buku_id,stock_buku_no,stock_name_buku,stock_id_buku,stock_grup_level,stock_murid_id,stock_buku_status_kpo,stock_status_ibo,stock_status_tc,stock_murid,stock_buku_tgl_masuk_kpo,stock_buku_tgl_keluar_kpo,stock_buku_tgl_masuk_ibo,stock_buku_tgl_keluar_ibo,stock_buku_tgl_masuk_tc,stock_buku_tgl_keluar_tc,stock_po_pesanan_ibo,stock_buku_tgl_keluar_tc,stock_invoice_murid,stock_buku_kpo,stock_buku_ibo,stock_buku_tc";

//allowed colom in CRUD filter
    public $coloumlist = "stock_buku_id,stock_buku_no,stock_name_buku,stock_id_buku,stock_grup_level,stock_murid_id,stock_buku_status_kpo,stock_status_ibo,stock_status_tc,stock_murid,stock_buku_tgl_masuk_kpo,stock_buku_tgl_keluar_kpo,stock_buku_tgl_masuk_ibo,stock_buku_tgl_keluar_ibo,stock_buku_tgl_masuk_tc,stock_buku_tgl_keluar_tc,stock_po_pesanan_ibo,stock_buku_tgl_keluar_tc,stock_invoice_murid,stock_buku_kpo,stock_buku_ibo,stock_buku_tc";
    public $stock_buku_id;
    public $stock_buku_no;
    public $stock_name_buku;
    public $stock_id_buku;
    public $stock_grup_level;
    public $stock_buku_status_kpo;
    public $stock_status_ibo;
    public $stock_status_tc;
    public $stock_murid;
    public $stock_buku_tgl_masuk_kpo;
    public $stock_buku_tgl_keluar_kpo;
    public $stock_buku_tgl_masuk_ibo;
    public $stock_buku_tgl_keluar_ibo;
    public $stock_buku_tgl_masuk_tc;
    public $stock_buku_tgl_keluar_tc;
    public $stock_po_pesanan_ibo;
    public $stock_po_pesanan_tc;
    public $stock_invoice_murid;
    public $stock_buku_kpo;
    public $stock_buku_ibo;
    public $stock_buku_tc;
    public $stock_murid_id;

    public function getMyLastNummer($id_barang)
    {
        $this->getWhereOne("stock_id_buku=$id_barang ORDER by stock_buku_id DESC");
        if ((is_null($this->stock_buku_id))) {
            // ambil 3digit pertama
            $barang = new BarangWebModel();
            $barang->getByID($id_barang);
            if (!(is_null($barang->id_barang_harga))) {
                if ($barang->no_buku == "") {
                    return "0";
                } else {
                    return $barang->no_buku . "00001";
                }

            } else {
                return "0";
            }

        } else {
            $lastnummer = Generic::getLastNomorBuku($this->stock_buku_no);
            return $lastnummer;
        }

    }

    public function createNoBuku($id_barang, $no_buku, $kpo,$name_barang)
    {
        $level = Generic::getLevelIdByIdBarang($id_barang);
        $a = new $this();
        $a->stock_id_buku = $id_barang;
        $a->stock_buku_no = $no_buku;
        $a->stock_buku_status_kpo = 1;
        $a->stock_buku_kpo = $kpo;
        $a->stock_buku_tgl_masuk_kpo = leap_mysqldate();
        $a->stock_grup_level = $level;
        $a->stock_name_buku = $name_barang;
        $a->save();

    }

    public function getBukuYgdReservMurid($level, $org_id_pemilik, $id_murid, $kurikulum)
    {

        $arrIdBarang = Generic::getIdBarangByLevel($level, $kurikulum);
        $res = array();
        foreach ($arrIdBarang as $val) {
            $buno = new StockBuku();
            $buno->getWhereOne("stock_id_buku=$val AND stock_status_tc=1 AND stock_buku_tc=$org_id_pemilik ORDER BY stock_buku_id ASC");

            if (is_null($buno->stock_buku_id)) {

            } else {
                $res[] = $buno->stock_buku_id;
            }
        }
        return $res;
    }

    public function setStatusBuku($res, $id_murid, $inv_bln_id)
    {

        if (count($res) == 0) {
            return false;
        } else {
            foreach ($res as $val) {
                $buno = new $this();
                $buno->getbyid($val);
                $buno->stock_status_tc = 0;
                $buno->stock_buku_tgl_keluar_tc = leap_mysqldate();
                $buno->stock_murid_id = $id_murid;
                $buno->stock_murid = 1;
                $buno->stock_invoice_murid = $inv_bln_id;
                $buno->save(1);

            }
            return true;
        }

    }

    public function getBarangIDbyPk($stock_buku_id)
    {
        $buno = new $this();
        $buno->getbyid($stock_buku_id);
        return $buno->stock_id_buku;
    }

    public function checkJumlahBarangByLevel($level, $org_id, $orgType)
    {
        $buno = new StockBuku();
        if ($orgType == KEY::$KPO) {

        } elseif ($orgType == KEY::$IBO) {

        } elseif ($orgType == KEY::$TC) {
            $buno->getWhere("stock_status_tc=1 AND stock_grup_level=$level AND stock_buku_tc=$org_id");
        }
    }

    public function getNoBukuById($id)
    {
        $this->getByID($id);
        return $this->stock_buku_no;

    }

    public function getBukuNoByStudentID($student_id){
        $buno = new $this();
        $arrStudent = $buno->getwhere("stock_murid_id=$student_id ORDER by stock_grup_level DESC");
        return $arrStudent;
    }

    public function getBukuNoByInvoiceID($stock_invoice_murid){
        $buno = new $this();
        $arr = $buno->getWhere("stock_invoice_murid='$stock_invoice_murid'");
        $res = array();
        foreach($arr as $val){
            $brg = new BarangWebModel();
//            $brg->getNamaBukuByNoBuku(substr($val->stock_buku_no,0,3));
            $res[ $val->stock_buku_no] = $val->stock_name_buku;
        }
        return $res;
    }

    public function retourBukuMurid($invoice_id){
        $this->getWhereOne("stock_murid=1 AND stock_invoice_murid='$invoice_id'");

        if(!is_null($this->stock_buku_id)){
            $this->stock_buku_tc = 1;
            $this->stock_murid =0;
            $this->stock_invoice_murid = "";
            $this->stock_murid_id = "";
            $this->save(1);

        }
    }
}