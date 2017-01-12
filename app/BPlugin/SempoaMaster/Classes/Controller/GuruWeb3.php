<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GuruWeb3
 *
 * @author efindiongso
 */
class GuruWeb3 extends WebService
{

    //put your code here
    //IBO
    public function get_absensi_guru_ibo()
    {
        $arrMyTC = Generic::getAllMyTC(AccessRight::getMyOrgID());
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC);
        $t = time();
        $arrBulan = Generic::getAllMonths();
        $absen = new AbsenGuruModel();
        $arrAbsen = $absen->getWhere("absen_tc_id='$tc_id' AND (Month(absen_date)= $bln) AND (YEAR(absen_date)=$thn)  Group BY absen_date ");
        ?>
        <section class="content-header">
            <h1>
                <div class="pull-right" style="font-size: 13px;">
                    TC : <select id="tc_<?= $t; ?>">
                        <?
                        foreach ($arrMyTC as $key => $tc) {
                            ?>
                            <option value="<?= $key; ?>"> <?= $tc; ?></option>
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

                    <button id="submit_bln_<?= $t; ?>">submit</button>
                </div>
                Absensi
            </h1>
            <script>
                $('#submit_bln_<?= $t; ?>').click(function () {
                    var bln = $('#bulan_<?= $t; ?>').val();
                    var thn = $('#tahun_<?= $t; ?>').val();
                    var tc_id = $('#tc_<?= $t; ?>').val();

                    $('#all_<?= $t; ?>').load("<?= _SPPATH; ?>MuridWebHelper/getAbsensiGuruByMonth?org=ibo&bln=" + bln + "&thn=" + thn + "&tc_id=" + tc_id, function () {
                    }, 'json');
                });
            </script>
        </section>

        <div id="all_<?= $t; ?>">
        <?

        GuruWebHelper::tableAbsensiGuru($absen, $arrAbsen, $tc_id, $t);
        ?>
        </div>
        <?
    }

    // KPO
    public function get_absensi_guru_kpo()
    {
        $arrMyIBO = Generic::getAllMyIBO(AccessRight::getMyOrgID());
        $arrMyTC = Generic::getAllMyTC(key($arrMyIBO));
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC);
        $ibo_id = isset($_GET['ibo_id']) ? addslashes($_GET['ibo_id']) : key($arrMyIBO);
        $t = time();
        $arrBulan = Generic::getAllMonths();
        $absen = new AbsenGuruModel();
        $arrAbsen = $absen->getWhere("absen_tc_id='$tc_id' AND (Month(absen_date)= $bln) AND (YEAR(absen_date)=$thn)  Group BY absen_date ");
        ?>
        <section class="content-header">
            <h1>
                <div class="pull-right" style="font-size: 13px;">
                    IBO : <select id="ibo_<?= $t; ?>">
                        <?
                        foreach ($arrMyIBO as $key => $ibo) {
                            ?>
                            <option value="<?= $key; ?>"> <?= $ibo; ?></option>
                            <?
                        }
                        ?>
                    </select>

                    TC : <select id="tc_<?= $t; ?>">
                        <?
                        foreach ($arrMyTC as $key => $tc) {
                            ?>
                            <option value="<?= $key; ?>"> <?= $tc; ?></option>
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

                    <button id="submit_bln_<?= $t; ?>">submit</button>
                </div>
                Absensi
            </h1>
            <script>

                $('#ibo_<?= $t; ?>').change(function () {
                    var slc = $('#ibo_<?= $t; ?>').val();
                    getTC(slc);
                });

                function getTC(slc) {
                    $.ajax({
                        type: "POST",
                        url: "<?= _SPPATH; ?>MuridWebHelper/getTC?",
                        data: 'ibo_id=' + slc,
                        success: function (data) {
                            console.log(data);
                            $("#tc_<?= $t; ?>").html(data);
                        }
                    });
                }


                $('#submit_bln_<?= $t; ?>').click(function () {
                    var bln = $('#bulan_<?= $t; ?>').val();
                    var thn = $('#tahun_<?= $t; ?>').val();
                    var tc_id = $('#tc_<?= $t; ?>').val();
                    $('#container_absensi_<?= $t; ?>').load("<?= _SPPATH; ?>GuruWebHelper/getAbsensiGuruByMonth?org=tc&bln=" + bln + "&thn=" + thn + "&tc_id=" + tc_id, function () {
                    }, 'json');
                });
            </script>
        </section>
        <?
        GuruWebHelper::tableAbsensiGuru($absen, $arrAbsen, $tc_id, $t);
    }

    public function read_absensi_guru()
    {
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : AccessRight::getMyOrgID();
        $t = time();
        $arrBulan = Generic::getAllMonths();
        $absen = new AbsenGuruModel();
        $arrAbsen = $absen->getWhere("absen_tc_id='$tc_id' AND (Month(absen_date)= $bln) AND (YEAR(absen_date)=$thn)  Group BY absen_date ");
        ?>
        <section class="content-header">
            <h1>
                <div class="pull-right" style="font-size: 13px;">
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

                    <button id="submit_bln_<?= $t; ?>">submit</button>
                </div>
                Absensi
            </h1>
            <script>
                $('#submit_bln_<?= $t; ?>').click(function () {
                    var bln = $('#bulan_<?= $t; ?>').val();
                    var thn = $('#tahun_<?= $t; ?>').val();
                    var tc_id = '<?= $myorg ?>';
                    $('#container_absensi_<?= $t; ?>').load("<?= _SPPATH; ?>GuruWebHelper/getAbsensiGuruByMonth?org=tc&bln=" + bln + "&thn=" + thn + "&tc_id=" + <?= $tc_id; ?>, function () {
                    }, 'json');
                });
            </script>
        </section>

        <?
        GuruWebHelper::tableAbsensiGuru($absen, $arrAbsen, $tc_id, $t);
    }

}
