<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MuridWeb
 *
 * @author efindiongso
 */
class MuridWeb extends WebService
{

// AK
    public function get_murid_ak()
    {
        $objSiswa = new MuridModel();
        $objSiswa->getOrderBy("murid_tc_id ASC");
        $crud = new CrudCustom();
        $crud->run_custom($objSiswa, "MuridWeb", "get_murid_ak");
    }

    /*
     * 
     */

    public function create_murid_tc()
    {
        $_GET['cmd'] = 'edit';
        $this->read_murid_tc_hlp();

        die();

        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new MuridModel();
        $obj->getByID($_GET['id']);

        if ($obj->pay_firsttime == 0)
            $obj->onAjaxSuccess = "openLw('Payment_Murid','" . _SPPATH . "MuridWebHelper/firsttime_payment?id_murid='+data.bool,'fade');";

        $obj->hideColoums = array("murid_ak_id", "murid_kpo_id");
        $obj->read_filter_array = array("murid_tc_id" => $myOrgID);
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_murid_tc");
        $crud->ar_edit = AccessRight::hasRight("update_murid_tc");
        $crud->ar_delete = AccessRight::hasRight("delete_murid_tc");
        $crud->run_custom($obj, "MuridWeb", "create_murid_tc");
    }



    public function read_murid_tc()
    {

        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new MuridModel();

        if ($_GET['cmd'] == 'edit' && $_GET['id'] != "")
            $obj->getByID($_GET['id']);

        if ($obj->pay_firsttime == '0')
            $obj->onAjaxSuccess = "openLw('Payment_Murid','" . _SPPATH . "MuridWebHelper/firsttime_payment?id_murid='+data.bool,'fade');";

        $obj->removeAutoCrudClick = array("pay_firsttime", "profile");
        $obj->read_filter_array = array("murid_tc_id" => $myOrgID);
        $obj->hideColoums = array("murid_tc_id", "murid_ak_id", "murid_kpo_id", "murid_ibo_id");
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_murid_tc");
        $crud->ar_edit = AccessRight::hasRight("update_murid_tc");
        $crud->ar_delete = AccessRight::hasRight("delete_murid_tc");
        $crud->filter_extra = "status_murid";

        if ($_GET['status_murid'] != "") {
            $_SESSION['filter_status_murid'] = $_GET['status_murid'];
        }


        if (isset($_SESSION['filter_status_murid']) && $_SESSION['filter_status_murid'] != "99") {
            $obj->read_filter_array["status"] = $_SESSION['filter_status_murid'];
        }

        $crud->run_custom($obj, "MuridWeb", "read_murid_tc");


    }


    /*
     * 
     */

    public function read_murid_tc_hlp_tmp()
    {


        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new MuridModel();
        $obj->onAjaxSuccess = "openLw('Payment_Murid','" . _SPPATH . "MuridWebHelper/firsttime_payment?id_murid='+data.bool,'fade');";
        $obj->removeAutoCrudClick = array("pay_firsttime");
        $obj->read_filter_array = array("murid_tc_id" => $myOrgID);
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_murid_tc");
        $crud->ar_edit = AccessRight::hasRight("update_murid_tc");
        $crud->ar_delete = AccessRight::hasRight("delete_murid_tc");
        $crud->filter_extra = "status_murid";

        if ($_GET['status_murid'] != "")
            $_SESSION['filter_status_murid'] = $_GET['status_murid'];


        if (isset($_SESSION['filter_status_murid']) && $_SESSION['filter_status_murid'] != "99") {
            $obj->read_filter_array["status"] = $_SESSION['filter_status_murid'];
        }

        $crud->run_custom($obj, "MuridWeb", "read_murid_tc_hlp_tmp");

    }

    public function read_murid_tc_hlp()
    {


        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new MuridModel();
        $obj->onAjaxSuccess = "openLw('Payment_Murid','" . _SPPATH . "MuridWebHelper/firsttime_payment?id_murid='+data.bool,'fade');";
//        $obj->removeAutoCrudClick = array("pay_firsttime");
//        $obj->read_filter_array = array("murid_tc_id" => $myOrgID);
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_murid_tc");
        $crud->ar_edit = AccessRight::hasRight("update_murid_tc");
        $crud->ar_delete = AccessRight::hasRight("delete_murid_tc");
        $crud->h1 = "Pendaftaran Murid Baru";
        $crud->run_custom($obj, "MuridWeb", "read_murid_tc_hlp", " murid_tc_id='$myOrgID' ");
//
//        $crud = new CrudCustomSempoa();
//        $crud->ar_add = AccessRight::hasRight("create_murid_tc");
//        $crud->ar_edit = AccessRight::hasRight("update_murid_tc");
//        $crud->ar_delete = AccessRight::hasRight("delete_murid_tc");
//        $crud->run_custom($obj, "MuridWeb", "read_murid_tc", " murid_tc_id='$myOrgID' ");

//        $obj = new SempoaAccount();
//        $obj->read_filter_array = array("admin_org_id" => $group_id);
        ?>

        <?
    }

    /*
     * 
     */

    public function update_murid_tc()
    {

    }

    /*
     * 
     */

    public function delete_murid_tc()
    {

    }

    /*
     * 
     */

    public function create_absensi_murid()
    {

    }

    /*
     * 
     */

    public function read_absensi_murid()
    {

        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : AccessRight::getMyOrgID();
        $t = time();
        $arrBulan = Generic::getAllMonths();
        $absen = new AbsenEntryModel();
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
                    var tc_id = '<?= $tc_id; ?>';
                    $('#container_absensi_<?= $t; ?>').load("<?= _SPPATH; ?>MuridWebHelper/getAbsensiMuridByMonth?org=tc&bln=" + bln + "&thn=" + thn + "&tc_id=" + <?= $tc_id; ?>, function () {
                    }, 'json');
                });
            </script>
        </section>

        <?
        MuridWebHelper::tableAbsensi($absen, $arrAbsen, $tc_id, $t);
    }

    /*
     * 
     */

    public function update_absensi_murid()
    {

    }

    /*
     * 
     */

    public function delete_absensi_murid()
    {

    }

// KPO
    public function get_murid_kpo()
    {

        $kpoID = AccessRight::getMyOrgID();
        $arrMyIBO = Generic::getAllMyIBO($kpoID);
        $iboID = (isset($_GET['ibo_id']) ? addslashes($_GET['ibo_id']) : key($arrMyIBO));

        $arrMyTC = Generic::getAllMyTC($iboID);
        $tcid = (isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC));
        $t = time();
        $arrStatusMurid = Generic::getAllStatusMurid();
        $arrJenisKelamin = Generic::getJeniskelamin();
        $arrLevel = Generic::getAllLevel();

        $obj = new MuridModel();
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = 20;
        $begin = ($page - 1) * $limit;
        $status = isset($_GET['status']) ? addslashes($_GET['status']) : 1;
        $arrMurid = $obj->getWhere("murid_tc_id=$tcid AND status=$status ORDER BY nama_siswa ASC  LIMIT $begin, $limit");
        $jumlahTotal = $obj->getJumlah("murid_tc_id=$tcid AND status=$status");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $index = (($page - 1) * 20) + 1;
        $return['classname'] = __FUNCTION__;
        $return['page'] = $page;
        $return['totalpage'] = $jumlahHalamanTotal;
        $return['perpage'] = $limit;
        $return['status'] = $status;
        $return['tc_id'] = $tcid;

        ?>
        <div id="container_tc_<?= $tcid; ?>">
            <section class="content-header">
                <h1>
                    <div class="pull-right" style="font-size: 13px;">
                        <label for="exampleInputName2">Pilih IBO:</label>
                        <select id="pilih_IBO_<?= $t; ?>">

                            <?
                            foreach ($arrMyIBO as $key => $val) {
                                if ($iboID == $key) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }

                                ?>
                                <option value="<?= $key; ?>" <?= $selected ?>><?= $val; ?></option>
                                <?
                            }
                            ?>
                        </select>

                        <label for="exampleInputName2">Pilih TC:</label>
                        <select id="pilih_tc_<?= $t; ?>">

                            <?
                            foreach ($arrMyTC as $key => $val) {
                                if ($tcid == $key) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                ?>
                                <option value="<?= $key; ?>" <?= $selected ?>><?= $val; ?></option>
                                <?
                            }
                            ?>
                        </select>
                        <label for="exampleInputName2">Status:</label>
                        <select id="pilih_status_<?= $t; ?>">

                            <?
                            foreach ($arrStatusMurid as $key => $val) {
                                if ($key == $status) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }

                                ?>
                                <option value="<?= $key; ?>" <?= $selected; ?>><?= $val; ?></option>
                                <?
                            }
                            ?>
                        </select>
                        <button class="btn btn-default" id="submit_pilih_tc_<?= $t; ?>">Submit</button>
                    </div>
                </h1>
            </section>


            <div class="clearfix"></div>
            <section class="content">

                <table class='table table-bordered table-striped '>
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Siswa</th>
                        <th>Nama Siswa</th>
                        <th>Status</th>
                        <th>Jenis Kelamin</th>
                        <th>Level</th>
                        <th>Profile</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    foreach ($arrMurid as $key => $murid) {
                        ?>
                        <tr id='<?= $murid->id_murid; ?>'>
                            <td>
                                <?= $index; ?>
                            </td>
                            <td>
                                <?= $murid->kode_siswa ?>
                            </td>
                            <td>
                                <?= $murid->nama_siswa ?>
                            </td>
                            <td><?= $arrStatusMurid[$murid->status]; ?></td>
                            <td>
                                <?= $arrJenisKelamin[$murid->jenis_kelamin];
                                ?>
                            </td>
                            <td>
                                <?= Generic::getLevelNameByID($murid->id_level_sekarang); ?>
                            </td>
                            <td>
                                <button
                                    onclick="openLw('Profile_Murid', '<?= _SPPATH; ?>MuridWebHelper/profile?id_murid=<?= $murid->id_murid; ?>', 'fade');">
                                    Profile
                                </button>
                            </td>
                        </tr>
                        <?
                        $index++;
                    }
                    ?>
                    </tbody>
                </table>
                <?
                $webClass = __CLASS__;
                Generic::pagination($return, $webClass);

                ?>

            </section>
            <script>
                $('#pilih_IBO_<?= $t; ?>').change(function () {
                    var slc = $('#pilih_IBO_<?= $t; ?>').val();
                    getTC(slc);
                });

                function getTC(slc) {
                    $.ajax({
                        type: "POST",
                        url: "<?= _SPPATH; ?>MuridWebHelper/getTC?",
                        data: 'ibo_id=' + slc,
                        success: function (data) {
                            console.log(data);
                            $("#pilih_tc_<?= $t; ?>").html(data);
                        }
                    });
                }
                $('#submit_pilih_tc_<?= $t; ?>').click(function () {
                    var slc = $('#pilih_tc_<?= $t; ?>').val();
                    var status = $('#pilih_status_<?= $t; ?>').val();
                    $('#container_tc_<?= $tcid; ?>').load("<?= _SPPATH; ?>MuridWebHelper/viewMuridKPO?tc_id=" + slc + "&status=" + status, function () {
                    }, 'json');
                });

            </script>
        </div>
        <?
    }

// IBO

    public function get_murid_ibo()
    {


        if($_GET['status_murid']!=""){
            $gw = new MuridWebHelper();
            $gw->read_murid_tc_ibo();
            die();
        }


        $myOrgID = (AccessRight::getMyOrgID());
        $arrMyTC = Generic::getAllMyTC($myOrgID);
//        $arrMyTC[''] = "";

        $tcid = $_SESSION['selected_murid_tc_id'];

        $t = time();
        ?>
        <div style="text-align: center; margin-top: 100px;">
            <h1>Pilih TC Anda</h1>
            <div style="width: 200px; margin: 0 auto; margin-bottom: 20px;">
                <select id="pilih_tc_<?= $t; ?>" class="form-control" style="font-size: 20px;">

                    <?

                    foreach ($arrMyTC as $key => $val) {
                        if ($tcid == $key) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        ?>
                        <option value="<?= $key; ?>" <?= $selected; ?>><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>
            </div>

            <button class="btn btn-default" id="submit_status_murid_<?= $t; ?>">submit</button>
            <script>
                $('#submit_status_murid_<?= $t; ?>').click(function () {
                    var slc = $('#pilih_tc_<?= $t; ?>').val();
                    openLw("murid_tc_ibo","<?= _SPPATH; ?>MuridWebHelper/read_murid_tc_ibo?tc_id="+slc+"&now="+$.now(),"fade");
                });

            </script>
        </div>


        <?




        die();

        $arrStatusMurid = Generic::getAllStatusMurid();
        $arrJenisKelamin = Generic::getJeniskelamin();
        $arrLevel = Generic::getAllLevel();
        $IBOid = AccessRight::getMyOrgID();
        $arrMyTC = Generic::getAllMyTC($IBOid);
        $tcid = (isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC));
//        pr($tcid);
        $t = time();
        $obj = new MuridModel();

        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = 20;
        $begin = ($page - 1) * $limit;
        $index = (($page - 1) * 20) + 1;
        $status = isset($_GET['status']) ? addslashes($_GET['status']) : 1;
        $arrMurid = $obj->getWhere("murid_tc_id=$tcid AND status=$status ORDER BY nama_siswa ASC  LIMIT $begin, $limit");
        $jumlahTotal = $obj->getJumlah("murid_tc_id=$tcid AND status=$status");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);

        $return['classname'] = __FUNCTION__;
        $return['page'] = $page;
        $return['totalpage'] = $jumlahHalamanTotal;
        $return['perpage'] = $limit;
        $return['status'] = $status;
        $return['tc_id'] = $tcid;
        ?>

        <div id='container_tc_<?= $t; ?>'">


        <section class="content-header">
            <div class="pull-right" style="font-size: 13px;">
                <label for="exampleInputName2">Pilih TC:</label>
                <select id="pilih_tc_<?= $t; ?>">

                    <?

                    foreach ($arrMyTC as $key => $val) {
                        if ($tcid == $key) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        ?>
                        <option value="<?= $key; ?>" <?= $selected; ?>><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>
                <label for="exampleInputName2">Status:</label>
                <select id="pilih_status_<?= $t; ?>">

                    <?
                    foreach ($arrStatusMurid as $key => $val) {
                        if ($key == $status) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }

                        ?>
                        <option value="<?= $key; ?>" <?= $selected; ?>><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>
                <button id="submit_pilih_tc_<?= $t; ?>">Submit</button>
                <script>
                    $('#submit_pilih_tc_<?= $t; ?>').click(function () {
                        var slc = $('#pilih_tc_<?= $t; ?>').val();
//                        alert(slc);
                        var status = $('#pilih_status_<?= $t; ?>').val();
//                        alert(status);
                        $('#container_tc_<?= $t; ?>').load("<?= _SPPATH; ?>MuridWebHelper/viewMuridTC?tc_id=" + slc + "&status=" + status, function () {
                        }, 'json');
                    });

                </script>
            </div>


        </section>
        <div class="clearfix"></div>
        <section class="content">
            <table class='table table-bordered table-striped'>
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Siswa</th>
                    <th>Nama Siswa</th>
                    <th>Status</th>
                    <th>Jenis Kelamin</th>
                    <th>Level</th>
                    <th>Profile</th>
                </tr>
                </thead>
                <tbody>
                <?
                foreach ($arrMurid as $key => $murid) {
                    ?>
                    <tr id='<?= $murid->id_murid; ?>'>
                        <td>
                            <?= $index; ?>
                        </td>
                        <td>
                            <?= $murid->kode_siswa ?>
                        </td>
                        <td>
                            <?= $murid->nama_siswa ?>
                        </td>
                        <td><?= $arrStatusMurid[$murid->status]; ?></td>
                        <td>
                            <?= $arrJenisKelamin[$murid->jenis_kelamin];
                            ?>
                        </td>
                        <td>
                            <?= Generic::getLevelNameByID($murid->id_level_sekarang); ?>
                        </td>
                        <td>
                            <button
                                onclick="openLw('Profile_Murid', '<?= _SPPATH; ?>MuridWebHelper/profile?id_murid=<?= $murid->id_murid; ?>', 'fade');">
                                Profile
                            </button>
                        </td>
                    </tr>
                    <?
                    $index++;
                }
                ?>
                </tbody>
            </table>
            <?
            $webClass = __CLASS__;
            Generic::pagination($return, $webClass);

            ?>
        </section>

        </div>
        <?
    }

    public function read_nilai_murid_tc()
    {
        $murid = new MuridModel();
        $nilaiMurid = new NilaiModel();
        $myOrgID = AccessRight::getMyOrgID();
        $q = "SELECT * FROM {$nilaiMurid->table_name} nilai INNER JOIN {$murid->table_name} murid ON nilai.nilai_murid_id=murid.id_murid WHERE nilai.nilai_org_id='$myOrgID' AND murid.status !=0 AND nilai.nilai_result = 0";
        global $db;
        $arrNilaiMurid = $db->query($q, 2);
        ?>
        <section class="content-header">
            <h1>Nilai Murid</h1>
        </section>
        <section class="content">
            <table class="table table-striped table-responsive">
                <thead>
                <tr>
                    <th>Murid</th>
                    <th>Level</th>
                    <th>Nilai</th>
                    <th>Tanggal</th>
                </tr>
                </thead>
                <tbody>
                <?
                $arrNilai = Generic::getSettingNilai();
                foreach ($arrNilaiMurid as $nilai) {
                    $murid->getByID($nilai->nilai_murid_id);
                    ?>
                    <tr>
                        <td><?= Generic::getMuridNamebyID($nilai->nilai_murid_id); ?></td>
                        <td id="level_<?= $nilai->nilai_murid_id; ?> "><?= Generic::getLevelNameByID($nilai->nilai_level); ?></td>
                        <td id="result_<?= $nilai->nilai_murid_id . "_" . $nilai->nilai_level; ?>"><?= $nilai->nilai_result; ?></td>
                        <td><?= $nilai->nilai_create_date; ?></td>
                    </tr>
                    <script>
                        //                        if(<? //$nilai->nilai_level == $murid->id_level_sekarang;     ?>)
                        $('#result_<?= $nilai->nilai_murid_id . "_" . $nilai->nilai_level; ?>').dblclick(function () {
                            var current = $("#result_<?= $nilai->nilai_murid_id . "_" . $nilai->nilai_level; ?>").html();

                            var html = "<input type=\"number\" name=\"nilai\" id='select_nilai_<?= $nilai->nilai_murid_id . "_" . $nilai->nilai_level; ?>'>";


                            $("#result_<?= $nilai->nilai_murid_id . "_" . $nilai->nilai_level; ?>").html(html);
                            $('#select_nilai_<?= $nilai->nilai_murid_id . "_" . $nilai->nilai_level; ?>').change(function () {
                                var slc = $('#select_nilai_<?= $nilai->nilai_murid_id . "_" . $nilai->nilai_level; ?>').val();

                                var id_murid = '<?= $nilai->nilai_murid_id; ?>';
                                var level = '<?= $nilai->nilai_level; ?>';
                                if (confirm("Anda yakin?")) {
//                                    alert(id_murid + "-" +level+ "-" + slc);
                                    $.get("<?= _SPPATH; ?>MuridWebHelper/setnilai?id_murid=" + id_murid + "&level=" + level + "&nilai=" + slc, function (data) {
                                            if (data.status_code) {
                                                alert(data.status_message);
                                                lwrefresh(selected_page);
                                            } else {
                                                alert(data.status_message);
                                            }
                                        }, 'json'
                                    );
                                }

                            });
                        });
                    </script>

                    <?
                }
                ?>
                </tbody>
            </table>
        </section>
        <?
    }

    public function get_nilai_murid_ibo()
    {
        $arrMyTC = Generic::getAllMyTC(AccessRight::getMyOrgID());
        $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC);
        $arrAktiveMurid = Generic::getAktivMuridByTcID($tc_id);
        $t = time();
        ?>
        <section class="content-header">
            <h1>

                <div class="pull-left" style="font-size: 13px;">
                    TC : <select id="tc_<?= $t; ?>">
                        <?
                        foreach ($arrMyTC as $key => $tc) {
                            ?>
                            <option value="<?= $key; ?>"> <?= $tc; ?></option>
                            <?
                        }
                        ?>
                    </select>
                    Murid : <select id="murid_<?= $t; ?>">
                        <?
                        foreach ($arrAktiveMurid as $key => $murid) {
                            ?>
                            <option value="<?= $key; ?>"> <?= $murid; ?></option>
                            <?
                        }
                        ?>
                    </select>

                    <button id="submit_nilai_<?= $t; ?>">submit</button>
                </div>

            </h1>
            <script>
                var tc_id = "";
                $('#submit_nilai_<?= $t; ?>').click(function () {
                    var id_murid = $('#murid_<?= $t; ?>').val();
                    tc_id = $('#tc_<?= $t; ?>').val();
                    $('#nilai_<?= $t; ?>').load("<?= _SPPATH; ?>MuridWebHelper/getNilaiMurid?tc_id=" + tc_id + "&id_murid=" + id_murid, function () {


                    }, 'json');
                });

                function getMurid(tc_id) {
                    $.ajax({
                        type: "POST",
                        url: "<?= _SPPATH; ?>MuridWebHelper/getMuridByTC?",
                        data: 'tc_id=' + tc_id,
                        success: function (data) {
                            console.log(data);
                            $("#murid_<?= $t; ?>").html(data);
                        }
                    });
                }
            </script>
        </section>
        <div class="clearfix"></div>
        <section class="content">
            <div class="table-responsive">
                <table class="table table-striped ">
                    <thead>
                    <tr>
                        <th>
                            Level
                        </th>
                        <th>
                            Nilai
                        </th>
                        <th>
                            Tanggal
                        </th>
                    </tr>
                    </thead>
                    <tbody id="nilai_<?= $t; ?>">


                    </tbody>
                </table>
            </div>
        </section>


        <?
    }

    public function get_sertifikat_tercetak()
    {
        $arrMyTC = Generic::getAllMyTC(AccessRight::getMyOrgID());
        $tc_id = Key($arrMyTC);
        $t = time();
        ?>
        <section class="content-header">
            <h1><?= KEY::$TITLESERTIFIKATTERCETAK; ?></h1>
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
                <button id="submit_sertifikat_tc_<?= $t; ?>">submit</button>
                <script>
                    $('#submit_sertifikat_tc_<?= $t; ?>').click(function () {
                        var tc_id = $('#pilih_TC_<?= $t; ?>').val();
                        $('#container_load_certificate_tercetak_<?= $t; ?>').load("<?= _SPPATH; ?>MuridWebHelper/loadCertTC?tc_id=" + tc_id +"&status=1", function () {

                        }, 'json');
                    });
                </script>
            </div>
            <div class="box-tools pull-left">
                <button id="back_<?= $t; ?>">Belum tercetak</button>
                <script>
                    $('#back_<?= $t; ?>').click(function () {
                        openLw('read_permintaan_sertifikat', '<?=_SPPATH;?>MuridWeb3/read_permintaan_sertifikat', 'fade');
                    });
                </script>
            </div>
        </section>
        <div class="clearfix"></div>
        <?
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;
        $objCertificate = new SertifikatModel();
        $arrCertificate = $objCertificate->getWhere("sertifikat_tc_id=$tc_id AND sertifikat_status = 1 LIMIT $begin, $limit");
        $jumlahTotal = $objCertificate->getJumlah("sertifikat_tc_id='$tc_id AND sertifikat_status = 1");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $arrStatus = array("<b>Belum di cetak</b>", "Sdh di cetak");
        ?>
        <section class="content">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>

                        <th>
                            Nama
                        </th>
                        <th>
                            Level
                        </th>
                        <th>
                            TC
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Tanggal Request
                        </th>
                        <th>
                            Tanggal Cetak
                        </th>

                    </tr>
                    </thead>
                    <tbody id="container_load_certificate_tercetak_<?= $t; ?>">
                    <?
                    foreach ($arrCertificate as $key => $val) {
                        ?>
                        <tr>

                            <td><?= Generic::getMuridNamebyID($val->sertifikat_murid_id); ?></td>
                            <td><?= Generic::getLevelNameByID($val->sertifikat_murid_level); ?></td>
                            <td><?= Generic::getTCNamebyID($val->sertifikat_tc_id); ?></td>

                            <td id="status_<?= $val->sertifikat_id; ?>"><?
                                if ($val->sertifikat_status) {
                                    echo $arrStatus[$val->sertifikat_status];
                                } else {
                                    ?>
                                    <button id="cetak_<?= $val->sertifikat_id . $t; ?>"
                                            class="btn btn-default sertifikat_<?= $val->sertifikat_id; ?>"><?= $arrStatus[$val->sertifikat_status]; ?></button>

                                    <?
                                }
                                ?></td>

                            <td><?= $val->sertifikat_req_date; ?></td>
                            <td id="sertifikat_kirim_date_<?= $val->sertifikat_id; ?>"> <?
                                if ($val->sertifikat_kirim_date != "1970-01-01 07:00:00") {
                                    echo $val->sertifikat_kirim_date;
                                }
                                ?></td>
                        </tr>
                        <script>

                            $('#cetak_<?= $val->sertifikat_id . $t; ?>').click(function () {
                                $.get("<?= _SPPATH; ?>MuridWebHelper/updateCertificate?id_certificate=<?= $val->sertifikat_id; ?>", function (data) {

                                    alert(data.status_message);
                                    if (data.status_code) {
                                        lwrefresh(selected_page);
                                        $('.sertifikat_<?= $val->sertifikat_id; ?>').hide();
                                        $('#status_<?= $val->sertifikat_id; ?>').html('<?= $arrStatus[1]; ?>');
                                        $('#sertifikat_kirim_date_<?= $val->sertifikat_id; ?>').html('<?= leap_mysqldate(); ?>');
                                    }
                                }, 'json');


                            });
                        </script>
                        <?
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <button class="btn btn-default" id="loadmore_tercetak_certificate_<?= $t; ?>">Load more</button>
            </div>
            <script>
                var page_cert = <?= $page; ?>;
                var total_cert = <?= $jumlahHalamanTotal; ?>;
                $('#loadmore_tercetak_certificate_<?= $t; ?>').click(function () {
                    if (page_cert < total_cert) {
                        page_cert++;
                        var tc_id = $('#pilih_TC_<?= $t; ?>').val();
                        $.get("<?= _SPPATH; ?>MuridWebHelper/certificatetercetak_load?page=" + page_cert + "&tc_id=" +tc_id, function (data) {
                            $("#container_load_certificate_tercetak_<?=$t;?>").append(data);
                        });
                        if (page_cert > total_cert)
                            $('#loadmore_tercetak_certificate_<?= $t; ?>').hide();
                    } else {
                        $('#loadmore_tercetak_certificate_<?= $t; ?>').hide();
                    }
                });
            </script>
        </section>
        <?


    }
}
