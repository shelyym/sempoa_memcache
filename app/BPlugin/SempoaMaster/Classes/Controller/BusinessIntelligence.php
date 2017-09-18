<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BusinessIntelligence
 *
 * @author efindiongso
 */
class BusinessIntelligence extends WebService
{

    public function view_bi_siswa_ibo()
    {
        $kpo_id = AccessRight::getMyOrgID();
        $arrMyIBO = Generic::getAllMyIBO($kpo_id);
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $ibo_id = isset($_GET['ibo_id']) ? addslashes($_GET['ibo_id']) : key($arrMyIBO);
        $t = time();
        $arrBulan = Generic::getAllMonths();
        ?>
        <section class="content-header">
            <div class="box-tools pull-right">

                <label for="exampleInputName2">Pilih IBO:</label>
                <select id="pilih_IBO_<?= $t; ?>">

                    <?
                    foreach ($arrMyIBO as $key => $val) {
                        ?>
                        <option value="<?= $key; ?>"><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>

                Bulan :<select id="bulan_<?= $t; ?>">
                    <?
                    foreach ($arrBulan as $bln2) {
                        $sel = "";
                        if ($bln2 == date("n")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                        <?
                    }
                    ?>
                </select>
                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>

                <button id="submit_rekap_<?= $t; ?>">submit</button>
                <?= Generic::printsempoa(); ?>
            </div>
        </section>
        <div class="clearfix"></div>
        <div id="content_<?= $ibo_id . "_" . $bln . "_" . $thn; ?>">
            <?
            $arrMyTC = Generic::getAllMyTC($ibo_id);
            $waktu = $bln . "-" . $thn;
            $hasil = array();
            $i = 0;
            foreach ($arrMyTC as $keytc => $tc) {
                $rekap_siswa = new RekapSiswaIBOModel();
                $arrRekapSiswa = $rekap_siswa->getWhere("bi_rekap_tc_id = '$keytc' AND bi_rekap_ibo_id='$ibo_id' AND bi_rekap_siswa_waktu = '$waktu' ");

                if (count($arrRekapSiswa) > 0) {
                    $hasil[$i]['tc'] = $tc;
                    $hasil[$i]['bln'] = $bln;
                    $hasil[$i]['thn'] = $thn;
                    $hasil[$i]['baru'] = $arrRekapSiswa[0]->bi_rekap_baru;
                    $hasil[$i]['keluar'] = $arrRekapSiswa[0]->bi_rekap_keluar;
                    $hasil[$i]['cuti'] = $arrRekapSiswa[0]->bi_rekap_cuti;
                    $hasil[$i]['lulus'] = $arrRekapSiswa[0]->bi_rekap_lulus;
                    $hasil[$i]['aktiv'] = $arrRekapSiswa[0]->bi_rekap_aktiv;
                    $hasil[$i]['kupon'] = $arrRekapSiswa[0]->bi_rekap_kupon;
                    $i++;
                }
            }
            ?>
            <div class="row box-body chart-responsive">

                <div class="col-xs-12">
                    <h3>Rekapitulasi Siswa TC per <?= $bln . "/" . $thn; ?> </h3>
                    <div class="chart" id="bar-chart" style="height: 300px; background-color: white;">
                        <?
                        $xLabels = array('aktiv', 'baru', 'cuti', 'keluar', 'lulus', 'kupon');
                        //                        pr($hasil);
                        Charting::chartJSBar('300px', $xLabels, $hasil);
                        ?>
                    </div>
                </div>

            </div>
        </div>


        <script>
            $(document).ready(function () {
                var ibo_id = $('#pilih_IBO_<?= $t; ?>').val();
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                $('#content_<?= $ibo_id . "_" . $bln . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadRekapSiswa?ibo_id=" + ibo_id + "&bln=" + bln + "&thn=" + thn, function () {

                }, 'json');
            });
            $('#submit_rekap_<?= $t; ?>').click(function () {
                var ibo_id = $('#pilih_IBO_<?= $t; ?>').val();
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                $('#content_<?= $ibo_id . "_" . $bln . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadRekapSiswa?ibo_id=" + ibo_id + "&bln=" + bln + "&thn=" + thn, function () {

                }, 'json');
            });</script>
        <?
    }

    //put your code here
    public function get_bi_rekap_siswa()
    {
        ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@TwBootstrap</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </div>


        <?
        $ibo = new SempoaOrg();
        $arrIbo = $ibo->getWhere("org_type='ibo'");
        $allIbo = array();
        foreach ($arrIbo as $val) {
            $allIbo[$val->org_id] = $val->nama;
        }
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $waktu = $bln . "-" . $thn;
        foreach ($allIbo as $keyibo => $valibo) {
            $arrTC = Generic::getAllMyTC($keyibo);
            foreach ($arrTC as $keytc => $tc) {
                $rekap_siswa = new RekapSiswaIBOModel();
                $rekap_siswa->getWhereOne("bi_rekap_tc_id = '$keytc' AND bi_rekap_ibo_id='$keyibo' AND bi_rekap_siswa_waktu = '$waktu' ");

                if (is_null($rekap_siswa->bi_rekap_kode_tc)) {
                    $rekap_siswa = new RekapSiswaIBOModel();
                    $tc = new SempoaOrg();
                    $tc->getByID($keytc);
                    $rekap_siswa->bi_rekap_tc_id = $keytc;
                    $rekap_siswa->bi_rekap_ibo_id = $keyibo;
                    $rekap_siswa->bi_rekap_siswa_waktu = $waktu;
                    $rekap_siswa->bi_rekap_kode_tc = $tc->org_kode;
                    $rekap_siswa->bi_rekap_nama_tc = $tc->nama;
                    $rekap_siswa->bi_rekap_nama_director = $tc->nama_pemilik;
                    $aktiv = $this->getMuridStatusByTC(KEY::$STATUSMURIDAKTIV, $keytc, $bln, $thn);
                    $cuti = $this->getMuridStatusByTC(KEY::$STATUSMURIDCUTI, $keytc, $bln, $thn);
                    $keluar = $this->getMuridStatusByTC(KEY::$STATUSMURIDNKELUAR, $keytc, $bln, $thn);
                    $baru = $this->getMuridBaruByTC($keytc, $bln, $thn);
                    $rekap_siswa->bi_rekap_baru = $baru;
                    $rekap_siswa->bi_rekap_aktiv = $aktiv;
                    $rekap_siswa->bi_rekap_cuti = $cuti;
                    $rekap_siswa->bi_rekap_keluar = $keluar;
                    $rekap_siswa->bi_rekap_kupon = $this->getPenjualanKuponByTC($keytc, $bln, $thn);
                    $rekap_siswa->bi_rekap_jumlah_guru = $this->getGuruAktivByTC($keytc, $bln, $thn);
                    $rekap_siswa->bi_rekap_bln = $bln;
                    $rekap_siswa->bi_rekap_tahun = $thn;
                    $rekap_siswa->bi_rekap_buku = $this->getPenjualanBukuByTC($keytc, $bln, $thn);
                    $rekap_siswa->save();
                } else {
                    $tc = new SempoaOrg();
                    $tc->getByID($keytc);
                    $rekap_siswa->bi_rekap_tc_id = $keytc;
                    $rekap_siswa->bi_rekap_ibo_id = $keyibo;
                    $rekap_siswa->bi_rekap_siswa_waktu = $waktu;
                    $rekap_siswa->bi_rekap_kode_tc = $tc->org_kode;
                    $rekap_siswa->bi_rekap_nama_tc = $tc->nama;
                    $rekap_siswa->bi_rekap_nama_director = $tc->nama_pemilik;
                    $aktiv = $this->getMuridStatusByTC(KEY::$STATUSMURIDAKTIV, $keytc, $bln, $thn);
                    $cuti = $this->getMuridStatusByTC(KEY::$STATUSMURIDCUTI, $keytc, $bln, $thn);
                    $keluar = $this->getMuridStatusByTC(KEY::$STATUSMURIDNKELUAR, $keytc, $bln, $thn);
                    $baru = $this->getMuridBaruByTC($keytc, $bln, $thn);
                    $rekap_siswa->bi_rekap_baru = $baru;
                    $rekap_siswa->bi_rekap_aktiv = $aktiv;
                    $rekap_siswa->bi_rekap_cuti = $cuti;
                    $rekap_siswa->bi_rekap_keluar = $keluar;
                    $rekap_siswa->bi_rekap_kupon = $this->getPenjualanKuponByTC($keytc, $bln, $thn);
                    $rekap_siswa->bi_rekap_jumlah_guru = $this->getGuruAktivByTC($keytc, $bln, $thn);
                    $rekap_siswa->bi_rekap_buku = $this->getPenjualanBukuByTC($keytc, $bln, $thn);
                    $rekap_siswa->save(1);
                }
            }
        }
        ?>
        <section class="content">


            <div class="table-responsive">
                <div id="bar-example"></div>


                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align: middle !important;">No</th>
                        <th rowspan="2" style="vertical-align: middle !important;">Kode TC</th>
                        <th rowspan="2">Nama TC</th>
                        <th rowspan="2">Nama Director</th>
                        <th colspan="7">Januari</th>
                        <th colspan="7">Februari</th>
                        <th colspan="7">Maret</th>
                        <th colspan="7">April</th>
                        <th colspan="7">Mei</th>
                        <th colspan="7">Juni</th>
                        <th colspan="7">Juli</th>
                        <th colspan="7">Agustus</th>
                        <th colspan="7">September</th>
                        <th colspan="7">Oktober</th>
                        <th colspan="7">November</th>
                        <th colspan="7">Desember</th>
                    </tr>
                    <tr>
                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                    </tr>
                    </thead>

                </table>
            </div>
        </section>

        <?
    }

    public function get_rekap_siswa_kpo()
    {
        $kpo_id = AccessRight::getMyOrgID();
        $arrMyIBO = Generic::getAllMyIBO($kpo_id);
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $ibo_id = isset($_GET['ibo_id']) ? addslashes($_GET['ibo_id']) : key($arrMyIBO);
        $t = time();
        $arrBulan = Generic::getAllMonths();
        $arrBulan[count($arrBulan) + 1] = "All";

        $arrMyTC = Generic::getAllMyTC($ibo_id);
        ?>
        <div id="all">
            <section class="content-header">
                <h1>Laporan Rekapitulasi Siswa</h1>
                <div class="box-tools pull-right">

                    <label for="exampleInputName2">Pilih IBO:</label>
                    <select id="pilih_IBO_<?= $t; ?>">

                        <?
                        foreach ($arrMyIBO as $key => $val) {
                            ?>
                            <option value="<?= $key; ?>"><?= $val; ?></option>
                            <?
                        }
                        ?>
                    </select>

                    Bulan :<select id="bulan_<?= $t; ?>">
                        <?
                        foreach ($arrBulan as $bln2) {
                            $sel = "";
                            if ($bln2 == date("n")) {
                                $sel = "selected";
                            }
                            ?>
                            <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                            <?
                        }
                        ?>
                    </select>
                    Tahun :<select id="tahun_<?= $t; ?>">
                        <?
                        for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                            $sel = "";
                            if ($x == date("Y")) {
                                $sel = "selected";
                            }
                            ?>
                            <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                            <?
                        }
                        ?>
                        }
                        ?>
                    </select>

                    <button id="submit_rekap_<?= $t; ?>">submit</button>
                    <? Generic::exportLogo(); ?>
                </div>
            </section>
            <div class="clearfix"></div>

            <div id="content_<?= $ibo_id . "_" . $bln . "_" . $thn; ?>">
            </div>


            <script>

                $('#submit_rekap_<?= $t; ?>').click(function () {
                    var ibo_id = $('#pilih_IBO_<?= $t; ?>').val();
                    var bln = $('#bulan_<?= $t; ?>').val();
                    var thn = $('#tahun_<?= $t; ?>').val();
                    $('#kepala_<?= $bln . "_" . $thn; ?>').load('<?= _SPPATH; ?>BIWebHelper/loadRekapSiswaTable?ibo_id=' + ibo_id + '&bln=' + bln + '&thn=' + thn, function () {

                    }, 'json');
                });

            </script>

            <style>
                .thead .table-sempoa-border {
                    border: 4px;
                    border-style: solid;
                    border-color: burlywood;

                }

                .tengah {
                    vertical-align: middle !important;
                }

                .total {
                    text-align: center;
                    font-weight: bold;
                }
            </style>
            <div id="kepala_<?= $bln . "_" . $thn; ?>" class="table-responsive content">

                <table class="table table-bordered table-striped table-sempoa-border" style='background-color: white'>
                    <thead>
                    <tr>
                        <th class="tengah" rowspan="2">No.</th>
                        <th class="tengah" rowspan="2">Kode TC</th>
                        <th class="tengah" rowspan="2">Nama TC</th>
                        <th class="tengah" rowspan="2">Nama Director</th>
                        <?
                        if ($bln != "All") {
                            ?>
                            <th id="<?= $bln . "_" . $thn; ?>" class="total"
                                colspan="7"><?= Generic::getMonthName($bln); ?></th>

                            <?
                        }
                        ?>

                    </tr>
                    <tr>
                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                    </tr>
                    </thead>
                    <tbody id="load_<?= $bln . "_" . $thn; ?>">
                    <?
                    $i = 1;
                    $total_bl = 0;
                    $total_baru = 0;
                    $total_keluar = 0;
                    $total_cuti = 0;
                    $total_lulus = 0;
                    $total_aktiv = 0;
                    $total_kupon = 0;
                    foreach ($arrMyTC as $id_tc => $tc) {
                        $orgTC = new SempoaOrg();
                        $orgTC->getByID($id_tc);
                        ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $orgTC->org_kode; ?></td>
                            <td><?= $orgTC->nama; ?></td>
                            <td><?= $orgTC->nama_pemilik; ?></td>
                            <?
                            $org_tc = new RekapSiswaIBOModel();
                            $arrDaten = $org_tc->getDaten($bln, $thn, $orgTC->nama);
                            $total_bl += $arrDaten[0]->bi_rekap_bl;
                            $total_baru += $arrDaten[0]->bi_rekap_baru;
                            $total_keluar += $arrDaten[0]->bi_rekap_keluar;
                            $total_cuti += $arrDaten[0]->bi_rekap_cuti;
                            $total_lulus += $arrDaten[0]->bi_rekap_lulus;
                            $total_aktiv += $arrDaten[0]->bi_rekap_aktiv;
                            $total_kupon += $arrDaten[0]->bi_rekap_kupon;
                            ?>
                            <td><?= $arrDaten[0]->bi_rekap_bl; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_baru; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_keluar; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_cuti; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_lulus; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_aktiv; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_kupon; ?></td>
                        </tr>
                        <?
                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="total" colspan="4">Total</td>

                        <td><?= $total_bl; ?></td>
                        <td><?= $total_baru; ?></td>
                        <td><?= $total_keluar; ?></td>
                        <td><?= $total_cuti; ?></td>
                        <td><?= $total_lulus; ?></td>
                        <td><?= $total_aktiv; ?></td>
                        <td><?= $total_kupon; ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <script>

            $('#export_<?= $t; ?>').click(function () {
                var ibo_id = $('#pilih_IBO_<?= $t; ?>').val();
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?ibo_id=' + ibo_id + '&type=<?= KEY::$REPORT_REKAP_SISWA_KPO; ?>&bln=' + bln + "&thn=" + thn, "_blank ");
            });
        </script>
        <?
    }

    public function getMuridStatusByTC($status, $keytc, $bln, $thn)
    {
        $murid = new MuridModel();
        $statusMurid = new StatusHisMuridModel();
        $q = "SELECT * FROM {$murid->table_name} murid INNER JOIN {$statusMurid->table_name} status ON status.status_murid_id = murid.id_murid WHERE murid.murid_tc_id='$keytc' AND YEAR(status.status_tanggal_mulai ) = $thn AND MONTH(status.status_tanggal_mulai ) = $bln  AND status.status=$status GROUP BY murid.id_murid";
        global $db;
        $arrMurid = $db->query($q, 2);
        return count($arrMurid);
    }

    public function getMuridBaruByTC($keytc, $bln, $thn)
    {
        $murid = new MuridModel();

        $q = "SELECT * FROM {$murid->table_name} murid WHERE murid.murid_tc_id='$keytc' AND YEAR(murid.tanggal_masuk ) = $thn AND MONTH(murid.tanggal_masuk ) = $bln   ";
        global $db;
        $arrMurid = $db->query($q, 2);
        return count($arrMurid);
    }

    function getPenjualanKuponByTC($keytc, $bln, $thn)
    {
//        transaksi__kupon_satuan
        $kupon = new KuponSatuan();
        $arrKupon = $kupon->getWhere("kupon_owner_id='$keytc' AND YEAR(kupon_pemakaian_date) = $thn AND MONTH(kupon_pemakaian_date) = $bln");
        return count($arrKupon);
    }

    function getGuruAktivByTC($keytc, $bln, $thn)
    {
        $objGuru = new SempoaGuruModel();
        $nonAktiv = KEY::$STATUSGURURESIGN;
        $arrGuru = $objGuru->getWhere("status !='$nonAktiv' AND guru_tc_id='$keytc'");
        return count($arrGuru);
    }

    function getPenjualanBukuByTC($keytc, $bln, $thn)
    {

        $waktu = $bln . "-" . $thn;
        $iuranBuku = new IuranBuku();
        $arrIuranBuku = $iuranBuku->getWhere("bln_tc_id='$keytc' AND bln_date='$waktu'");
        return count($arrIuranBuku);
    }

    function get_rekap_all_siswa()
    {
        $arrAllIBO = Generic::getAllMyIBO(AccessRight::getMyOrgID());
//        $arrAllIBO = Generic::getAllIBO();
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $t = time();
        $arrBulan = Generic::getAllMonths();
        $arrBulan[count($arrBulan) + 1] = "All";
        ?>
        <div id="all">
            <section class="content-header">
                <center><h1>Laporan Rekapitulasi Siswa se Indonesia</h1></center>
                <div class="box-tools pull-right">

                    Bulan :<select id="bulan_<?= $t; ?>">
                        <?
                        foreach ($arrBulan as $bln2) {
                            $sel = "";
                            if ($bln2 == date("n")) {
                                $sel = "selected";
                            }
                            ?>
                            <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                            <?
                        }
                        ?>
                    </select>
                    Tahun :<select id="tahun_<?= $t; ?>">
                        <?
                        for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                            $sel = "";
                            if ($x == date("Y")) {
                                $sel = "selected";
                            }
                            ?>
                            <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                            <?
                        }
                        ?>
                        }
                        ?>
                    </select>

                    <button id="submit_rekap_all_siswa_<?= $t; ?>">submit</button>
                    <? Generic::exportLogo(); ?>
                </div>
            </section>


        </div>
        <div class="clearfix"></div>
        <div class="table-responsive">
            <section class="content" id="kepala_all_siswa_<?= $bln . "_" . $thn; ?>">

                <table class='table table-bordered table-striped' style="background-color: white;">
                    <thead>
                    <tr>
                        <th class="tengah" rowspan="2">No.</th>
                        <th class="tengah" rowspan="2">Wilayah</th>
                        <th class="tengah" rowspan="2">Nama IBO</th>


                        <th id="<?= $bln . "_" . $thn; ?>" class="total"
                            colspan="7"><?= Generic::getMonthName($bln); ?></th>


                    </tr>
                    <?
                    if ($bln != "All") {
                        ?>
                        <tr>
                            <th>BL</th>
                            <th>B</th>
                            <th>K</th>
                            <th>C</th>
                            <th>L</th>
                            <th>A</th>
                            <th>KPN</th>

                        </tr>
                        <?
                    } else {
                        ?>
                        <tr>
                            <?
                            foreach ($arrBulan as $val) {
                                if ($val != "All") {
                                    ?>

                                    <th>BL</th>
                                    <th>B</th>
                                    <th>K</th>
                                    <th>C</th>
                                    <th>L</th>
                                    <th>A</th>
                                    <th>KPN</th>


                                    <?
                                }
                            }
                            ?>
                        </tr>
                        <?
                    }
                    ?>

                    </thead>
                    <?
                    $index = 1;
                    $i = 0;
                    $hasilIBO = array();
                    foreach ($arrAllIBO as $key => $ibo) {
                        $ibo_org = new SempoaOrg;
                        $ibo_org->getByID($key);
                        $waktu = $bln . "-" . $thn;
                        $rekap_siswa = new RekapSiswaIBOModel();
                        $arrRekapSiswa = $rekap_siswa->getWhere("bi_rekap_ibo_id='$key' AND bi_rekap_siswa_waktu = '$waktu' ");
                        ?>
                        <tr>
                            <td><?= $index; ?></td>
                            <td><?= $ibo_org->propinsi; ?></td>
                            <td><?= $ibo_org->nama; ?></td>
                            <?
                            $hasilIBO[$i]['ibo'] = $ibo;
                            $hasilIBO[$i]['bln'] = $bln;
                            $hasilIBO[$i]['thn'] = $thn;
                            if (count($arrRekapSiswa) == 0) {
                                $hasilIBO[$i]['baru'] = 0;
                                $hasilIBO[$i]['keluar'] = 0;
                                $hasilIBO[$i]['cuti'] = 0;
                                $hasilIBO[$i]['lulus'] = 0;
                                $hasilIBO[$i]['aktiv'] = 0;
                                $hasilIBO[$i]['kupon'] = 0;
                            } else {
                                foreach ($arrRekapSiswa as $val) {
                                    $hasilIBO[$i]['baru'] += $val->bi_rekap_baru;
                                    $hasilIBO[$i]['keluar'] += $val->bi_rekap_keluar;
                                    $hasilIBO[$i]['cuti'] += $val->bi_rekap_cuti;
                                    $hasilIBO[$i]['lulus'] += $val->bi_rekap_lulus;
                                    $hasilIBO[$i]['aktiv'] += $val->bi_rekap_aktiv;
                                    $hasilIBO[$i]['kupon'] += $val->bi_rekap_kupon;
                                }
                            }
                            ?>
                            <td><?= 0 ?></td>
                            <td><?= $hasilIBO[$i]['baru']; ?></td>
                            <td><?= $hasilIBO[$i]['keluar']; ?></td>
                            <td><?= $hasilIBO[$i]['cuti']; ?></td>
                            <td><?= $hasilIBO[$i]['lulus']; ?></td>
                            <td><?= $hasilIBO[$i]['aktiv']; ?></td>
                            <td><?= $hasilIBO[$i]['kupon']; ?></td>
                        </tr>
                        <?
                        $i++;
                        $index++;
                        ?>
                        <?
                    }
                    ?>
                </table>

            </section>
        </div>
        <script>
            $('#submit_rekap_all_siswa_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                $('#kepala_all_siswa_<?= $bln . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadRekapAllSiswaTable?bln=" + bln + "&thn=" + thn, function () {

                }, 'json');
            });
            $('#export_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?type=<?= KEY::$REPORT_REKAP_ALL_SISWA_KPO; ?>&bln=' + bln + "&thn=" + thn, "_blank ");
            });
        </script>


        <?
    }

    function get_rekap_bulanan_kupon()
    {
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $t = time();
        $arrBulan = Generic::getAllMonthsWithAll();
        $arrMyTC = Generic::getAllMyTC(AccessRight::getMyOrgID());
        $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : Key($arrMyTC);
        ?>
        <section class="content-header">
            <h1>Rekapitulasi Kupon</h1>
            <div class="box-tools pull-right">

                <label for="exampleInputName2">Pilih TC:</label>
                <select id="pilih_TC_<?= $t; ?>">

                    <?
                    foreach ($arrMyTC as $key => $val) {
                        ?>
                        <option value="<?= $key; ?>"><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>

                Bulan :<select id="bulan_<?= $t; ?>">
                    <?
                    foreach ($arrBulan as $bln2) {
                        $sel = "";
                        if ($bln2 == date("n")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                        <?
                    }
                    ?>
                </select>
                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>
                <button id="submit_rekap_kupon_siswa_<?= $t; ?>">submit</button>
                <? Generic::exportLogo(); ?>
                <script>
                    $('#submit_rekap_kupon_siswa_<?= $t; ?>').click(function () {
                        var tc_id = $('#pilih_TC_<?= $t; ?>').val();
                        var bln = $('#bulan_<?= $t; ?>').val();
                        var thn = $('#tahun_<?= $t; ?>').val();
                        $('#content_kupon_<?= $tc_id . $bln . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadRekapKuponTC?tc_id=" + tc_id + "&bln=" + bln + "&thn=" + thn, function () {

                        }, 'json');
                    });
                </script>
            </div>
        </section>
        <section class="clearfix">
        </section>
        <section class="content">
            <div class="table-responsive" id="content_kupon_<?= $tc_id . $bln . $thn; ?>">
                <table class="table table-bordered table-striped putih">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Bulan</th>
                        <th>Stock</th>
                        <th>Kupon Masuk</th>
                        <th>Transaksi Bulan ini</th>
                        <th>Stock Akhir</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $bi_kupon_stock = 0;
                    $bi_kupon_kupon_masuk = 0;
                    $bi_kupon_trs_bln = 0;
                    $bi_kupon_stock_akhir = 0;
                    $arrKuponStock = 0;
                    $arrKuponmasuk = 0;
                    $arrKuponTraBln = 0;
                    $arrKuponStockAkhir = 0;
                    $i = 1;
                    $objRekapKupon = new BIRekapKuponModel();
                    $arrRekap = $objRekapKupon->getWhere("bi_kupon_tc_id=$tc_id AND bi_kupon_bln=$bln AND bi_kupon_thn=$thn");
                    $arrKuponStock += $arrRekap[0]->bi_kupon_stock;
                    $arrKuponmasuk += $arrRekap[0]->bi_kupon_kupon_masuk;
                    $arrKuponTraBln += $arrRekap[0]->bi_kupon_trs_bln;
                    $arrKuponStockAkhir += $arrRekap[0]->bi_kupon_stock_akhir;
                    $bi_kupon_stock = $arrRekap[0]->bi_kupon_stock;
                    $bi_kupon_kupon_masuk = $arrRekap[0]->bi_kupon_kupon_masuk;
                    $bi_kupon_trs_bln = $arrRekap[0]->bi_kupon_trs_bln;
                    $bi_kupon_stock_akhir = $arrRekap[0]->bi_kupon_stock_akhir;
                    ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= Generic::getMonthName($arrRekap[0]->bi_kupon_bln); ?></td>
                        <td><?= $bi_kupon_stock; ?></td>
                        <td><?= $bi_kupon_kupon_masuk; ?></td>
                        <td><?= $bi_kupon_trs_bln; ?></td>
                        <td><?= $bi_kupon_stock_akhir; ?></td>
                    </tr>

                    <? ?>
                    </tbody>

                    <tfoot>
                    <tr>
                        <td colspan="2" style="text-align:center; font-weight: bold">Total</td>
                        <td><?= $arrKuponStock; ?></td>
                        <td><?= $arrKuponmasuk; ?></td>
                        <td><?= $arrKuponTraBln; ?></td>
                        <td><?= $arrKuponStockAkhir; ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <style>
            .tengahcolumn {
                vertical-align: middle !important;
                font-weight: bold;
            }

            .putih {
                background-color: white;
            }
        </style>
        <script>
            $('#export_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                var tc_id = $('#pilih_TC_<?= $t; ?>').val();
                window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?tc_id=' + tc_id + '&type=<?= KEY::$REPORT_REKAP_BULANAN_KUPON; ?>&bln=' + bln + "&thn=" + thn, "_blank ");
            });
        </script>
        <?
    }

    function get_status_siswa_tahun_ibo()
    {
        $kpo_id = AccessRight::getMyOrgID();
    }

    function get_laporan_jumlah_siswa_by_status()
    {
        $kpo_id = AccessRight::getMyOrgID();
        $arrMyIBO = Generic::getAllMyIBO($kpo_id);
        $t = time();
        $arrBulan = Generic::getAllMonthsWithAll();
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $ibo_id = isset($_GET['ibo_id']) ? addslashes($_GET['ibo_id']) : key($arrMyIBO);
        $arrLevel = Generic::getAllLevel();
        ?>
        <section class="content-header">
            <h1>Laporan Jumlah Siswa Aktif, Cuti dan Keluar</h1>
            <div class="box-tools pull-right">
                <label for="exampleInputName2">Pilih IBO:</label>
                <select id="pilih_IBO_<?= $t; ?>">

                    <?
                    foreach ($arrMyIBO as $key => $val) {
                        ?>
                        <option value="<?= $key; ?>"><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>

                Bulan :<select id="bulan_<?= $t; ?>">
                    <?
                    foreach ($arrBulan as $bln2) {
                        $sel = "";
                        if ($bln2 == date("n")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                        <?
                    }
                    ?>
                </select>
                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>

                <button id="submit_status_<?= $t; ?>">submit</button>
                <? Generic::exportLogo(); ?>
                <script>
                    $('#submit_status_<?= $t; ?>').click(function () {
                        var bln = $('#bulan_<?= $t; ?>').val();
                        var thn = $('#tahun_<?= $t; ?>').val();
                        var ibo_id = $('#pilih_IBO_<?= $t; ?>').val();
                        //                        BIWebHelper/load_laporan_jumlah_siswa_by_status
                        $('#kepala_status_<?= $bln . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/load_laporan_jumlah_siswa_by_status?bln=" + bln + "&thn=" + thn + "&ibo_id=" + ibo_id, function () {

                        }, 'json');
                    });
                </script>
            </div>
        </section>
        <div class="clearfix"></div>
        <section class="content">
            <div id="kepala_status_<?= $bln . "_" . $thn; ?>" class="table-responsive">
                <table class="table table-bordered table-striped" style="background-color: white;">
                    <thead>
                    <tr>
                        <th rowspan="2" class="tengah">Level</th>
                        <?
                        if ($bln != "All") {
                            ?>
                            <th id="<?= $bln . "_" . $thn; ?>" class="total"
                                colspan="3"><?= Generic::getMonthName($bln); ?></th>

                            <?
                        }
                        ?>
                        <th colspan="1">Total</th>
                    </tr>
                    <tr>
                        <th>Aktif</th>
                        <th>Cuti</th>
                        <th>Keluar</th>
                        <th>Keluar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $aktiv = 0;
                    $cuti = 0;
                    $keluar = 0;
                    $aktivTotal = 0;
                    $cutiTotal = 0;
                    $keluarTotal = 0;
                    foreach ($arrLevel as $key => $level) {
                        $hlp = new StatusHisMuridModel();
                        $aktiv = $hlp->getJumlahMuridAktivByMonth($ibo_id, $key, $bln, $thn);
                        $aktivTotal += $aktiv;
                        $cuti = $hlp->getJumlahMuridCutiByMonth($ibo_id, $key, $bln, $thn);
                        $cutiTotal += $cuti;
                        $keluar = $hlp->getJumlahMuridKeluarByMonth($ibo_id, $key, $bln, $thn);
                        $keluarTotal += $keluar;
                        ?>
                        <tr>
                            <td><?= $level; ?></td>
                            <td><?= $aktiv; ?></td>
                            <td><?= $cuti; ?></td>
                            <td><?= $keluar; ?></td>
                            <td><?= $keluar; ?></td>
                        </tr>
                        <?
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="total tengah">Total</td>
                        <td><?= $aktivTotal; ?></td>
                        <td><?= $cutiTotal; ?></td>
                        <td><?= $keluarTotal; ?></td>
                        <td><?= $keluarTotal; ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <script>
            $('#export_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                var ibo_id = $('#pilih_IBO_<?= $t; ?>').val();
                window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?ibo_id=' + ibo_id + '&type=<?= KEY::$REPORT_REKAP_JUMLAH_SISWA_STATUS_KPO; ?>&bln=' + bln + "&thn=" + thn, "_blank ");
            });
        </script>
        <?
    }

    // Kupon

    function calcKuponBIByTC($bln, $thn, $tc_id)
    {


        //transaksi__kupon_request  // id_bundle
        //transaksi__kupon_bundle as ada id_bundle
        $transaksi_kupon = new RequestModel();
        $transaksi_bundle = new KuponBundle();
        $arr = $transaksi_bundle->getJumlahKuponByTC($tc_id);
        $arrKupon = $transaksi_kupon->getWhere("req_pengirim_org_id='$tc_id' AND req_status=1 AND YEAR(req_tgl_ubahstatus)=$thn AND MONTH(req_tgl_ubahstatus)=$bln");
        $total_kupon = 0;
        foreach ($arrKupon as $key => $kupon) {
//            $total_kupon += $kupon->
        }
        return $arrKupon;
    }

    // Mulai function buat IBO
    public function get_rekap_siswa_ibo()
    {
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $ibo_id = AccessRight::getMyOrgID();
        $t = time();
        $arrBulan = Generic::getAllMonths();
        $arrBulan[count($arrBulan) + 1] = KEY::$KEY_MONTH_ALL;
        $arrMyTC = Generic::getAllMyTC($ibo_id);

        $total_bl = 0;
        $total_baru = 0;
        $total_keluar = 0;
        $total_cuti = 0;
        $total_lulus = 0;
        $total_aktiv = 0;
        $total_kupon = 0;
        ?>

        <section class="content-header">
            <h1>Rekapitulasi Siswa per TC</h1>
            <div class="box-tools pull-right">
                Bulan :<select id="bulan_<?= $t; ?>">
                    <?
                    foreach ($arrBulan as $bln2) {
                        $sel = "";
                        if ($bln2 == date("n")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                        <?
                    }
                    ?>
                </select>
                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>

                <button id="submit_rekap_<?= $t; ?>">submit</button>
                <span id="export_<?= $t; ?>" class="glyphicon glyphicon-export" aria-hidden="true"></span>
                <!--                <span id="print_<?= $t; ?>" class="glyphicon glyphicon-print" aria-hidden="true"></span>-->

            </div>
        </section>
        <div class="clearfix"></div>
        <style type="text/css" media="print">
            @page {
                size: landscape;
            }
        </style>
        <script>
            $('#submit_rekap_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                $('#kepala_<?= $bln . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadRekapSiswaTableTC?bln=" + bln + "&thn=" + thn, function () {

                }, 'json');
            });

        </script>

        <style>
            .thead .table-sempoa-border {
                border: 4px;
                border-style: solid;
                border-color: burlywood;

            }

            .tengah {
                vertical-align: middle !important;
            }

            .tengahcolumn {
                vertical-align: middle !important;
                font-weight: bold;
            }

            .putih {
                background-color: white;
            }
        </style>

        <section class="content">

            <div id="kepala_<?= $bln . "_" . $thn; ?>" class="table-responsive">
                <table class="table table-bordered table-striped table-sempoa-border putih">
                    <thead>
                    <tr>
                        <th class="tengah" rowspan="2">No.</th>
                        <th class="tengah" rowspan="2">Kode TC</th>
                        <th class="tengah" rowspan="2">Nama TC</th>
                        <th class="tengah" rowspan="2">Nama Director</th>
                        <?
                        if ($bln != "All") {
                            ?>
                            <th id="<?= $bln . "_" . $thn; ?>" class="tengahcolumn"
                                colspan="7"><?= Generic::getMonthName($bln); ?></th>

                            <?
                        }
                        ?>

                    </tr>
                    <tr>
                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                    </tr>
                    </thead>
                    <tbody id="load_<?= $bln . "_" . $thn; ?>">
                    <?
                    $i = 1;
                    foreach ($arrMyTC as $id_tc => $tc) {
                        $orgTC = new SempoaOrg();
                        $orgTC->getByID($id_tc);
                        ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $orgTC->org_kode; ?></td>
                            <td><?= $orgTC->nama; ?></td>
                            <td><?= $orgTC->nama_pemilik; ?></td>
                            <?
                            $org_tc = new RekapSiswaIBOModel();
                            $arrDaten = $org_tc->getDaten($bln, $thn, $orgTC->nama);
                            $total_bl += $arrDaten[0]->bi_rekap_bl;
                            $total_baru += $arrDaten[0]->bi_rekap_baru;
                            $total_keluar += $arrDaten[0]->bi_rekap_keluar;
                            $total_cuti += $arrDaten[0]->bi_rekap_cuti;
                            $total_lulus += $arrDaten[0]->bi_rekap_lulus;
                            $total_aktiv += $arrDaten[0]->bi_rekap_aktiv;
                            $total_kupon += $arrDaten[0]->bi_rekap_kupon;
                            ?>
                            <td><?= $arrDaten[0]->bi_rekap_bl; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_baru; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_keluar; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_cuti; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_lulus; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_aktiv; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_kupon; ?></td>
                        </tr>
                        <?
                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:center; font-weight: bold">Total</td>

                        <td><?= $total_bl; ?></td>
                        <td><?= $total_baru; ?></td>
                        <td><?= $total_keluar; ?></td>
                        <td><?= $total_cuti; ?></td>
                        <td><?= $total_lulus; ?></td>
                        <td><?= $total_aktiv; ?></td>
                        <td><?= $total_kupon; ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <script>
            $('#export_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?ibo_id=<?= $ibo_id; ?>&type=<?= KEY::$REPORT_REKAP_SISWA_IBO; ?>&bln=' + bln + "&thn=" + thn, "_blank ");
            });
        </script>
        <?
    }

    public function get_rekap_siswa_ibo_tmp()
    {
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $ibo_id = AccessRight::getMyOrgID();
        $t = time();
        $arrBulan = Generic::getAllMonths();
        $arrBulan[count($arrBulan) + 1] = KEY::$KEY_MONTH_ALL;

        $arrMyTC = Generic::getAllMyTC($ibo_id);
        ?>

        <section class="content-header">
            <h1>Rekapitulasi Siswa per TC</h1>
            <div class="box-tools pull-right">
                Bulan :<select id="bulan_<?= $t; ?>">
                    <?
                    foreach ($arrBulan as $bln2) {
                        $sel = "";
                        if ($bln2 == date("n")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                        <?
                    }
                    ?>
                </select>
                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>

                <button id="submit_rekap_<?= $t; ?>">submit</button>
                <span id="export_<?= $t; ?>" class="glyphicon glyphicon-export" aria-hidden="true"></span>
                <!--                <span id="print_<?= $t; ?>" class="glyphicon glyphicon-print" aria-hidden="true"></span>-->

            </div>
        </section>
        <div class="clearfix"></div>
        <style type="text/css" media="print">
            @page {
                size: landscape;
            }
        </style>
        <script>
            $('#submit_rekap_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                $('#kepala_<?= $bln . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadRekapSiswaTableTC?bln=" + bln + "&thn=" + thn, function () {

                }, 'json');
            });
            //            $('#print_<?= $t; ?>').click(function () {
            //                window.print();
            //                return false;
            //            });
        </script>

        <style>
            .thead .table-sempoa-border {
                border: 4px;
                border-style: solid;
                border-color: burlywood;

            }

            .tengah {
                vertical-align: middle !important;
            }

            .tengahcolumn {
                vertical-align: middle !important;
                font-weight: bold;
            }

            .putih {
                background-color: white;
            }
        </style>

        <section class="content">

            <div id="kepala_<?= $bln . "_" . $thn; ?>" class="table-responsive">
                <table class="table table-bordered table-striped table-sempoa-border putih">
                    <thead>
                    <tr>
                        <th class="tengah" rowspan="2">No.</th>
                        <th class="tengah" rowspan="2">Kode TC</th>
                        <th class="tengah" rowspan="2">Nama TC</th>
                        <th class="tengah" rowspan="2">Nama Director</th>
                        <?
                        if ($bln != "All") {
                            ?>
                            <th id="<?= $bln . "_" . $thn; ?>" class="tengahcolumn"
                                colspan="7"><?= Generic::getMonthName($bln); ?></th>

                            <?
                        }
                        ?>

                    </tr>
                    <tr>
                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                    </tr>
                    </thead>
                    <tbody id="load_<?= $bln . "_" . $thn; ?>">
                    <?
                    $i = 1;
                    $total_bl = 0;
                    $total_baru = 0;
                    $total_keluar = 0;
                    $total_cuti = 0;
                    $total_lulus = 0;
                    $total_aktiv = 0;
                    $total_kupon = 0;
                    foreach ($arrMyTC as $id_tc => $tc) {
                        $orgTC = new SempoaOrg();
                        $orgTC->getByID($id_tc);
                        ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $orgTC->org_kode; ?></td>
                            <td><?= $orgTC->nama; ?></td>
                            <td><?= $orgTC->nama_pemilik; ?></td>
                            <?
                            $org_tc = new RekapSiswaIBOModel();
                            $arrDaten = $org_tc->getDaten($bln, $thn, $orgTC->nama);
                            $total_bl += $arrDaten[0]->bi_rekap_bl;
                            $total_baru += $arrDaten[0]->bi_rekap_baru;
                            $total_keluar += $arrDaten[0]->bi_rekap_keluar;
                            $total_cuti += $arrDaten[0]->bi_rekap_cuti;
                            $total_lulus += $arrDaten[0]->bi_rekap_lulus;
                            $total_aktiv += $arrDaten[0]->bi_rekap_aktiv;
                            $total_kupon += $arrDaten[0]->bi_rekap_kupon;
                            ?>
                            <td><?= $arrDaten[0]->bi_rekap_bl; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_baru; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_keluar; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_cuti; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_lulus; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_aktiv; ?></td>
                            <td><?= $arrDaten[0]->bi_rekap_kupon; ?></td>
                        </tr>
                        <?
                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:center; font-weight: bold">Total</td>

                        <td><?= $total_bl; ?></td>
                        <td><?= $total_baru; ?></td>
                        <td><?= $total_keluar; ?></td>
                        <td><?= $total_cuti; ?></td>
                        <td><?= $total_lulus; ?></td>
                        <td><?= $total_aktiv; ?></td>
                        <td><?= $total_kupon; ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <script>
            $('#export_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?ibo_id=<?= $ibo_id; ?>&type=<?= KEY::$REPORT_REKAP_SISWA_IBO; ?>&bln=' + bln + "&thn=" + thn, "_blank ");
            });
        </script>
        <?
    }

    public function get_rekap_kupon_tc()
    {
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $ibo_id = AccessRight::getMyOrgID();
        $t = time();
        $arrBulan = Generic::getAllMonths();
        $arrBulan[count($arrBulan) + 1] = "All";
        $arrMyTC = Generic::getAllMyTC($ibo_id);
        $title = "Rekapitulasi Kupon per TC";
        ?>

        <section class="content-header">
            <h1><?= $title; ?></h1>
            <div class="box-tools pull-right">
                Bulan :<select id="bulan_<?= $t; ?>">
                    <?
                    foreach ($arrBulan as $bln2) {
                        $sel = "";
                        if ($bln2 == date("n")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                        <?
                    }
                    ?>
                </select>
                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>

                <button id="submit_rekap_<?= $t; ?>">submit</button>
                <span id="export_<?= $t; ?>" class="glyphicon glyphicon-export" aria-hidden="true"></span>
            </div>
        </section>
        <div class="clearfix"></div>

        <script>
            $('#submit_rekap_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                $('#kupon_terjual_<?= $bln . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadRekapKuponTerjualTC?bln=" + bln + "&thn=" + thn, function () {

                }, 'json');
            });</script>
        <style>
            .tengahcolumn {
                vertical-align: middle !important;
                font-weight: bold;
            }
        </style>
        <section class="content">

            <div id="kupon_terjual_<?= $bln . "_" . $thn; ?>" class="table-responsive">
                <table class="table table-bordered table-sempoa-border table-striped" style="background-color: white;">
                    <thead>
                    <tr>
                        <td class="tengahcolumn" rowspan="2">No.</td>
                        <td class="tengahcolumn" rowspan="2">Nama TC</td>
                        <?
                        if ($bln != "All") {
                            ?>
                            <th id="<?= $bln . "_" . $thn; ?>" colspan="4"
                                style="text-align:center; font-weight: bold;"><?= Generic::getMonthName($bln); ?></th>

                            <?
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Kupon Terjual</th>
                        <th>Sisa Kupon</th>
                        <th>Kupon yang dibeli</th>
                        <th>A</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $i = 1;
                    $totalTerjual = 0;
                    $totalAktiv = 0;
                    $totalSisaKupon = 0;
                    $totalKuponYgDbeli =0;
                    $content = array();
                    //                        pr($arrMyTC);
                    foreach ($arrMyTC as $keyTC => $tc) {
                        $birekap = new RekapSiswaIBOModel();
                        $birekap->getWhereOne("bi_rekap_tc_id=$keyTC AND bi_rekap_bln=$bln AND bi_rekap_tahun=$thn");

                        $totalTerjual += $birekap->bi_rekap_kupon;
                        $totalAktiv += $birekap->bi_rekap_aktiv;
                        ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $tc; ?></td>
                            <td><?
                                if ($birekap->bi_rekap_kupon == "") {
                                    echo 0;
                                } else {
                                    echo $birekap->bi_rekap_kupon;
                                }
                                ?></td>
                            <td><?
                                $a = Generic::getSisaKuponTC($keyTC);
                                $totalSisaKupon +=$a;
                                echo $a;
                                ?></td>
                            <td><?
                                $b= Generic::getJumlahKuponYangDibeliByBulanTahun($keyTC, $bln, $thn);
                                $totalKuponYgDbeli +=$b;
                                echo $b;
                               ?></td>
                            <td><?
                                if ($birekap->bi_rekap_aktiv == "") {
                                    echo 0;
                                } else {
                                    echo $birekap->bi_rekap_aktiv;
                                }
                                ?></td>
                        </tr>
                        <?
                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2" style="text-align:center; font-weight: bold">Total</td>
                        <td><?= $totalTerjual ?></td>
                        <td><?= $totalSisaKupon ?></td>
                        <td><?= $totalKuponYgDbeli ?></td>
                        <td><?= $totalAktiv ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>

        <script>
            $('#export_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?type=<?= KEY::$REPORT_REKAP_KUPON_TC; ?>&bln=' + bln + "&thn=" + thn + "&ibo_id=<?= $ibo_id; ?>", "_blank ");
                //                window.open('<?= _SPPATH; ?>BIWebHelper/testExcel?bln=' +bln + "&thn="+thn +"&ibo_id=<?= $ibo_id; ?>", "_blank ");


            });
        </script>
        <?
    }

    public function get_absen_guru_tc()
    {

        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $ibo_id = AccessRight::getMyOrgID();
        $arrWeek = Generic::getDateRangeByWeek(date("Y"));
        krsort($arrWeek);
        $date = new DateTime('today');
        $todayweek = $date->format("W");
        $arrMyTC = Generic::getAllMyTC($ibo_id);
        $tc_id = key($arrMyTC);
        $t = time();
        ?>
        <section class="content-header">
            <h1><?= KEY::$JUDUL_REPORT_REKAP_ABSEN_GURU; ?></h1>
            <div class="box-tools pull-right">
                <label for="exampleInputName2">Pilih TC:</label>
                <select id="pilih_TC_<?= $t; ?>">

                    <?
                    foreach ($arrMyTC as $key => $val) {
                        ?>
                        <option value="<?= $key; ?>"><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>

                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>


                Minggu :<select id="minggu_<?= $t; ?>">
                    <?
                    foreach ($arrWeek as $key => $week) {
                        $sel = "";
                        if (($key) == ($todayweek)) {

                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $key; ?>" <?= $sel; ?>><?= $week; ?></option>
                        <?
                    }
                    ?>
                </select>
                <button id="submit_absen_couch_<?= $t; ?>">submit</button>
                <span id="export_<?= $t; ?>" class="glyphicon glyphicon-export" aria-hidden="true"></span>
                <script>

                    $('#tahun_<?= $t; ?>').change(function () {
                        var thn = $('#tahun_<?= $t; ?>').val();
                        getWeekInYear(thn);

                    });
                    $('#submit_absen_couch_<?= $t; ?>').click(function () {
                        var thn = $('#tahun_<?= $t; ?>').val();
                        var week = $('#minggu_<?= $t; ?>').val();
                        var tc_id = $('#pilih_TC_<?= $t; ?>').val();
                        $('#content_absen_coach_<?= $t . "_" . $todayweek . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadabsencoach?week=" + week + "&thn=" + thn + "&tc_id=" + tc_id, function () {

                        }, 'json');
                    })

                    $('#export_<?= $t; ?>').click(function () {
                        var thn = $('#tahun_<?= $t; ?>').val();
                        var week = $('#minggu_<?= $t; ?>').val();
                        var tglWeek = $("#minggu_<?= $t; ?> option:selected").text();
                        var tc_id = $('#pilih_TC_<?= $t; ?>').val();
                        window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?type=<?= KEY::$REPORT_REKAP_ABSEN_GURU; ?>&tc_id=' + tc_id + '&week=' + week + " &thn=" + thn + "&tglWeek= " + tglWeek, "_blank ");

                    });

                    function getWeekInYear(slc) {
                        $.ajax({
                            type: "POST",
                            url: "<?= _SPPATH; ?>LaporanWebHelper/getWeekInYear",
                            data: 'thn=' + slc,
                            success: function (data) {
//                                console.log(data);
                                $("#minggu_<?= $t; ?>").html(data);
                            }
                        });
                    }

                </script>
            </div>
        </section>
        <div class="clearfix"></div>
        <section class="content">

            <div class="table-responsive">
                <table class="table table-bordered table-striped" style="background-color: white;">
                    <thead>
                    <tr>
                        <th colspan="15" style="text-align:center; font-weight: bold">Absen Coach</th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="tengah">No.</th>
                        <th rowspan="2" class="tengah">Nama Guru</th>
                        <th colspan="12" style="text-align:center; font-weight: bold">Jadwal Mengajar</th>
                    </tr>
                    <tr>
                        <th>Senin</th>
                        <th>Level</th>
                        <th>Selasa</th>
                        <th>Level</th>
                        <th>Rabu</th>
                        <th>Level</th>
                        <th>Kamis</th>
                        <th>Level</th>
                        <th>Jumat</th>
                        <th>Level</th>
                        <th>Sabtu</th>
                        <th>Level</th>
                    </tr>
                    </thead>
                    <tbody id="content_absen_coach_<?= $t . "_" . $todayweek . "_" . $thn; ?>">
                    <?
                    $i = 1;
                    $senin = 0;
                    $selasa = 0;
                    $rabu = 0;
                    $kamis = 0;
                    $jumat = 0;
                    $sabtu = 0;
                    $birekap = new RekapAbsenCoach();
                    $arrRekap = $birekap->getWhere("ac_tc_id=$tc_id AND ac_week=$todayweek AND ac_tahun=$thn");
                    //                            pr($arrRekap);
                    foreach ($arrRekap as $val) {
                        ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $val->ac_nama_guru_dtg; ?></td>
                            <td>
                                <?
                                $senin += $val->ac_1;
                                echo $val->ac_1;
                                ?>
                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_1);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                            <td>

                                <?
                                $selasa += $val->ac_2;
                                echo $val->ac_2;
                                ?>

                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_2);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                            <td>
                                <?
                                $rabu += $val->ac_3;
                                echo $val->ac_3;
                                ?>
                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_3);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                            <td>
                                <?
                                $kamis += $val->ac_4;
                                echo $val->ac_4;
                                ?>
                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_4);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                            <td>
                                <?
                                $jumat += $val->ac_5;
                                echo $val->ac_5;
                                ?>
                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_5);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                            <td>
                                <?
                                $sabtu += $val->ac_6;
                                echo $val->ac_6;
                                ?>
                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_6);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                        </tr>
                        <?
                        $i++;
                    }
                    ?>
                    <tr>
                        <td colspan="2">Total</td>
                        <td><?= $senin; ?></td>
                        <td></td>
                        <td><?= $selasa; ?></td>
                        <td></td>
                        <td><?= $rabu; ?></td>
                        <td></td>
                        <td><?= $kamis; ?></td>
                        <td></td>
                        <td><?= $jumat; ?></td>
                        <td></td>
                        <td><?= $sabtu; ?></td>
                        <td></td>
                    </tr>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </section>
        <?
    }

    public function get_laporan_belajar_murid_tc()
    {
        $arrMyTC = Generic::getAllMyTC(AccessRight::getMyOrgID());
        $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : Key($arrMyTC);
        $t = time();
        ?>
        <section class="content-header">
            <div class="box-tools pull-right">

                <label for="exampleInputName2">Pilih TC:</label>
                <select id="pilih_TC_<?= $t; ?>">

                    <?
                    foreach ($arrMyTC as $key => $val) {
                        ?>
                        <option value="<?= $key; ?>"><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>
                <button id="submit_<?= $t; ?>">submit</button>
                <?= Generic::exportLogo(); ?>
                <script>
                    $('#submit_<?= $t; ?>').click(function () {
                        var tc_id = $('#pilih_TC_<?= $t; ?>').val();
                        $('#container_coach_bulanan<?= $t; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadLaporanBelajarMurid?tc_id=" + tc_id, function () {

                        }, 'json');
                    });
                    $('#export_<?= $t; ?>').click(function () {
                        var tc_id = $('#pilih_TC_<?= $t; ?>').val();

                        window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?type=<?= KEY::$REPORT_REKAP_LAMA_BELAJAR_MURID_TC; ?>&org_id=<?= $tc_id; ?>&tc_id=' + tc_id, "_blank ");
                        //                window.open('<?= _SPPATH; ?>BIWebHelper/testExcel?bln=' +bln + "&thn="+thn +"&ibo_id=<?= $tc_id; ?>", "_blank ");


                    });

                    //
                </script>

            </div>
        </section>
        <div class="clearfix"></div>
        <style>
            .guru_coach {
                background-color: #f6f6f6;
                font-weight: bold;
            }
        </style>
        <h1>Laporan Lama Belajar Murid satuan Bulanan</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped " style="background-color: white">
                <thead>
                <tr>
                    <th colspan="6" style="text-align:center;">Laporan Absen Coach Bulanan</th>
                </tr>
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Level Siswa</th>
                    <th>Lama Belajar</th>
                </tr>
                </thead>
                <tbody id='container_coach_bulanan<?= $t; ?>'>
                <?
                $i = 1;
                $sudah = array();
                $muridMatrix = new MuridKelasMatrix();
                $arrGuru = $muridMatrix->getWhere("tc_id=$tc_id AND active_status = 1 ORDER BY level_murid ASC");
                $firstime = true;
                $now = new DateTime();
                $kelasByGuru = array();
                foreach ($arrGuru as $mm) {
                    $kelasByGuru[$mm->guru_id][] = $mm;
                }

                $num = 1;
                foreach ($kelasByGuru as $guru_id => $arrmm) {
//                        pr($arrmm);
                    $guru = new SempoaGuruModel();
                    $guru->getByID($guru_id);
                    ?>
                    <tr class="guru_coach">
                        <td colspan="4">
                            <?= $guru->nama_guru; ?>
                        </td>
                    </tr>

                    <?
                    foreach ($arrmm as $mm) {
                        $datetime2 = new DateTime($mm->active_date);
                        $datetime1 = new DateTime(date('Y-m-d H:i:s'));
                        $interval = $datetime2->diff($datetime1);

                        if (in_array($mm->murid_id . $guru_id, $sudah)) {
                            $datetime2 = new DateTime($mm->active_date);
                            $datetime1 = new DateTime(date('Y-m-d H:i:s'));
                            $interval = $datetime2->diff($datetime1);
                            continue;
                        }
                        $sudah[] = $mm->murid_id . $guru_id;
                        $murid = new MuridModel();
                        $murid->getByID($mm->murid_id);
//                                    Generic::getMuridNamebyID($mm->murid_id);
                        ?>
                        <tr>
                            <td>
                                <?=
                                $num;
                                $num++;
                                ?>
                            </td>
                            <td>
                                <?= Generic::getMuridNamebyID($mm->murid_id); ?>
                            </td>
                            <td>
                                <?= Generic::getLevelNameByID($murid->id_level_sekarang); ?>
                            </td>
                            <td>
                                <?= floor($interval->format('%R%a ') / 30); ?> bulan
                            </td>
                        </tr>

                    <? } ?>

                    <?
                }
                ?>

                </tbody>
            </table>
        </div>


        <?
    }

    public function get_laporan_jumlah_siswa_buku_kupon()
    {
        $kpo_id = AccessRight::getMyOrgID();
        $arrMyIBO = Generic::getAllMyIBO($kpo_id);
        $ibo_id = isset($_GET['ibo_id']) ? addslashes($_GET['ibo_id']) : key($arrMyIBO);
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $thn_skrg = date("Y");
        $bln_skrg = date("n");
        $t = time();
        $title = KEY::$JUDUL_REPORT_REKAP_PENJUALAN_B_K_S;
        $arrTahun = array();
        $arrTahun[] = $thn - 3;
        $arrTahun[] = $thn - 2;
        $arrTahun[] = $thn - 1;
        $arrTahun[] = $thn;

        $arrKey[1] = "Siswa";
        $arrKey[2] = "Buku";
        $arrKey[3] = "Kupon";
        ?>
        <section class="content-header">
            <h1><?= $title; ?></h1>
            <div class="box-tools pull-right">
                <label for="exampleInputName2">Pilih IBO:</label>
                <select id="pilih_IBO_<?= $t; ?>">

                    <?
                    foreach ($arrMyIBO as $key => $val) {
                        ?>
                        <option value="<?= $key; ?>"><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>

                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>

                <button id="submit_jumlah_buku_<?= $t; ?>">submit</button>
                <? Generic::exportLogo(); ?>
                <script>
                    $('#submit_jumlah_buku_<?= $t; ?>').click(function () {
                        var thn = $('#tahun_<?= $t; ?>').val();
                        var ibo_id = $('#pilih_IBO_<?= $t; ?>').val();
                        //                        BIWebHelper/load_laporan_jumlah_siswa_by_status
                        $('#kepala_jumlah_buku_<?= $t . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/laporan_jumlah_siswa_buku_kupon?&thn=" + thn + "&ibo_id=" + ibo_id, function () {

                        }, 'json');
                    });

                    $('#export_<?= $t; ?>').click(function () {
                        var thn = $('#tahun_<?= $t; ?>').val();

                        window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?type=<?= KEY::$REPORT_REKAP_PENJUALAN_B_K_S; ?>&thn=' + thn, "_blank ");

                    });
                </script>
            </div>
        </section>
        <div class="clearfix">
        </div>
        <section class="content">
            <div class="table-responsive" id="kepala_jumlah_buku_<?= $t . "_" . $thn; ?>">
                <table class="table table-bordered table-striped" style="background-color: white;">
                    <thead>
                    <tr>
                        <th></th>
                        <?
                        foreach ($arrTahun as $valthn) {
                            ?>
                            <th><?= $valthn; ?></th>
                            <?
                        }
                        ?>


                    </tr>
                    </thead>
                    <tbody>
                    <?
                    foreach ($arrKey as $val) {
                        ?>
                        <tr>
                            <td><?= $val; ?></td>
                            <?
                            foreach ($arrTahun as $valthn) {
                                $rekap_siswa = new RekapSiswaIBOModel();
                                if ($valthn == $thn_skrg) {
                                    $arrRekapSiswa = $rekap_siswa->getWhere(" bi_rekap_ibo_id='$ibo_id' AND bi_rekap_tahun = $valthn AND bi_rekap_bln=$bln_skrg");
                                } else {
                                    $arrRekapSiswa = $rekap_siswa->getWhere(" bi_rekap_ibo_id='$ibo_id' AND bi_rekap_tahun = $valthn AND bi_rekap_bln =12");
                                }
                                $total[$val][$valthn] = 0;

                                foreach ($arrRekapSiswa as $valRekap) {
                                    if ($val == "Siswa") {
                                        $total[$val][$valthn] += $valRekap->bi_rekap_aktiv;
                                    }
                                    if ($val == "Buku") {
                                        $total[$val][$valthn] += $valRekap->bi_rekap_buku;
                                    }
                                    if ($val == "Kupon") {
                                        $total[$val][$valthn] += $valRekap->bi_rekap_kupon;
                                    }
                                }
                            }

                            foreach ($arrTahun as $valthn) {
                                ?>
                                <td><?= $total[$val][$valthn]; ?></td>
                                <?
                            }
                            ?>


                        </tr>
                        <?
                    }
                    ?>
                    <tr></tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </section>
        <?
    }

    public function get_laporan_perkembangan_ibo()
    {
        $ibo_id = AccessRight::getMyOrgID();
        $arrMyIBO = Generic::getAllMyIBO($ibo_id);

        $bln = date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $thn_skrg = date("Y");
        $bln_skrg = date("n");
        $t = time();
        $title = KEY::$JUDUL_REKAP_PERKEMBANGAN_IBO;
        $arrTahun = array();
        $arrTahun[] = $thn - 3;
        $arrTahun[] = $thn - 2;
        $arrTahun[] = $thn - 1;
        $arrTahun[] = $thn;
        ?>
        <section class="content-header">
            <h1><?= $title; ?></h1>
            <div class="box-tools pull-right">

                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>

                <button id="submit_perkembangan_<?= $t; ?>">submit</button>
                <? Generic::exportLogo(); ?>
                <script>
                    $('#submit_perkembangan_<?= $t; ?>').click(function () {
                        var bln = $('#bulan_<?= $t; ?>').val();
                        var thn = $('#tahun_<?= $t; ?>').val();
                        var ibo_id = $('#pilih_IBO_<?= $t; ?>').val();
                        $('#kepala_perkembangan_<?= $bln . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/load_laporan_perkembangan_ibo?thn=" + thn, function () {

                        }, 'json');
                    });

                    $('#export_<?= $t; ?>').click(function () {
                        var thn = $('#tahun_<?= $t; ?>').val();
                        window.open("<?= _SPPATH; ?>BIWebHelper/exportSempoa?type=<?= KEY::$REPORT_REKAP_PERKEMBANGAN_IBO; ?>&thn=" + thn, "_blank ");

                    });
                </script>
            </div>
        </section>
        <div class="clearfix">
        </div>
        <section class="content">
            <div id='kepala_perkembangan_<?= $bln . "_" . $thn; ?>'>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="background-color: white;">

                        <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2">Wilayah</th>
                            <? foreach ($arrTahun as $valThn) {
                                ?>
                                <th colspan="3"><?= $valThn ?></th>
                                <?
                            }
                            ?>
                        </tr>
                        <tr>

                            <? foreach ($arrTahun as $valThn) {
                                ?>
                                <th>TC</th>
                                <th>Coach</th>
                                <th>Siswa</th>
                                <?
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $i = 1;
                        foreach ($arrMyIBO as $keyIBO => $iboname) {
                            ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $iboname; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?
                            $arrmytc = Generic::getAllMyTC($keyIBO);
                            foreach ($arrmytc as $keytc => $tcname) {
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>

                                    <?
                                    foreach ($arrTahun as $keythn => $valthn) {
                                        $rekap_siswa = new RekapSiswaIBOModel();
                                        if ($valthn == $thn_skrg) {
                                            $arrRekapSiswa = $rekap_siswa->getWhere(" bi_rekap_tc_id=$keytc AND bi_rekap_tahun = $valthn AND bi_rekap_bln=$bln_skrg");
                                        } else {
                                            $arrRekapSiswa = $rekap_siswa->getWhere(" bi_rekap_tc_id=$keytc AND bi_rekap_tahun = $valthn AND bi_rekap_bln =12");
                                        }
                                        $arrCoach[$keytc][$valthn] = 0;
                                        $arrSiswa[$keytc][$valthn] = 0;
                                        foreach ($arrRekapSiswa as $rekap) {

                                            $arrCoach[$keytc][$valthn] += $rekap->bi_rekap_jumlah_guru;
                                            $arrSiswa[$keytc][$valthn] += $rekap->bi_rekap_aktiv;
                                        }
                                        ?>
                                        <td><?= $tcname; ?></td>
                                        <td><?= $arrCoach[$keytc][$valthn]; ?></td>
                                        <td><?= $arrSiswa[$keytc][$valthn]; ?></td>
                                        <?
                                    }
                                    //                                pr($arrCoach);
                                    //                                pr($arrSiswa);
                                    ?>


                                </tr>
                                <?
                            }
                            ?>
                            <? ?>

                            <?
                            $i++;
                        }
                        ?>
                        </tbody>
                        <tfoot></tfoot>

                    </table>
                </div>
            </div>
        </section>
        <?
    }

    // BI Level TC
    public function get_laporan_belajar_murid_tc_lvl_tc()
    {

        $tc_id = AccessRight::getMyOrgID();
        $t = time();
        $title = KEY::$JUDUL_REKAP_LAMA_BELAJAR_MURID_TC;
        ?>
        <section class="content-header">

            <div class="box-tools pull-right">
                <?= Generic::exportLogo(); ?>
                <script>
                    $('#submit_<?= $t; ?>').click(function () {
                        var tc_id = $('#pilih_TC_<?= $t; ?>').val();
                        $('#container_coach_bulanan<?= $t; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadLaporanBelajarMurid?tc_id=" + tc_id, function () {

                        }, 'json');
                    });
                    $('#export_<?= $t; ?>').click(function () {
                        window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?type=<?= KEY::$REPORT_REKAP_LAMA_BELAJAR_MURID_TC; ?>&tc_id=<?= $tc_id; ?>', "_blank ");

                    });

                    //
                </script>

            </div>
        </section>
        <div class="clearfix"></div>
        <style>
            .guru_coach {
                background-color: #f6f6f6;
                font-weight: bold;
            }
        </style>
        <h1><?= $title; ?></h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped " style="background-color: white">
                <thead>
                <tr>
                    <th colspan="6" style="text-align:center;">Laporan Absen Coach Bulanan</th>
                </tr>
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Level Siswa</th>
                    <th>Lama Belajar</th>
                </tr>
                </thead>
                <tbody id='container_coach_bulanan<?= $t; ?>'>
                <?
                $i = 1;
                $sudah = array();
                $muridMatrix = new MuridKelasMatrix();
                $arrGuru = $muridMatrix->getWhere("tc_id=$tc_id AND active_status = 1");
                $firstime = true;
                $now = new DateTime();
                $kelasByGuru = array();
                foreach ($arrGuru as $mm) {
                    $kelasByGuru[$mm->guru_id][] = $mm;
                }

                $num = 1;
                foreach ($kelasByGuru as $guru_id => $arrmm) {
//                        pr($arrmm);
                    $guru = new SempoaGuruModel();
                    $guru->getByID($guru_id);
                    ?>
                    <tr class="guru_coach">
                        <td colspan="4">
                            <?= $guru->nama_guru; ?>
                        </td>
                    </tr>

                    <?
                    foreach ($arrmm as $mm) {
                        $datetime2 = new DateTime($mm->active_date);
                        $datetime1 = new DateTime(date('Y-m-d H:i:s'));
                        $interval = $datetime2->diff($datetime1);

                        if (in_array($mm->murid_id . $guru_id, $sudah)) {
                            $datetime2 = new DateTime($mm->active_date);
                            $datetime1 = new DateTime(date('Y-m-d H:i:s'));
                            $interval = $datetime2->diff($datetime1);
                            continue;
                        }
                        $sudah[] = $mm->murid_id . $guru_id;
                        $murid = new MuridModel();
                        $murid->getByID($mm->murid_id);
//                                    Generic::getMuridNamebyID($mm->murid_id);
                        ?>
                        <tr>
                            <td>
                                <?=
                                $num;
                                $num++;
                                ?>
                            </td>
                            <td>
                                <?= Generic::getMuridNamebyID($mm->murid_id); ?>
                            </td>
                            <td>
                                <?= Generic::getLevelNameByID($murid->id_level_sekarang); ?>
                            </td>
                            <td>
                                <?= floor($interval->format('%R%a ') / 30); ?> bulan
                            </td>
                        </tr>

                    <? } ?>

                    <?
                }
                ?>

                </tbody>
            </table>
        </div>


        <?
    }

    public function get_absen_guru_tc_lvl_tc()
    {
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $arrWeek = Generic::getDateRangeByWeek(date("Y"));
        krsort($arrWeek);
        $date = new DateTime('today');
        $todayweek = $date->format("W");
        $tc_id = AccessRight::getMyOrgID();
        $t = time();
        ?>
        <section class="content-header">
            <h1><?= KEY::$JUDUL_REPORT_REKAP_ABSEN_GURU; ?></h1>
            <div class="box-tools pull-right">

                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>
                Minggu :<select id="minggu_<?= $t; ?>">
                    <?
                    foreach ($arrWeek as $key => $week) {
                        $sel = "";
                        if (($key) == ($todayweek)) {

                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $key; ?>" <?= $sel; ?>><?= $week; ?></option>
                        <?
                    }
                    ?>
                </select>
                <button id="submit_absen_couch_<?= $t; ?>">submit</button>
                <span id="export_<?= $t; ?>" class="glyphicon glyphicon-export" aria-hidden="true"></span>
                <script>
                    $('#tahun_<?= $t; ?>').change(function () {
                        var thn = $('#tahun_<?= $t; ?>').val();
                        getWeekInYear(thn);

                    });
                    function getWeekInYear(slc) {
                        $.ajax({
                            type: "POST",
                            url: "<?= _SPPATH; ?>LaporanWebHelper/getWeekInYear",
                            data: 'thn=' + slc,
                            success: function (data) {
//                                console.log(data);
                                $("#minggu_<?= $t; ?>").html(data);
                            }
                        });
                    }
                    $('#submit_absen_couch_<?= $t; ?>').click(function () {
                        var thn = $('#tahun_<?= $t; ?>').val();
                        var week = $('#minggu_<?= $t; ?>').val();
                        var tc_id = '<?=AccessRight::getMyOrgID();?>';
                        $('#content_absen_coach_<?= $t . "_" . $todayweek . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadabsencoach?week=" + week + "&thn=" + thn + "&tc_id=" + tc_id, function () {

                        }, 'json');
                    })

                    $('#export_<?= $t; ?>').click(function () {
                        var thn = $('#tahun_<?= $t; ?>').val();
                        var week = $('#minggu_<?= $t; ?>').val();
                        var tglWeek = $("#minggu_<?= $t; ?> option:selected").text();
                        var tc_id = '<?=AccessRight::getMyOrgID();?>';

                        window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?type=<?= KEY::$REPORT_REKAP_ABSEN_GURU; ?>&tc_id=' + tc_id + '&week=' + week + " &thn=" + thn + "&tglWeek= " + tglWeek, "_blank ");

                    });
                </script>
            </div>
        </section>
        <div class="clearfix"></div>
        <section class="content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" style="background-color: white;">
                    <thead>
                    <tr>
                        <th colspan="15" style="text-align:center; font-weight: bold">Absen Coach</th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="tengah">No.</th>
                        <th rowspan="2" class="tengah">Nama Guru</th>
                        <th colspan="12" style="text-align:center; font-weight: bold">Jadwal Mengajar</th>
                    </tr>
                    <tr>
                        <th>Senin</th>
                        <th>Level</th>
                        <th>Selasa</th>
                        <th>Level</th>
                        <th>Rabu</th>
                        <th>Level</th>
                        <th>Kamis</th>
                        <th>Level</th>
                        <th>Jumat</th>
                        <th>Level</th>
                        <th>Sabtu</th>
                        <th>Level</th>
                    </tr>
                    </thead>
                    <tbody id="content_absen_coach_<?= $t . "_" . $todayweek . "_" . $thn; ?>">
                    <?
                    $i = 1;
                    $senin = 0;
                    $selasa = 0;
                    $rabu = 0;
                    $kamis = 0;
                    $jumat = 0;
                    $sabtu = 0;
                    $birekap = new RekapAbsenCoach();
                    $arrRekap = $birekap->getWhere("ac_tc_id=$tc_id AND ac_week=$todayweek AND ac_tahun=$thn");
                    //                            pr($arrRekap);
                    foreach ($arrRekap as $val) {
                        ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $val->ac_nama_guru_dtg; ?></td>
                            <td>
                                <?
                                $senin += $val->ac_1;
                                echo $val->ac_1;
                                ?>
                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_1);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                            <td>

                                <?
                                $selasa += $val->ac_2;
                                echo $val->ac_2;
                                ?>

                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_2);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                            <td>
                                <?
                                $rabu += $val->ac_3;
                                echo $val->ac_3;
                                ?>
                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_3);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                            <td>
                                <?
                                $kamis += $val->ac_4;
                                echo $val->ac_4;
                                ?>
                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_4);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                            <td>
                                <?
                                $jumat += $val->ac_5;
                                echo $val->ac_5;
                                ?>
                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_5);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                            <td>
                                <?
                                $sabtu += $val->ac_6;
                                echo $val->ac_6;
                                ?>
                            </td>
                            <td><?
                                $arrLevel = explode(",", $val->ac_level_6);
                                echo Generic::getLevelAbsenCoach($arrLevel);
                                ?></td>
                        </tr>
                        <?
                        $i++;
                    }
                    ?>
                    <tr>
                        <td colspan="2">Total</td>
                        <td><?= $senin; ?></td>
                        <td></td>
                        <td><?= $selasa; ?></td>
                        <td></td>
                        <td><?= $rabu; ?></td>
                        <td></td>
                        <td><?= $kamis; ?></td>
                        <td></td>
                        <td><?= $jumat; ?></td>
                        <td></td>
                        <td><?= $sabtu; ?></td>
                        <td></td>
                    </tr>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </section>
        <?
    }

    public function get_rekap_kupon_tc_lvl_tc()
    {
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $tc_id = AccessRight::getMyOrgID();
        $t = time();
        $arrBulan = Generic::getAllMonthsWithAll();
        $title = "Rekapitulasi Kupon per TC";
        ?>

        <section class="content-header">
            <h1><?= $title; ?></h1>
            <div class="box-tools pull-right">
                Bulan :<select id="bulan_<?= $t; ?>">
                    <?
                    foreach ($arrBulan as $bln2) {
                        $sel = "";
                        if ($bln2 == date("n")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                        <?
                    }
                    ?>
                </select>
                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>

                <button id="submit_rekap_<?= $t; ?>">submit</button>
                <span id="export_<?= $t; ?>" class="glyphicon glyphicon-export" aria-hidden="true"></span>
            </div>
        </section>
        <div class="clearfix"></div>

        <script>
            $('#submit_rekap_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                $('#kupon_terjual_<?= $bln . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadRekapKuponTerjualOneTC?bln=" + bln + "&thn=" + thn, function () {

                }, 'json');
            });</script>
        <style>
            .tengahcolumn {
                vertical-align: middle !important;
                font-weight: bold;
            }
        </style>
        <section class="content">

            <div id="kupon_terjual_<?= $bln . "_" . $thn; ?>" class="table-responsive">
                <table class="table table-bordered table-sempoa-border table-striped" style="background-color: white;">
                    <thead>
                    <tr>
                        <td class="tengahcolumn" rowspan="2">No.</td>
                        <td class="tengahcolumn" rowspan="2">Nama TC</td>
                        <?
                        if ($bln != "All") {
                            ?>
                            <th id="<?= $bln . "_" . $thn; ?>" colspan="2"
                                style="text-align:center; font-weight: bold;"><?= Generic::getMonthName($bln); ?></th>

                            <?
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Kupon Terjual</th>
                        <th>A</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $i = 1;
                    $totalTerjual = 0;
                    $totalAktiv = 0;
                    $content = array();
                    //                        pr($arrMyTC);
                    //                        foreach ($arrMyTC as $keyTC => $tc) {
                    $birekap = new RekapSiswaIBOModel();
                    $birekap->getWhereOne("bi_rekap_tc_id=$tc_id AND bi_rekap_bln=$bln AND bi_rekap_tahun=$thn");

                    $totalTerjual += $birekap->bi_rekap_kupon;
                    $totalAktiv += $birekap->bi_rekap_aktiv;
                    ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= Generic::getTCNamebyID(AccessRight::getMyOrgID()); ?></td>
                        <td><?
                            if ($birekap->bi_rekap_kupon == "") {
                                echo 0;
                            } else {
                                echo $birekap->bi_rekap_kupon;
                            }
                            ?></td>

                        <td><?
                            if ($birekap->bi_rekap_aktiv == "") {
                                echo 0;
                            } else {
                                echo $birekap->bi_rekap_aktiv;
                            }
                            ?></td>
                    </tr>
                    <?
                    $i++;
                    //                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2" style="text-align:center; font-weight: bold">Total</td>
                        <td><?= $totalTerjual ?></td>
                        <td><?= $totalAktiv ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>

        <script>
            $('#export_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?type=<?= KEY::$REPORT_REKAP_KUPON_TC_LVL; ?>&bln=' + bln + "&thn=" + thn + "&tc_id=<?= $tc_id; ?>", "_blank ");


            });
        </script>
        <?
    }

    public function get_rekap_siswa_ibo_lvl_tc()
    {
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $tc_id = AccessRight::getMyOrgID();
        $t = time();
        $arrBulan = Generic::getAllMonthsWithAll();

        ?>

        <section class="content-header">
            <h1>Rekapitulasi Siswa per TC</h1>
            <div class="box-tools pull-right">
                Bulan :<select id="bulan_<?= $t; ?>">
                    <?
                    foreach ($arrBulan as $bln2) {
                        $sel = "";
                        if ($bln2 == date("n")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                        <?
                    }
                    ?>
                </select>
                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>

                <button id="submit_rekap_<?= $t; ?>">submit</button>
                <span id="export_<?= $t; ?>" class="glyphicon glyphicon-export" aria-hidden="true"></span>
                <!--                <span id="print_<?= $t; ?>" class="glyphicon glyphicon-print" aria-hidden="true"></span>-->

            </div>
        </section>
        <div class="clearfix"></div>
        <style type="text/css" media="print">
            @page {
                size: landscape;
            }
        </style>
        <script>
            $('#submit_rekap_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                $('#kepala_<?= $bln . "_" . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadRekapSiswaTableOneTC?bln=" + bln + "&thn=" + thn, function () {

                }, 'json');
            });

        </script>

        <style>
            .thead .table-sempoa-border {
                border: 4px;
                border-style: solid;
                border-color: burlywood;

            }

            .tengah {
                vertical-align: middle !important;
            }

            .tengahcolumn {
                vertical-align: middle !important;
                font-weight: bold;
            }

            .putih {
                background-color: white;
            }
        </style>

        <section class="content">

            <div id="kepala_<?= $bln . "_" . $thn; ?>" class="table-responsive">
                <table class="table table-bordered table-striped table-sempoa-border putih">
                    <thead>
                    <tr>
                        <th class="tengah" rowspan="2">No.</th>
                        <th class="tengah" rowspan="2">Kode TC</th>
                        <th class="tengah" rowspan="2">Nama TC</th>
                        <th class="tengah" rowspan="2">Nama Director</th>
                        <?
                        if ($bln != "All") {
                            ?>
                            <th id="<?= $bln . "_" . $thn; ?>" class="tengahcolumn"
                                colspan="7"><?= Generic::getMonthName($bln); ?></th>

                            <?
                        }
                        ?>

                    </tr>
                    <tr>
                        <th>BL</th>
                        <th>B</th>
                        <th>K</th>
                        <th>C</th>
                        <th>L</th>
                        <th>A</th>
                        <th>KPN</th>

                    </tr>
                    </thead>
                    <tbody id="load_<?= $bln . "_" . $thn; ?>">
                    <?
                    $i = 1;
                    //                        foreach ($arrMyTC as $id_tc => $tc) {
                    $orgTC = new SempoaOrg();
                    $orgTC->getByID($tc_id);
                    ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $orgTC->org_kode; ?></td>
                        <td><?= Generic::getTCNamebyID(AccessRight::getMyOrgID()); ?></td>
                        <td><?= $orgTC->nama_pemilik; ?></td>
                        <?
                        $org_tc = new RekapSiswaIBOModel();
                        $arrDaten = $org_tc->getDaten($bln, $thn, $orgTC->nama);
                        $total_bl += $arrDaten[0]->bi_rekap_bl;
                        $total_baru += $arrDaten[0]->bi_rekap_baru;
                        $total_keluar += $arrDaten[0]->bi_rekap_keluar;
                        $total_cuti += $arrDaten[0]->bi_rekap_cuti;
                        $total_lulus += $arrDaten[0]->bi_rekap_lulus;
                        $total_aktiv += $arrDaten[0]->bi_rekap_aktiv;
                        $total_kupon += $arrDaten[0]->bi_rekap_kupon;
                        ?>
                        <td><?= $arrDaten[0]->bi_rekap_bl; ?></td>
                        <td><?= $arrDaten[0]->bi_rekap_baru; ?></td>
                        <td><?= $arrDaten[0]->bi_rekap_keluar; ?></td>
                        <td><?= $arrDaten[0]->bi_rekap_cuti; ?></td>
                        <td><?= $arrDaten[0]->bi_rekap_lulus; ?></td>
                        <td><?= $arrDaten[0]->bi_rekap_aktiv; ?></td>
                        <td><?= $arrDaten[0]->bi_rekap_kupon; ?></td>
                    </tr>
                    <?
                    $i++;
                    //                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:center; font-weight: bold">Total</td>

                        <td><?= $total_bl; ?></td>
                        <td><?= $total_baru; ?></td>
                        <td><?= $total_keluar; ?></td>
                        <td><?= $total_cuti; ?></td>
                        <td><?= $total_lulus; ?></td>
                        <td><?= $total_aktiv; ?></td>
                        <td><?= $total_kupon; ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <script>
            $('#export_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?tc_id=<?= $tc_id; ?>&type=<?= KEY::$REPORT_REKAP_SISWA_IBO_TC_LVL; ?>&bln=' + bln + "&thn=" + thn, "_blank ");
            });
        </script>
        <?
    }

    public function get_rekap_bulanan_kupon_lvl_tc()
    {
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $t = time();
        $arrBulan = Generic::getAllMonthsWithAll();
        $tc_id = AccessRight::getMyOrgID();
        ?>
        <section class="content-header">
            <h1>Rekapitulasi Kupon</h1>
            <div class="box-tools pull-right">
                Bulan :<select id="bulan_<?= $t; ?>">
                    <?
                    foreach ($arrBulan as $bln2) {
                        $sel = "";
                        if ($bln2 == date("n")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                        <?
                    }
                    ?>
                </select>
                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>
                <button id="submit_rekap_kupon_siswa_<?= $t; ?>">submit</button>
                <? Generic::exportLogo(); ?>
                <script>
                    $('#submit_rekap_kupon_siswa_<?= $t; ?>').click(function () {
                        var tc_id = $('#pilih_TC_<?= $t; ?>').val();
                        var bln = $('#bulan_<?= $t; ?>').val();
                        var thn = $('#tahun_<?= $t; ?>').val();
                        $('#content_kupon_<?= $tc_id . $bln . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadRekapKuponOneTC?tc_id=" + tc_id + "&bln=" + bln + "&thn=" + thn, function () {

                        }, 'json');
                    });
                </script>
            </div>
        </section>
        <section class="clearfix">
        </section>
        <section class="content">
            <div class="table-responsive" id="content_kupon_<?= $tc_id . $bln . $thn; ?>">
                <table class="table table-bordered table-striped putih">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Bulan</th>
                        <th>Stock</th>
                        <th>Kupon Masuk</th>
                        <th>Transaksi Bulan ini</th>
                        <th>Stock Akhir</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $arrKuponStock = 0;
                    $arrKuponmasuk = 0;
                    $arrKuponTraBln = 0;
                    $arrKuponStockAkhir = 0;
                    $i = 1;
                    $objRekapKupon = new BIRekapKuponModel();
                    $arrRekap = $objRekapKupon->getWhere("bi_kupon_tc_id=$tc_id AND bi_kupon_bln=$bln AND bi_kupon_thn=$thn");
                    $arrKuponStock += $arrRekap[0]->bi_kupon_stock;
                    $arrKuponmasuk += $arrRekap[0]->bi_kupon_kupon_masuk;
                    $arrKuponTraBln += $arrRekap[0]->bi_kupon_trs_bln;
                    $arrKuponStockAkhir += $arrRekap[0]->bi_kupon_stock_akhir;
                    ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= Generic::getMonthName($arrRekap[0]->bi_kupon_bln); ?></td>
                        <td><?= $arrRekap[0]->bi_kupon_stock; ?></td>
                        <td><?= $arrRekap[0]->bi_kupon_kupon_masuk; ?></td>
                        <td><?= $arrRekap[0]->bi_kupon_trs_bln; ?></td>
                        <td><?= $arrRekap[0]->bi_kupon_stock_akhir; ?></td>
                    </tr>

                    <? ?>
                    </tbody>

                    <tfoot>
                    <tr>
                        <td colspan="2" style="text-align:center; font-weight: bold">Total</td>
                        <td><?= $arrKuponStock; ?></td>
                        <td><?= $arrKuponmasuk; ?></td>
                        <td><?= $arrKuponTraBln; ?></td>
                        <td><?= $arrKuponStockAkhir; ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <style>
            .tengahcolumn {
                vertical-align: middle !important;
                font-weight: bold;
            }

            .putih {
                background-color: white;
            }
        </style>
        <script>
            $('#export_<?= $t; ?>').click(function () {
                var bln = $('#bulan_<?= $t; ?>').val();
                var thn = $('#tahun_<?= $t; ?>').val();
                var tc_id = '<?=$tc_id;?>';
                window.open('<?= _SPPATH; ?>BIWebHelper/exportSempoa?tc_id=' + tc_id + '&type=<?= KEY::$REPORT_REKAP_BULANAN_KUPON_TC_LVL; ?>&bln=' + bln + "&thn=" + thn, "_blank ");
            });
        </script>
        <?
    }

    public function get_laporan_murid_by_status_tc()
    {
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $status_murid = isset($_GET['status_murid']) ? addslashes($_GET['status_murid']) : 1;
        $t = time();
        $arrBulan = Generic::getAllMonthsWithAll();
        $tc_id = AccessRight::getMyOrgID();
        $arrStatus = Generic::getAllStatusMurid();

        $arrNamaMurid = Generic::getAllMuridByTC($tc_id);
        $statusHistory = new StatusHisMuridModel();
        if ($status_murid != 1) {
            $arrStatusHistory = $statusHistory->getWhere("MONTH(status_tanggal_mulai)=$bln AND YEAR(status_tanggal_mulai) = $thn AND status_tc_id = $tc_id AND status = $status_murid ");

        } else {
            $arrStatusHistory = $statusHistory->getWhere("(MONTH(status_tanggal_akhir)>$bln AND YEAR(status_tanggal_akhir)= $thn OR status_tanggal_akhir='1970-01-01 07:00:00' )AND status_tc_id = $tc_id AND status = $status_murid ");
            $arrStatusHistory = $statusHistory->getWhere("(MONTH(status_tanggal_akhir)>$bln AND YEAR(status_tanggal_akhir)= $thn OR status_tanggal_akhir='1970-01-01 07:00:00' )AND status_tc_id = $tc_id AND status = $status_murid ");

        }

        ?>

        <section class="content-header">
            <h1>Rekapitulasi Status Murid</h1>
            <div class="box-tools pull-right">
                Status :<select id="status_<?= $t; ?>">
                    <?
                    foreach ($arrStatus as $key => $status) {
                        $sel = "";
                        if ($key == 1) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $key; ?>" <?= $sel; ?>><?= $status; ?></option>
                        <?
                    }
                    ?>
                </select>

                Bulan :<select id="bulan_<?= $t; ?>">
                    <?
                    foreach ($arrBulan as $bln2) {
                        $sel = "";
                        if ($bln2 == date("n")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                        <?
                    }
                    ?>
                </select>
                Tahun :<select id="tahun_<?= $t; ?>">
                    <?
                    for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                        $sel = "";
                        if ($x == date("Y")) {
                            $sel = "selected";
                        }
                        ?>
                        <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                        <?
                    }
                    ?>
                    }
                    ?>
                </select>
                <button id="submit_rekap_siswa_status_<?= $t; ?>">submit</button>
                <!--                --><?// Generic::exportLogo();
                ?>
                <script>
                    $('#submit_rekap_siswa_status_<?= $t; ?>').click(function () {
                        var bln = $('#bulan_<?= $t; ?>').val();
                        var thn = $('#tahun_<?= $t; ?>').val();
                        var status = $('#status_<?= $t; ?>').val();
                        $('#content_murid_<?= $tc_id . $bln . $thn; ?>').load("<?= _SPPATH; ?>BIWebHelper/loadMuridByStatusTC?bln=" + bln + "&thn=" + thn + "&status=" + status, function () {

                        }, 'json');
                    });
                </script>
            </div>
        </section>
        <section class="clearfix">
        </section>
        <section class="content">
        <div class="table-responsive" id="content_kupon_<?= $tc_id . $bln . $thn; ?>">
            <table class="table table-bordered table-striped putih">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Murid</th>
                    <th>Level</th>
                    <th>Tanggal sesuai Status</th>
                </tr>
                </thead>

                <tbody id="content_murid_<?= $tc_id . $bln . $thn; ?>">
                <?
                $i = 1;
                foreach ($arrStatusHistory as $val) {
                    ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $arrNamaMurid[$val->status_murid_id]; ?></td>
                        <td><?= Generic::getLevelNameByID($val->status_level_murid); ?></td>
                        <td><?= ($val->status_tanggal_mulai); ?></td>
                    </tr>
                    <?
                }
                ?>
                </tbody>
            </table>
        </div>
        <?
    }
}
