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

    function murid_iuranBuku_load()
    {
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;
        $id = addslashes($_GET['id']);
        $iuranBuku = new IuranBuku();
        $arrIuranBuku = $iuranBuku->getWhere("bln_murid_id='$id' ORDER by bln_date_pembayaran DESC LIMIT $begin,$limit");
        $jumlahTotal = $iuranBuku->getJumlah("bln_murid_id='$id'");
//        pr($arrIuranBuku);
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $arrPembayaran = Generic::getJenisPembayaran();
        $arrSTatus = array("<b>Unpaid</b>", "Paid");
        $murid = new MuridModel();
        $murid->getByID($id);
        foreach ($arrIuranBuku as $key => $val) {
            ?>
            <tr>
            <td><?= $val->bln_date_pembayaran; ?></td>
            <td><?= Generic::getLevelNameByID($val->bln_buku_level); ?></td>
            <td><?
                if ($val->bln_status)
                    echo $arrSTatus[$val->bln_status];
                else {

                    if (AccessRight::getMyOrgType() == "tc") {
                        ?>
                        <button class="btn btn-default belumbayar_<?= $val->bln_id; ?>"
                                id='pay_now_bulanan_<?= $val->bln_id; ?>'>Pay Now
                        </button>

                        <?
                    } else {
                        echo "<b>Unpaid</b>";
                    }
                }
                ?></td>

            <td><?
                if ($val->bln_status)
                    echo $arrPembayaran[$val->bln_cara_bayar];
                else {
                    if (AccessRight::getMyOrgType() == "tc") {
                        ?>
                        <select id="jenis_pmbr_invoice_<?= $val->bln_id ?>">
                            <?
                            foreach ($arrPembayaran as $key => $by) {
                                ?>
                                <option value="<?= $key; ?>"><?= $by; ?></option>
                                <?
                            }
                            ?>
                        </select>
                        <?
                    }
                }
                ?></td>
            <td><?
                if ($val->bln_status)
                    echo $arrPembayaran[$val->bln_cara_bayar];
                else {
                    if (AccessRight::getMyOrgType() == "tc") {
                        ?>
                        <select id="jenis_pmbr_invoice_<?= $val->bln_id ?>">
                            <?
                            foreach ($arrPembayaran as $key => $by) {
                                ?>
                                <option value="<?= $key; ?>"><?= $by; ?></option>
                                <?
                            }
                            ?>
                        </select>
                        <?
                    }
                }
                ?></td>


            <td>
                <?
                if ($val->bln_status == 0) {
//                                                echo $mk->bln_kupon_id;
                } else {
                    if ($murid->id_level_masuk == $val->bln_buku_level) {
                        echo "<a target=\"_blank\" href=" . _SPPATH . "MuridWebHelper/printRegister?id_murid=" . $id . "><span  style=\"vertical-align:middle\" class=\"glyphicon glyphicon-print\"  aria-hidden=\"true\"></span>
                                            </a>";
                    } else {
                        ?>
                        <a target="_blank"
                           href="<?= _SPPATH; ?>MuridWebHelper/printBuku?nama=<?= Generic::getMuridNamebyID($id); ?>&id_murid=<?= $id; ?>&tgl=<?= $val->bln_date_pembayaran; ?>&level=<?= Generic::getLevelNameByID($val->bln_buku_level); ?>">

                            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                        </a>
                        <?
                    }


                }
                ?>

            </td>
            <script>
                <?
                if ($val->bln_status) {
                ?>
                $('#belumbayar_<?= $val->bln_id; ?>').hide();
                <?
                } else {
                ?>
                $('#belumbayar_<?= $val->bln_id; ?>').show();
                <?
                }
                ?>
                $('#pay_now_bulanan_<?= $val->bln_id; ?>').click(function () {
                    var jpb = $('#jenis_pmbr_invoice_<?= $val->bln_id ?>').val();
                    var bln_id = <?= $val->bln_id; ?>;
                    $.post("<?= _SPPATH; ?>LaporanWebHelper/pay_iuran_buku_roy", {
                            bln_id: bln_id,
                            cara_pby: jpb
                        },
                        function (data) {
                            alert(data.status_message);
                            if (data.status_code) {
                                $('#belumbayar_<?= $val->bln_id; ?>').hide();
                                $('.sudahbayar').show();
                                $('#jenis_pmbr_invoice_<?= $val->bln_id ?>').attr("disabled", "true");
                                lwrefresh(selected_page);
                                // Refresh profile muridnya
                                lwrefresh("Profile_Murid");
                            } else {
                            }
                            console.log(data);
                            //                                                                $('#balikan_<? //= $val->bln_id;                                                                                                                          ?>//').html(data);
                        }, 'json');
                });
                //


            </script>

            <?
        }


    }


    public function getTC()
    {

        $noInvoice = "FP/2017/8/7";

        $a = substr($noInvoice, 0, 2);

        pr($a);
        die();


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

    public function prompt()
    {
        ?>
        <button id="btn_ha">Click</button>
        <script>
            $("#btn_ha").click(function () {
                alert("saas");
            });
        </script>
        <?
    }

    public function jenisBiaya()
    {

        die();
        $buku = new StockBuku();
        $buku->getBukuYgdReservMurid(7, 5, 831, 1, KEY::$JENIS_BUKU);
        pr($buku);


        die();
        $jumlahBukuIst = Generic::getIdBarangByLevel(1, 0);

        pr($jumlahBukuIst);
        die();
        $no_mulai = 010;


        $stk_masuk = 10;
        for ($i = 0; $i < $stk_masuk; $i++) {
            $stockBuku = new StockBuku();
//                if (strlen($no_buku_mulai) == 1) {
//                    // 0 ada 4
//                    $noKuponAwal = $tigaDigitNobuku . "0000" . $no_buku_mulai;
//                } else if (strlen($no_buku_mulai) == 2) {
//                    // 0 ada 3
//                    $noKuponAwal  = $tigaDigitNobuku . "000" . $no_buku_mulai;
//                } else if (strlen($no_buku_mulai) == 3) {
//                    // 0 ada 2
//                    $noKuponAwal  = $tigaDigitNobuku . "00" . $no_buku_mulai;
//                } else if (strlen($no_buku_mulai) == 4) {
//                    // 0 ada 1
//                    $noKuponAwal  = $tigaDigitNobuku . "0" . $no_buku_mulai;
//                } else {
//                    $noKuponAwal  = $tigaDigitNobuku . $no_buku_mulai;
//                }

//            $stockBuku->createNoBuku($id_barang, $noKuponAwal, AccessRight::getMyOrgID(), $name_barang);
//            $noKuponAwal++;
        }


        die();
        $barang = new BarangWebModel();

        pr($barang->getStockByIdJenisBarang(1));

        die();
        $arr = $barang->getWhere("1 GROUP BY  jenis_biaya");
        foreach ($arr as $val) {
            $res[] = $val->jenis_biaya;
        }
        pr($res);
    }

    function printRegis()
    {
        ?>

        <head>
            <title>Invoice Iuran Buku</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        </head>
        <body>


        <div class="Invoice_org_tua">
            <div class="kop_surat">
                <img src="<?= _SPPATH . _PHOTOURL; ?>Picture1.png" alt="logo_sempoa" class="img-responsive center-block" />

                <div class="container container-table">
                    <div class="row vertical-center-row">
                        <div class="text-center col-md-6 col-md-offset-3" style="">
                            <h4 id="data_tc">
                                TC Taman Semanan Indah<br>
                                Ruko Blok F No 7, Taman Semanan Indah Jakarta Barat<br>
                                Telp. 021-5444398 Fax. 021-5444397 HP 08159923311
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <b>No. Invoice :</b><br>
                            <b>Tanggal :</b><br><br>
                            Telah diterima pembayaran oleh Murid :<br>
                            <b>Nama Murid :</b><br>
                            <b>ID Murid :</b>
                        </div>
                    </div>

                    <br>
                </div>

            </div>

            <div class="container">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table_invoice">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Keterangan</th>
                            <th>Harga</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>No Pendaftran</td>
                            <td>Biaya Registrasi</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Kode Kupon</td>
                            <td>Iuran Bulanan : Agustus 2017</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No Buku</td>
                            <td>Uang Buku Junior 1</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Biaya Perlengkapan</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Jumlah</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        Pembayaran melalui mesin EDC atau via transfer ke :
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="vertical-center-row">
                    <div class="text-center col-md-6 col-md-offset-3" style="">
                        <h4 id="sempoasip_pusat">SEMPOA SIP<br>BCA cabang Supermal Karawaci<br>a/c. 1234567890</h4>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="vertical-center-row">
                    <div class="text-center col-md-6 col-md-offset-3" style="">
                        <h2>Terima Kasih</h2>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="vertical-center-row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="col-md-6"><img style="display:block; margin:auto; width: 100px; height: 100px " src="<?= _SPPATH . _PHOTOURL; ?>Sempa_20.png">
                        </div>
                        <div class="col-md-6"><span><img  style="display:block; margin:auto; width: 100px; height: 100px " src="<?= _SPPATH . _PHOTOURL; ?>Sempi_20.png"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12 text-right">.................., 31 Agustus 2017</div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="container">
                <div class="vertical-center-row">
                    <div class="col-md-8">
                        Catatan : Setiap Training Centre beroperasional dan memiliki kepemilikan secara mandiri
                    </div>

                    <div class="col-md-4 text-right">
                        Training Center
                    </div>
                </div>
            </div>

        </div>
        <hr>
        <div class="Invoice_tc">
            <div class="kop_surat">
                <img src="file:///Users/marselinuskristian/Documents/Sempoa/Picture1.png" alt="logo_sempoa" class="img-responsive center-block" />

                <div class="container container-table">
                    <div class="row vertical-center-row">
                        <div class="text-center col-md-6 col-md-offset-3" style="">
                            <h4 id="data_tc">
                                TC Taman Semanan Indah<br>
                                Ruko Blok F No 7, Taman Semanan Indah Jakarta Barat<br>
                                Telp. 021-5444398 Fax. 021-5444397 HP 08159923311
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <b>No. Invoice :</b><br>
                            <b>Tanggal :</b><br><br>
                            Telah diterima pembayaran oleh Murid :<br>
                            <b>Nama Murid :</b><br>
                            <b>ID Murid :</b>
                        </div>
                    </div>

                    <br>
                </div>

            </div>

            <div class="container">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table_invoice">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Keterangan</th>
                            <th>Harga</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>No Pendaftran</td>
                            <td>Biaya Registrasi</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Kode Kupon</td>
                            <td>Iuran Bulanan : Agustus 2017</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No Buku</td>
                            <td>Uang Buku Junior 1</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Biaya Perlengkapan</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Jumlah</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        Pembayaran melalui mesin EDC atau via transfer ke :
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="vertical-center-row">
                    <div class="text-center col-md-6 col-md-offset-3" style="">
                        <h4 id="sempoasip_pusat">SEMPOA SIP<br>BCA cabang Supermal Karawaci<br>a/c. 1234567890</h4>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="vertical-center-row">
                    <div class="text-center col-md-6 col-md-offset-3" style="">
                        <h2>Terima Kasih</h2>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="vertical-center-row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="col-md-6"><img style="display:block; margin:auto; width: 100px; height: 100px " src="file:///Users/marselinuskristian/Documents/Sempoa/Sempa%2020.png">
                        </div>
                        <div class="col-md-6"><span><img  style="display:block; margin:auto; width: 100px; height: 100px " src="file:///Users/marselinuskristian/Documents/Sempoa/Sempi%2020.png"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12 text-right">.................., 31 Agustus 2017</div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="container">
                <div class="vertical-center-row">
                    <div class="col-md-8">
                        Catatan : Setiap Training Centre beroperasional dan memiliki kepemilikan secara mandiri
                    </div>

                    <div class="col-md-4 text-right">
                        Training Center
                    </div>
                </div>
            </div>

        </div>
        </body>
        <?
    }
}