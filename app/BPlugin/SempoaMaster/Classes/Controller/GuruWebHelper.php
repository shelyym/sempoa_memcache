<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GuruWebHelper
 *
 * @author efindiongso
 */
class GuruWebHelper extends WebService
{

    function guru_crud_per_tc(){



        if($_GET['tc_id']!=""){
            $_SESSION['selected_guru_tc_id'] = $_GET['tc_id'];
        }
        $myOrgID = $_SESSION['selected_guru_tc_id'];

        if($myOrgID=="")die("No TC ID");

        $obj = new SempoaGuruModel();

        $obj->removeAutoCrudClick = array("email_guru","profile");
        $obj->read_filter_array = array("guru_tc_id" => $myOrgID);
        $obj->hideColoums = array("guru_ak_id", "guru_kpo_id","guru_ibo_id");
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_guru_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_guru_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_guru_ibo");
        $crud->filter_extra = "status_guru";

        if($_GET['status_guru'] != ""){
            $_SESSION['filter_status_guru'] = $_GET['status_guru'];
        }


        if(isset($_SESSION['filter_status_guru']) && $_SESSION['filter_status_guru']!="88"){
            $obj->read_filter_array["status"] = $_SESSION['filter_status_guru'];
        }



        $crud->run_custom($obj, "GuruWebHelper", "guru_crud_per_tc");
    }

    //put your code here

    function guru_profile()
    {
        $myType = AccessRight::getMyOrgType();
        $id = addslashes($_GET['guru_id']);
        $guru = new SempoaGuruModel();
        $guru->getByID($id);
        ?>
        <style>
            .glyphicon-pencil {
                cursor: pointer;
            }
        </style>
        <style>
            .murid_prof table {
                background-color: #fff;
            }

            .murid_prof table td {
                line-height: 34px;
                vertical-align: middle;
            }

            .murid_prof .col-md-4 h3 {
                background-color: #f6f6f6;
                text-align: center;
                margin-bottom: 0px;
                border-bottom: 2px solid #005384;
                padding-bottom: 20px;
                padding-top: 20px;
            }

            .murid_prof .btn-default {
                background-color: #67a8ce;
                color: white;
                border-color: #67a8ce;
                font-weight: bold;
            }
        </style>
        <section class="content-header">
            <?
            if (AccessRight::getMyOrgType() == KEY::$KPO) {
                ?>
                <span id="edit_<?= $id; ?>" class="pull-right  glyphicon glyphicon-pencil"
                      onclick="openLw('GuruWeb4View', '<?= _SPPATH; ?>GuruWeb4/read_guru_kpo_hlp?cmd=edit&id=' +<?= $id; ?> + '&parent_page=' + window.selected_page + '&loadagain=' + $.now(), 'fade');"></span>

                <?
            } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {
                ?>
                <span id="edit_<?= $id; ?>" class="pull-right  glyphicon glyphicon-pencil"
                      onclick="openLw('GuruWebView', '<?= _SPPATH; ?>GuruWeb/read_guru_ibo_hlp?cmd=edit&id=' +<?= $id; ?> + '&parent_page=' + window.selected_page + '&loadagain=' + $.now(), 'fade');"></span>

                <?
            } else {
                ?>
                <span id="edit_<?= $id; ?>" class="pull-right  glyphicon glyphicon-pencil"
                      onclick="openLw('GuruWeb2View', '<?= _SPPATH; ?>GuruWeb2/read_guru_tc?cmd=edit&id=' +<?= $id; ?> + '&parent_page=' + window.selected_page + '&loadagain=' + $.now(), 'fade');"></span>

                <?
            }
            ?>


        </section>

        <section class="content" style="padding-left: 0px;">


            <div class="row2 murid_prof">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="text-center">
                        <img style="width: 100px" src="<?= _BPATH . _PHOTOURL . $guru->gambar; ?>"
                             onerror="imgError(this);"
                             class="img-circle">
                        <h1 style="margin-bottom: 0px; padding-bottom: 0px;">

                            <?= $guru->nama_guru; ?>
                        </h1>
                        <small><i>Guru</i></small>
                    </div>
                </div>

                <!-- edit form column -->
                <div class="col-md-4">
                    <h3><i class="fa fa-info-circle"></i> Basic Info</h3>

                    <table class="table table-striped ">
                        <tr>
                            <td>
                                Level :
                            </td>
                            <td>
                                <?= Generic::getLevelNameByID($guru->id_level_training_guru); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                TC :
                            </td>
                            <td>
                                <?= Generic::getTCNamebyID($guru->guru_tc_id); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                History
                            </td>
                            <td>
                                <button
                                    onclick="openLw('guru_history_<?= $id; ?>', '<?= _SPPATH; ?>GuruWebHelper/guru_history?id=<?= $id; ?>', 'fade');"
                                    class="btn btn-default">View History
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Invoices
                            </td>
                            <td>
                                <button
                                    onclick="openLw('guru_invoices_<?= $id; ?>', '<?= _SPPATH; ?>GuruWebHelper/guru_invoices?id=<?= $id; ?>', 'fade');"
                                    class="btn btn-default">Invoices
                                </button>
                            </td>
                        </tr>

                    </table>
                </div>


                <div class="col-md-4 ">
                    <h3><i class=" fa fa-dollar"></i> Insentif</h3>
                    <table class="table table-striped ">
                        <tr>
                            <td>
                                Insentif
                            </td>
                            <td>
                                <button
                                    onclick="openLw('guru_insentif_<?= $id; ?>', '<?= _SPPATH; ?>MuridWebHelper/guru_insentif?id=<?= $id; ?>', 'fade');"
                                    class="btn btn-default">Jumlah Murid Per Level
                                </button>
                            </td>
                        </tr>

                    </table>
                </div>

                <div class="col-md-4">
                    <h3><i class="fa fa-home"></i> Kelas</h3>
                    <table class="table table-striped ">
                        <tr>
                            <td>
                                Lihat Absensi
                            </td>
                            <td>
                                <button
                                    onclick="openLw('guru_absensi_<?= $id; ?>', '<?= _SPPATH; ?>GuruWebHelper/guru_absensi?id=<?= $id; ?>', 'fade');"
                                    class="btn btn-default">Absensi Guru
                                </button>
                            </td>
                        </tr>
                        <?
                        if ($myType == KEY::$TC) {
                            ?>
                            <tr>
                                <td>
                                    Absensi Guru
                                </td>
                                <td>
                                    <button
                                        onclick="openLw('absen_guru_profile<?= $id; ?>', '<?= _SPPATH; ?>KelasWebHelper/absen_guru_profile?id=<?= $id; ?>', 'fade');"
                                        class="btn btn-default">Absen
                                    </button>
                                </td>
                            </tr>
                            <?

                        }
                        ?>


                        <tr>
                            <td>
                                Kelas
                            </td>
                            <td>
                                <button
                                    onclick="openLw('guru_kelas_<?= $id; ?>', '<?= _SPPATH; ?>GuruWebHelper/guru_kelas?id=<?= $id; ?>', 'fade');"
                                    class="btn btn-default">View Kelas
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>
        <?
    }

    function guru_history()
    {
        $id = addslashes($_GET['id']);
        $guru = new SempoaGuruModel();
        $guru->getByID($id);
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;
        $kelas = new KelasWebModel();
        $arrKelas = $kelas->getWhere("guru_id = '$id' ORDER by id_kelas DESC LIMIT $begin, $limit");
        $jumlahTotal = $kelas->getJumlah("guru_id = '$id' ORDER by id_kelas DESC");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $t = time();
        ?>
        <section class="content-header">
            <h1>
                <div class="pull-right">
                    <button class="btn btn-default" onclick="back_to_profile_guru('<?= $id; ?>');">back to profile
                    </button>
                </div>
                History <?= $guru->nama_guru; ?>
            </h1>

        </section>


        <section class="content">
            <div id="history_guru_<?= $id; ?>">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a style="font-weight: bold; font-size: 15px;" href="#HKelas_guru_<?= $id; ?>"
                           data-toggle="tab">History Kelas</a>
                    </li>
                    <!--                    <li><a style="font-weight: bold; font-size: 15px;"  href="#HLevel_guru_<?= $id; ?>" data-toggle="tab">History Level</a>
                    </li>-->
                    <!--                    <li><a style="font-weight: bold; font-size: 15px;"  href="#Status_guru_<?= $id; ?>" data-toggle="tab">History Status</a>
                    </li>-->
                    <li><a style="font-weight: bold; font-size: 15px;" href="#Training_guru_<?= $id; ?>"
                           data-toggle="tab">History Training</a>
                    </li>
                </ul>

                <div class="tab-content ">
                    <div class="tab-pane active" id="HKelas_guru_<?= $id; ?>"
                         style="background-color: #FFFFFF; padding:10px;     border: 1px solid #ddd; border-top: 0px;">
                        <div class="table-responsive" style="padding-top: 10px;">
                            <table class=" table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Hari/Jam</th>
                                    <th>Level Guru</th>
                                    <th>Murid</th>
                                    <th>Level Murid</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                                </thead>
                                <tbody id="container_load_history_kelas_guru">
                                <tr>
                                    <?
                                    foreach ($arrKelas as $kls) {
                                    $once = false;
                                    $tgl_help = "";
                                    $muridKelas = new MuridKelasMatrix();
                                    $arrMurid = $muridKelas->getWhere("kelas_id='$kls->id_kelas' AND guru_id='$id'");
                                    foreach ($arrMurid as $murid) {
                                    ?>
                                <tr>
                                    <td>
                                        <?
                                        $hari = Generic::getWeekDay()[$kls->hari_kelas];
                                        $mulai = date("h:i", strtotime($kls->jam_mulai_kelas));
                                        $akhir = date("h:i", strtotime($kls->jam_akhir_kelas));

                                        $tgl = $hari . ", " . $mulai . " - " . $akhir;

                                        if (!($once)) {
                                            echo $tgl;
                                            //$once = true;
                                        }
                                        ?>

                                    </td>
                                    <td>
                                        <?
                                        if (!($once)) {
                                            echo Generic::getLevelNameByID($kls->level);
                                            $once = true;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?= Generic::getMuridNamebyID($murid->murid_id); ?>
                                    </td>
                                    <td>
                                        <?= Generic::getLevelNameByID($murid->level_murid); ?>
                                    </td>
                                    <td>
                                        <?
                                        if ($murid->active_status == 1)
                                            echo KEY::$AKTIV;
                                        else
                                            echo KEY::$NON_AKTIV;
                                        ?>
                                    </td>
                                    <td>
                                        <?= $murid->active_date; ?>
                                    </td>
                                    <td>
                                        <?
                                        if ($murid->nonactive_date == KEY::$TGL_KOSONG) {
                                            echo KEY::$AKTIV;
                                        } else {
                                            echo $murid->nonactive_date;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?
                                }
                                }
                                ?>
                                </tr>
                                <? ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-default" id="loadmore_History_kelas_guru_<?= $t; ?>">Load more
                            </button>
                        </div>
                        <script>
                            var page_history = <?= $page; ?>;
                            var total_page_history = <?= $jumlahHalamanTotal; ?>;
                            $('#loadmore_History_kelas_guru_<?= $t; ?>').click(function () {
                                if (page_history < total_page_history) {
                                    page_history++;
                                    $.get("<?= _SPPATH; ?>GuruWebHelper/history_kelas_load?id=<?= $id; ?>&page=" + page_history, function (data) {
                                        $("#container_load_history_kelas_guru").append(data);
                                    });
                                    if (page_history > total_page_history)
                                        $('#loadmore_History_kelas_guru_<?= $t; ?>').hide();
                                } else {
                                    $('#loadmore_History_kelas_guru_<?= $t; ?>').hide();
                                }
                            });
                        </script>


                    </div>


                    <div class="tab-pane" id="Training_guru_<?= $id; ?>"
                         style="background-color: #FFFFFF; padding:10px;border: 1px solid #ddd; border-top: 0px;">
                        <div class="table-responsive" style="padding-top: 10px;">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Tanggal</th>
                                    <th>Akhir</th>
                                    <th>Keterangan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $arrStatusTraining = Generic::getKeteranganTraining();
                                $objMatricTraining = new TrainingMatrixModel();
                                $jt = new JadwalTrainingModel();
                                $q = "SELECT *FROM {$objMatricTraining->table_name} tr INNER JOIN {$jt->table_name} jt ON tr.tm_training_id = jt.jt_id WHERE tr.tm_guru_id='$id' AND tr.tm_status=1";
                                global $db;
                                $arr = $db->query($q, 2);
                                foreach ($arr as $val) {
                                    ?>
                                    <tr>
                                        <td><?= Generic::getLevelNameByID($val->jt_level_from); ?></td>
                                        <td><?= ($val->jt_mulai_date); ?></td>
                                        <td><?= ($val->jt_akhir_date); ?></td>
                                        <td id="ket_training_<?= $val->tm_id . "_" . $val->tm_training_id . "_" . $val->tm_guru_id; ?>"><?= $arrStatusTraining[$val->tm_keterangan]; ?></td>
                                    </tr>
                                <?
                                $datetime2 = new DateTime($val->jt_akhir_date);
                                $datetime1 = new DateTime(date('Y-m-d H:i:s'));
                                $interval = $datetime2->diff($datetime1);

                                ?>
                                    <script>
                                        <?
                                        if(AccessRight::getMyOrgType() != KEY::$TC){
                                        ?>
                                        $('#ket_training_<?=$val->tm_id . "_" . $val->tm_training_id . "_" . $val->tm_guru_id;?>').dblclick(function () {
                                            var current = $("#ket_training_<?=$val->tm_id . "_" . $val->tm_training_id . "_" . $val->tm_guru_id;?>").html();
                                            if (current == "<i>Select</i>") {
                                                var html = "<select id='select_status_<?=$val->tm_id . "_" . $val->tm_training_id . "_" . $val->tm_guru_id;?>'>" +
                                                    "<option value='0'><i>Select</i></option>" +
                                                    "<option value='1'><b>Lulus</b></option>" +
                                                    "<option value='2'><b>Tidak Lulus</b></option>" +
                                                    "<option value='3'><b>Sakit</b></option>" +
                                                    "<option value='4'><b>Absen</b></option>" +
                                                    "</select>";
//                                            alert(html);
                                                $('#ket_training_<?=$val->tm_id . "_" . $val->tm_training_id . "_" . $val->tm_guru_id;?>').html(html);
                                                $('#select_status_<?=$val->tm_id . "_" . $val->tm_training_id . "_" . $val->tm_guru_id;?>').change(function () {
                                                        var tm_id = '<?=$val->tm_id?>';
                                                        var tr_id = '<?=$val->tm_training_id?>';
                                                        var guru_id = '<?=$val->tm_guru_id;?>';
                                                        var status = $('#select_status_<?= $val->tm_id . "_" . $val->tm_training_id . "_" . $val->tm_guru_id;?>').val();

                                                        $.get("<?= _SPPATH; ?>TrainingWebHelper/setKeteranganTraining?guru_id=" + guru_id + "&tr_id=" + tr_id + "&tm_id=" + tm_id + "&status=" + status, function (data) {

                                                            lwrefresh(selected_page);
                                                            alert(data.status_message);
                                                        }, 'json');
                                                    }
                                                );
                                            }

                                        });
                                        <?
                                        }
                                        ?>

                                    </script>
                                    <?
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <?
    }

    function history_kelas_load()
    {
        $id = addslashes($_GET['id']);
        $guru = new SempoaGuruModel();
        $guru->getByID($id);
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;
        $kelas = new KelasWebModel();
        $arrKelas = $kelas->getWhere("guru_id = '$id' ORDER by id_kelas DESC LIMIT $begin, $limit");
        $jumlahTotal = $kelas->getJumlah("guru_id = '$id' ORDER by id_kelas DESC");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);

        foreach ($arrKelas as $kls) {
            $once = false;
            $tgl_help = "";
            $muridKelas = new MuridKelasMatrix();
            $arrMurid = $muridKelas->getWhere("kelas_id='$kls->id_kelas' AND guru_id='$id'");
            foreach ($arrMurid as $murid) {
                ?>
                <tr>
                    <td>
                        <?
                        $hari = Generic::getWeekDay()[$kls->hari_kelas];
                        $mulai = date("h:i", strtotime($kls->jam_mulai_kelas));
                        $akhir = date("h:i", strtotime($kls->jam_akhir_kelas));

                        $tgl = $hari . ", " . $mulai . " - " . $akhir;

                        if (!($once)) {
                            echo $tgl;
                            //$once = true;
                        }
                        ?>

                    </td>
                    <td>
                        <?
                        if (!($once)) {
                            echo Generic::getLevelNameByID($kls->level);
                            $once = true;
                        }
                        ?>
                    </td>
                    <td>
                        <?= Generic::getMuridNamebyID($murid->murid_id); ?>
                    </td>
                    <td>
                        <?= Generic::getLevelNameByID($murid->level_murid); ?>
                    </td>
                    <td>
                        <?
                        if ($murid->active_status == 1)
                            echo KEY::$AKTIV;
                        else
                            echo KEY::$NON_AKTIV;
                        ?>
                    </td>
                    <td>
                        <?= $murid->active_date; ?>
                    </td>
                    <td>
                        <?
                        if ($murid->nonactive_date == KEY::$TGL_KOSONG) {
                            echo KEY::$AKTIV;
                        } else {
                            echo $murid->nonactive_date;
                        }
                        ?>
                    </td>
                </tr>
                <?
            }
        }
    }

    function guru_absensi()
    {
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;
        $id = addslashes($_GET['id']);
        $guru = new SempoaGuruModel();
        $guru->getByID($id);
        $objAbsen = new AbsenGuruModel();
//          $objAbsen->absen_murid_id
        $arrAbsen = $objAbsen->getWhere("absen_guru_id='$id' ORDER BY absen_date DESC LIMIT $begin,$limit");
        $jumlahTotal = $objAbsen->getJumlah("absen_guru_id='$id'");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $t = time();
        ?>
        <section class="content-header">
            <h1>
                <div class="pull-right">
                    <button class="btn btn-default" onclick="back_to_profile_guru('<?= $id; ?>');">back to profile
                    </button>
                </div>
                Absensi <?= $guru->nama_guru; ?>
            </h1>

        </section>

        <section class="content">
            <div class="table-responsive">
                <table class="table table-striped ">
                    <thead>
                    <tr>
                        <th>
                            Tanggal
                        </th>
                        <th>
                            Kelas
                        </th>

                        <th>
                            Pengabsen
                        </th>
                    </tr>
                    </thead>
                    <tbody id="container_load_absen_guru">
                    <?
                    foreach ($arrAbsen as $absen) {
                        ?>
                        <tr>
                            <td><?= $absen->absen_reg_date; ?></td>
                            <td><?= Generic::printerKelas($absen->absen_kelas_id); ?></td>
                            <td><?
                                $acc = new Account();
                                $acc->getByID($absen->absen_pengabsen_id);
                                echo $acc->admin_nama_depan;
                                ?></td>
                        </tr>
                        <?
                    }
                    ?>

                    </tbody>
                    <script>
                    </script>
                </table>
            </div>
            <div class="text-center">
                <button class="btn btn-default" id="loadmore_absen_guru_<?= $t; ?>">Load more</button>
            </div>
            <script>
                var page_absen = <?= $page; ?>;
                var total_page_absen = <?= $jumlahHalamanTotal; ?>;
                $('#loadmore_absen_guru_<?= $t; ?>').click(function () {
                    if (page_absen < total_page_absen) {
                        page_absen++;
                        $.get("<?= _SPPATH; ?>GuruWebHelper/guru_absensi_load?id=<?= $id; ?>&page=" + page_absen, function (data) {
                            $("#container_load_absen_guru").append(data);
                        });
                        if (page_absen > total_page_absen)
                            $('#loadmore_absen_guru_<?= $t; ?>').hide();
                    } else {
                        $('#loadmore_absen_guru_<?= $t; ?>').hide();
                    }
                });
            </script>
        </section>
        <?
    }

    function guru_absensi_load()
    {
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;
        $id = addslashes($_GET['id']);
        $guru = new SempoaGuruModel();
        $guru->getByID($id);
        $objAbsen = new AbsenGuruModel();
//          $objAbsen->absen_murid_id
        $arrAbsen = $objAbsen->getWhere("absen_guru_id='$id' ORDER BY absen_date DESC LIMIT $begin,$limit");
        $jumlahTotal = $objAbsen->getJumlah("absen_guru_id='$id'");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $t = time();
        foreach ($arrAbsen as $absen) {
            ?>
            <tr>
                <td><?= $absen->absen_reg_date; ?></td>
                <td><?= Generic::printerKelas($absen->absen_kelas_id); ?></td>
                <td><?
                    $acc = new Account();
                    $acc->getByID($absen->absen_pengabsen_id);
                    echo $acc->admin_nama_depan;
                    ?></td>
            </tr>
            <?
        }
    }

    function guru_kelas()
    {
        $myType = AccessRight::getMyOrgType();
        $id = addslashes($_GET['id']);
        $tc_id = AccessRight::getMyOrgID();
        $guru = new SempoaGuruModel();
        $guru->getByID($id);

        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;

        $kelas = new KelasWebModel();
        $arrKelas = $kelas->getWhere("guru_id = '$id' LIMIT $begin, $limit");
        $arrHari = Generic::getWeekDay();
        $jumlahTotal = $kelas->getJumlah("guru_id = '$id' ");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $t = time();
        ?>
        <section class="content-header">
            <h1>
                <div class="pull-right">
                    <button class="btn btn-default" onclick="back_to_profile_guru('<?= $id; ?>');">back to profile
                    </button>
                </div>
                Kelas <?= $guru->nama_guru; ?>
            </h1>

        </section>

        <section class="content">
            <div class="table-responsive">
                <table class="table table-striped ">
                    <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Akhir</th>
                        <th>Ruangan</th>
                        <th>Level</th>
                    </tr>
                    </thead>
                    <tbody id="container_load_kelas_guru">
                    <?
                    foreach ($arrKelas as $kls) {
                        ?>
                        <tr>
                            <td>
                                <?= $arrHari[$kls->hari_kelas]; ?>
                            </td>
                            <td><?= $kls->jam_mulai_kelas; ?></td>
                            <td><?= $kls->jam_akhir_kelas; ?></td>
                            <td><?= $kls->id_room; ?></td>
                            <td><?= Generic::getLevelNameByID($kls->level); ?></td>
                        </tr>
                        <?
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <button class="btn btn-default" id="loadmore_kelas_guru_<?= $t; ?>">Load more</button>
            </div>
            <script>
                var page_kelas_guru = <?= $page; ?>;
                var total_page_kelas_guru = <?= $jumlahHalamanTotal; ?>;
                $('#loadmore_kelas_guru_<?= $t; ?>').click(function () {
                    if (page_kelas_guru < total_page_kelas_guru) {
                        page_kelas_guru++;
                        $.get("<?= _SPPATH; ?>GuruWebHelper/guru_kelas_load?id=<?= $id; ?>&page=" + page_kelas_guru, function (data) {
                            $("#container_load_kelas_guru").append(data);
                        });
                        if (page_kelas_guru > total_page_kelas_guru)
                            $('#loadmore_kelas_guru_<?= $t; ?>').hide();
                    } else {
                        $('#loadmore_kelas_guru_<?= $t; ?>').hide();
                    }
                });
            </script>
        </section>
        <?
    }

    function guru_kelas_load()
    {
        $id = addslashes($_GET['id']);
        $tc_id = AccessRight::getMyOrgID();
        $guru = new SempoaGuruModel();
        $guru->getByID($id);

        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;

        $kelas = new KelasWebModel();
        $arrKelas = $kelas->getWhere("guru_id = '$id'  LIMIT $begin, $limit");
        $arrHari = Generic::getWeekDay();
        $jumlahTotal = $kelas->getJumlah("guru_id = '$id' ");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $t = time();

        foreach ($arrKelas as $kls) {
            ?>
            <tr>
                <td>
                    <?= $arrHari[$kls->hari_kelas]; ?>
                </td>
                <td><?= $kls->jam_mulai_kelas; ?></td>
                <td><?= $kls->jam_akhir_kelas; ?></td>
                <td><?= $kls->id_room; ?></td>
                <td><?= Generic::getLevelNameByID($kls->level); ?></td>
            </tr>
            <?
        }
    }

    static function tableAbsensiGuru($objAbsen, $arrAbsen, $tc_id, $t)
    {
        ?>
        <section class="content">
            <div class="table-responsive">
                <table class="table table-striped ">
                    <thead>
                    <tr>

                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                    </tr>
                    </thead>

                    <tbody id="container_absensi_<?= $t; ?>">
                    <?
                    foreach ($arrAbsen as $abs) {
                        $arrAbsen2 = $objAbsen->getWhere("absen_tc_id='$tc_id' AND absen_date = '$abs->absen_date'");
                        $once = false;
                        foreach ($arrAbsen2 as $abs2) {
                        if (!($once)) {

                        if ($abs2->absen_date != $date_help) {
                            $date_help = $abs2->absen_date;
                            $once = true;
                            ?>
                            <tr>
                                <td onclick="buka('<?= $abs2->absen_date; ?>');">
                                    <?= $abs2->absen_date; ?>
                                    <span class="caret" style="cursor: pointer;"></span>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                            </tr>
                        <? ?>

                        <?
                        }
                        }
                        ?>

                            <tr>
                                <td class="bawah<?= $abs2->absen_date; ?>" style="visibility:hidden;display: none">

                                </td>
                                <td class="bawah<?= $abs2->absen_date; ?>" style="visibility:hidden;display: none">
                                    <?= Generic::getGuruNamebyID($abs2->absen_guru_id); ?>
                                </td>
                                <td class="bawah<?= $abs2->absen_date; ?>" style="visibility:hidden;display: none">
                                    <?
                                    $kelas = new KelasWebModel();
                                    $kelas->getWhereOne("id_kelas= '$abs2->absen_kelas_id'");
                                    echo Generic::getWeekDay()[$kelas->hari_kelas] . ", " . date("h:i", strtotime($kelas->jam_mulai_kelas)) . " - " . date("h:i", strtotime($kelas->jam_akhir_kelas));
                                    ?>
                                </td>

                            </tr>
                            <script>
                                var openPO_id = 0;
                                var listOpen = [];
                                function buka(date) {
                                    var pos = jQuery.inArray(date, listOpen);
                                    console.log(pos);
                                    if (pos == -1) {
                                        $(".bawah" + date).removeAttr("style");

                                        listOpen.push(date);
                                    } else {
                                        console.log("masuk");
                                        $(".bawah" + date).css("visibility", "hidden");
                                        $(".bawah" + date).css("display", "none");


                                        listOpen.pop(date);
                                        //
                                    }


                                }
                            </script>
                            <?
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </section>

        <style>

            .caret {
                display: inline-block;
                width: 0;
                height: 0;
                margin-left: 2px;
                vertical-align: middle;
                border-top: 4px solid;
                border-right: 4px solid transparent;
                border-left: 4px solid transparent;
            }
        </style>
        <?
    }

    function viewGuruTC()
    {
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;
        $tcid = (isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC));
        $obj = new SempoaGuruModel();

        $arrGuru = $obj->getWhere("guru_tc_id='$tcid' LIMIT $begin, $limit");
        $jumlahTotal = $obj->getJumlah("guru_tc_id='$tcid'");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $t = time();
        ?>
        <div class="table-responsive">
            <table class='table table-bordered table-striped '>
                <thead>
                <tr>

                    <th>Kode Guru</th>
                    <th>Nama Guru</th>
                    <th>Jenis Kelamin</th>
                    <th>Level</th>
                    <th>Profile</th>
                </tr>
                </thead>
                <tbody id="container_load_guru">
                <?
                foreach ($arrGuru as $key => $guru) {
                    ?>
                    <tr id='<?= $guru->guru_id; ?>'>

                        <td>
                            <?= $guru->kode_guru ?>
                        </td>
                        <td>
                            <?= $guru->nama_guru ?>
                        </td>
                        <td>
                            <?
                            if ($guru->jenis_kelamin == 'm')
                                echo "Male";
                            else
                                echo "Female";
                            ?>
                        </td>
                        <td>
                            <?= Generic::getLevelNameByID($guru->id_level_training_guru); ?>
                        </td>
                        <td>
                            <button
                                onclick="openLw('Profile_Guru', '<?= _SPPATH; ?>GuruWebHelper/guru_profile?guru_id=<?= $guru->guru_id; ?>', 'fade');">
                                Profile
                            </button>
                        </td>
                    </tr>
                    <?
                }
                ?>
                </tbody>
            </table>
        </div>

        <div class="text-center">
            <button class="btn btn-default" id="loadmore_guru_<?= $t; ?>">Load more</button>
        </div>
        <script>
            var page_guru = <?= $page; ?>;
            var total_guru = <?= $jumlahHalamanTotal; ?>;
            $('#loadmore_guru_<?= $t; ?>').click(function () {
                if (page_guru < total_guru) {
                    page_guru++;
                    $.get("<?= _SPPATH; ?>GuruWebHelper/guru_tc_load?tc_id=<?= $tcid; ?>&page=" + page_guru, function (data) {
                        $("#container_load_guru").append(data);
                    });
                    if (page_guru > total_guru)
                        $('#loadmore_guru_<?= $t; ?>').hide();
                } else {
                    $('#loadmore_guru_<?= $t; ?>').hide();
                }
            });
        </script>
        <?
    }

    function guru_tc_load()
    {
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;
        $tcid = (isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC));
        $obj = new SempoaGuruModel();

        $arrGuru = $obj->getWhere("guru_tc_id='$tcid' LIMIT $begin, $limit");
        $jumlahTotal = $obj->getJumlah("guru_tc_id='$tcid'");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $t = time();

        foreach ($arrGuru as $key => $guru) {
            ?>
            <tr id='<?= $guru->guru_id; ?>'>

                <td>
                    <?= $guru->kode_guru ?>
                </td>
                <td>
                    <?= $guru->nama_guru ?>
                </td>
                <td>
                    <?
                    if ($guru->jenis_kelamin == 'm')
                        echo "Male";
                    else
                        echo "Female";
                    ?>
                </td>
                <td>
                    <?= Generic::getLevelNameByID($guru->id_level_training_guru); ?>
                </td>
                <td>
                    <button
                        onclick="openLw('Profile_Guru', '<?= _SPPATH; ?>GuruWebHelper/guru_profile?guru_id=<?= $guru->guru_id; ?>', 'fade');">
                        Profile
                    </button>
                </td>
            </tr>
            <?
        }
    }

    function getAbsensiGuruByMonth()
    {
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $org = addslashes($_GET['org']);
        if ($org == "tc") {
            $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : AccessRight::getMyOrgID();
        } elseif ($org == "ibo") {
            $arrMyTC = Generic::getAllMyTC(AccessRight::getMyOrgID());
            $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC);
        }
//        pr($tc_id);
        $t = time();
        $arrBulan = Generic::getAllMonths();
        $absen = new AbsenGuruModel();
        $arrAbsen = $absen->getWhere("absen_tc_id='$tc_id' AND (Month(absen_date)= $bln) AND (YEAR(absen_date)=$thn)  Group BY absen_date ");
        foreach ($arrAbsen as $abs) {
//            pr($abs->absen_date);
            $arrAbsen2 = $absen->getWhere("absen_tc_id='$tc_id' AND absen_date = '$abs->absen_date'");
//            pr(count($arrAbsen2));
            $once = false;
            foreach ($arrAbsen2 as $abs2) {
//                pr($abs2->absen_kelas_id);
                if (!($once)) {

                    if ($abs2->absen_date != $date_help) {

                        $date_help = $abs2->absen_date;
                        $once = true;
                        ?>
                        <tr>
                            <td onclick="buka('<?= $abs2->absen_date; ?>');">
                                <?= $abs2->absen_date; ?>
                                <span class="caret" style="cursor: pointer;"></span>
                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                        </tr>
                        <? ?>

                        <?
                    }
                }
                ?>

                <tr>
                    <td class="bawah<?= $abs2->absen_date; ?>" style="visibility:hidden;display: none">

                    </td>
                    <td class="bawah<?= $abs2->absen_date; ?>" style="visibility:hidden;display: none">
                        <?= Generic::getGuruNamebyID($abs2->absen_guru_id); ?>
                    </td>
                    <td class="bawah<?= $abs2->absen_date; ?>" style="visibility:hidden;display: none">
                        <?
                        $kelas = new KelasWebModel();
                        $kelas->getWhereOne("id_kelas= '$abs2->absen_kelas_id'");
                        //                        pr($kelas->id_kelas);
                        echo Generic::getWeekDay()[$kelas->hari_kelas] . ", " . date("h:i", strtotime($kelas->jam_mulai_kelas)) . " - " . date("h:i", strtotime($kelas->jam_akhir_kelas));
                        ?>
                    </td>

                </tr>

                <?
            }
        }
    }

    static function tableJMGuru()
    {
        ?>
        <section class="content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>
                            Hari dan Jam
                        </th>
                        <th>
                            Ruang
                        </th>
                        <th>
                            Level
                        </th>

                        <th>
                            Murid
                        </th>

                    </tr>
                    </thead>
                    <tbody id="container_jw_guru">
                    <?
                    foreach ($arrKelas as $kls) {
                        ?>
                        <tr>
                            <td>
                                <?= Generic::getWeekDay()[$kls->hari_kelas] . ", " . date("h:i", strtotime($kls->jam_mulai_kelas)); ?>
                                - <?= date("h:i", strtotime($kls->jam_akhir_kelas));
                                ?>
                            </td>
                            <td>
                                <?= $kls->id_room; ?>
                            </td>
                            <td>
                                <?= Generic::getLevelNameByID($kls->level); ?>
                            </td>
                            <td>
                                <?
                                $mk = new MuridKelasMatrix();
                                $arrMurid = $mk->getWhere("kelas_id='$kls->id_kelas' AND active_status=1");
                                //                    pr($arrMurid);
                                if (count($arrMurid) > 0) {
                                    foreach ($arrMurid as $murid) {
                                        if ($murid->murid_id != "") {
                                            echo Generic::getMuridNamebyID($murid->murid_id) . "<br>";
                                        }
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </section>

        <?
    }

    public function getjwgurubyid()
    {
        $id_guru = addslashes($_GET['id_guru']);
        $kelas = new KelasWebModel();
        $arrKelas = $kelas->getWhere("guru_id='$id_guru' ");

        foreach ($arrKelas as $kls) {
            ?>
            <tr>
                <td>
                    <?= Generic::getWeekDay()[$kls->hari_kelas] . ", " . date("h:i", strtotime($kls->jam_mulai_kelas)); ?>
                    - <?= date("h:i", strtotime($kls->jam_akhir_kelas));
                    ?>
                </td>
                <td>
                    <?= $kls->id_room; ?>
                </td>
                <td>
                    <?= Generic::getLevelNameByID($kls->level); ?>
                </td>
                <td>
                    <?
                    $mk = new MuridKelasMatrix();
                    $arrMurid = $mk->getWhere("kelas_id='$kls->id_kelas' AND active_status=1");
                    if (count($arrMurid) > 0) {
                        foreach ($arrMurid as $murid) {
                            if ($murid->murid_id != "") {
                                echo Generic::getMuridNamebyID($murid->murid_id) . "<br>";
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
            <?
        }

//        pr($arrKelas);
    }

    public function getgurubyTC()
    {
        $tc_id = addslashes($_POST['tc_id']);
        $guru = new SempoaGuruModel();
        $arrGuru = $guru->getWhere("guru_tc_id='$tc_id' AND status=1");
        $t = time();
        $guruHlp = array();
        ?>
        <select id="guru_<?= $t; ?>">
            <?
            foreach ($arrGuru as $key => $val) {
                ?>
                <option value="<?= $val->guru_id; ?>"><?= $val->nama_guru; ?></option>
                <?
            }
            ?>
        </select>


        <?
    }

    public function guru_invoices()
    {
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;
        $id = addslashes($_GET['id']);
        $guru = new SempoaGuruModel();
        $guru->getByID($id);
        $objInvoices = new TransaksiTrainingModel();
//        $objInvoices->tr_guru_id
//          $objAbsen->absen_murid_id
        $arrInvoices = $objInvoices->getWhere("tr_guru_id='$id' ORDER BY tr_date DESC LIMIT $begin,$limit");
        $jumlahTotal = $objInvoices->getJumlah("tr_guru_id='$id'");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $t = time();
        ?>
        <section class="content-header">
            <h1>
                <div class="pull-right">
                    <button class="btn btn-default" onclick="back_to_profile_guru('<?= $id; ?>');">back to profile
                    </button>
                </div>
                Invoices Training <?= $guru->nama_guru; ?>
            </h1>

        </section>

        <section class="content">
            <div class="table-responsive">
                <table class="table table-striped ">
                    <thead>
                    <tr>
                        <th>
                            Tanggal
                        </th>
                        <th>
                            Level
                        </th>

                        <th>
                            Status
                        </th>
                    </tr>
                    </thead>
                    <tbody id="container_load_invoices_guru">
                    <?
                    $arrStatus = Generic::getStatusTrainer();
                    foreach ($arrInvoices as $inv) {
//                            pr($inv);
                        ?>
                        <tr>
                            <td id="date_<?= $inv->tr_id; ?>"><?= $inv->tr_date; ?></td>
                            <td><?= Generic::getLevelNameByID(Generic::getTrainingLevel($inv->tr_tr_id)); ?></td>
                            <td><?
                                echo $arrStatus[$inv->tr_status];
                                ?>
                            </td>
                        </tr>
                        <script>
                            $('#payNow_tr_<?= $inv->tr_id; ?>').click(function () {
                                var tr_id = <?= $inv->tr_id; ?>;
                                $.post("<?= _SPPATH; ?>GuruWebHelper/update_iuran_transaksi", {
                                    tr_id: tr_id
                                }, function (data) {
                                    console.log(data);
                                    alert(data.status_message);
                                    if (data.status_code) {
                                        lwrefresh(selected_page);
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
                <button class="btn btn-default" id="loadmore_inv_guru_<?= $t; ?>">Load more</button>
            </div>
            <script>
                var page_inv = <?= $page; ?>;
                var total_page_inv = <?= $jumlahHalamanTotal; ?>;
                $('#loadmore_inv_guru_<?= $t; ?>').click(function () {
                    if (page_inv < total_page_inv) {
                        page_inv++;
                        $.get("<?= _SPPATH; ?>GuruWebHelper/guru_invoices_load?id=<?= $id; ?>&page=" + page_inv, function (data) {
                            $("#container_load_invoices_guru").append(data);
                        });
                        if (page_inv > total_page_inv)
                            $('#loadmore_inv_guru_<?= $t; ?>').hide();
                    } else {
                        $('#loadmore_inv_guru_<?= $t; ?>').hide();
                    }
                });
            </script>
        </section>
        <?
    }

    public function guru_invoices_load()
    {
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PROFILE;
        $begin = ($page - 1) * $limit;
        $id = addslashes($_GET['id']);
        $guru = new SempoaGuruModel();
        $guru->getByID($id);
        $objInvoices = new TransaksiTrainingModel();
//        $objInvoices->tr_guru_id
//          $objAbsen->absen_murid_id
        $arrInvoices = $objInvoices->getWhere("tr_guru_id='$id' ORDER BY tr_date DESC LIMIT $begin,$limit");
        $jumlahTotal = $objInvoices->getJumlah("tr_guru_id='$id'");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $t = time();
        $arrStatus = Generic::getStatusTrainer();
        foreach ($arrInvoices as $inv) {
//                            pr($inv);
            ?>
            <tr>
                <td id="date_<?= $inv->tr_id; ?>"><?= $inv->tr_date; ?></td>
                <td><?= Generic::getLevelNameByID(Generic::getTrainingLevel($inv->tr_tr_id)); ?></td>
                <td><?
                    if ($inv->tr_status == 1) {
                        echo $arrStatus[$inv->tr_status];
                    } else {
                        ?>
                        <button id="payNow_tr_<?= $inv->tr_id; ?>" class="btn btn-default">Pay Now</button>
                        <?
                    }
                    ?>
                </td>
            </tr>
            <script>
                $('#payNow_tr_<?= $inv->tr_id; ?>').click(function () {
                    var tr_id = <?= $inv->tr_id; ?>;
                    $.post("<?= _SPPATH; ?>GuruWebHelper/update_iuran_transaksi", {
                        tr_id: tr_id
                    }, function (data) {
                        console.log(data);
                        alert(data.status_message);
                        if (data.status_code) {
                            lwrefresh(selected_page);
                        }
                    }, 'json');
                });
            </script>
            <?
        }
    }

    public function update_iuran_transaksi()
    {
        $tr_id = addslashes($_POST['tr_id']);
        $transaksi = new TransaksiTrainingModel();
        $transaksi->getByID($tr_id);
        $transaksi->tr_date = leap_mysqldate();
        $transaksi->tr_status = 1;
        $update = $transaksi->save(1);
        if ($update) {
            $this->pembukuan_trainer($tr_id);
            $json['status_code'] = 1;
            $json['status_message'] = "Pembayaran berhasil!";
            echo json_encode($json);
            die();
        }

        $json['status_code'] = 0;
        $json['status_message'] = "Pembayaran gagal!";
        echo json_encode($json);
        die();
    }

    public function pembukuan_trainer($tr_id, $tm_id, $guru_id, $status)
    {

        $transaksi = new TransaksiTrainingModel();
        $transaksi->getWhereOne("tr_id='$tr_id'");
        $tm = new TrainingMatrixModel();
        $tm->getByID($tm_id);


        if (AccessRight::getMyOrgType() == KEY::$KPO) {
            $peminta = Generic::getTCNamebyID($transaksi->tr_request_id);
            $peminta = $peminta . " mengirimkan Trainer " . Generic::getTrainerNamebyID($guru_id) . " untuk mendapat pelatihan";
            $pemilik = Generic::getTCNamebyID($transaksi->tr_owner_id);
            $pemilik = $peminta;
            if ($status == KEY::$STATUS_DISCOUNT_100) {
                Generic::createLaporanDebet($transaksi->tr_owner_id, $transaksi->tr_owner_id, KEY::$DEBET_TRAINING_TRAINER_KPO, $transaksi->tr_harga_id, $pemilik, 0, 0, "Discount100");
                Generic::createLaporanKredit($transaksi->tr_request_id, $transaksi->tr_owner_id, KEY::$KREDIT_TRAINING_TRAINER_IBO, $transaksi->tr_harga_id, $peminta, 0,0, "Discount100");
            } else {
                Generic::createLaporanDebet($transaksi->tr_owner_id, $transaksi->tr_owner_id, KEY::$DEBET_TRAINING_TRAINER_KPO, $transaksi->tr_harga_id, $pemilik, $transaksi->tr_harga_id, 0, "Training");
                Generic::createLaporanKredit($transaksi->tr_request_id, $transaksi->tr_owner_id, KEY::$KREDIT_TRAINING_TRAINER_IBO, $transaksi->tr_harga_id, $peminta, $transaksi->tr_harga_id, 0, "Training");
            }

        } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {
            // $peminta = 4, tr_request_id =
            $peminta = Generic::getTCNamebyID($transaksi->tr_request_id);
            $peminta = $peminta . " mengirimkan Guru " . Generic::getGuruNamebyID($guru_id) . " untuk mendapat pelatihan";
            $pemilik = Generic::getTCNamebyID($transaksi->tr_owner_id);
            $pemilik = $peminta;
            if ($status == KEY::$STATUS_DISCOUNT_100) {
                Generic::createLaporanDebet($transaksi->tr_owner_id, $transaksi->tr_owner_id, KEY::$DEBET_TRAINING_GURU_IBO, $transaksi->tr_harga_id, $pemilik, 0, 0, "Discount100");
                Generic::createLaporanKredit($transaksi->tr_request_id, $transaksi->tr_owner_id, KEY::$KREDIT_TRAINING_GURU_TC, $transaksi->tr_harga_id, $peminta, 0, 0, "Discount100");
            } else {
                // owner 3, request =>4, harga 5 juta
                Generic::createLaporanDebet($transaksi->tr_owner_id, $transaksi->tr_request_id, KEY::$DEBET_TRAINING_GURU_IBO, $transaksi->tr_harga_id, $peminta, $transaksi->tr_harga_id, 0, "Training");
                Generic::createLaporanKredit($transaksi->tr_request_id, $transaksi->tr_owner_id, KEY::$KREDIT_TRAINING_GURU_TC, $transaksi->tr_harga_id, $peminta, $transaksi->tr_harga_id, 0, "Training");
            }

        }
    }

    public function first_register()
    {
        $guru_id = addslashes($_GET['id_guru']);
        $tc_id = addslashes($_GET['tc_id']);
        $guru = new SempoaGuruModel();
        $guru->getByID($guru_id);
        $reg = new RegisterGuru();
        $reg->getWhereOne("transaksi_guru_id=$guru_id");
//        pr($tc_id);
        ?>
        <h1 style="text-align: center;">Payment For <?= $guru->nama_guru; ?></h1>

        <h3>Daftar Pembayaran Pertama Kali</h3>

        <table width="100%" class="table table-hover">
            <tr>
                <td>Biaya Registrasi:</td>
                <td style="text-align: right;">IDR <?= idr($reg->transaksi_jumlah); ?></td>
            </tr>

        </table>
        <button id="payfirst_button_guru" class="btn btn-lg btn-danger" style="width: 100%;">SUBMIT</button>
        <script>
            $('#payfirst_button_guru').click(function () {
                if (confirm("Anda yakin akan melakukan pembayaran?")) {
                    var post = {};
                    post.id_guru = '<?= $guru_id; ?>';
                    post.tc_id = '<?= $tc_id; ?>';
                    $.post("<?= _SPPATH; ?>GuruWebHelper/payment_register",
                        post,
                        function (data) {
                            if (data.status_code) {
                                alert(data.status_message);
                                //                                    alert(data.buku);
                                openLw('read_guru_ibo', '<?= _SPPATH; ?>GuruWeb/read_guru_ibo?t=' + $.now(), 'fade');
                            } else {
                                alert(data.status_message);
                            }
                        }, 'json');
                }
            })
        </script>
        <?
        die();
    }

    public function payment_register()
    {
        $guru_id = addslashes($_POST['id_guru']);
        $tc_id = addslashes($_POST['tc_id']);
        $reg = new RegisterGuru();
        $reg->getWhereOne("transaksi_guru_id=$guru_id");
        if ($reg->transaksi_status == 1) {
            $json['status_code'] = 0;
            $json['status_message'] = "Transaksi sudah di bayar!";
            echo json_encode($json);
            die();
        }
        $guru = new SempoaGuruModel();
        $guru->getByID($guru_id);
        $guru->guru_first_register = 1;
        $guru->status = KEY::$STATUSGURUNONQUALIFIED;
        if ($guru->save(1)) {


            if (AccessRight::getMyOrgType() == KEY::$IBO) {
                Generic::createLaporanDebet(AccessRight::getMyOrgID(), AccessRight::getMyOrgID(), KEY::$DEBET_REGISTRASI_GURU_TC, KEY::$PENDAFTARAN_GURU, "Registrasi: Guru: " . Generic::getGuruNamebyID($guru_id), 1, 0, "Utama");
            } elseif (AccessRight::getMyOrgType() == KEY::$TC) {
                Generic::createLaporanDebet(Generic::getMyParentID(AccessRight::getMyOrgID()), AccessRight::getMyOrgID(), KEY::$DEBET_REGISTRASI_GURU_TC, KEY::$BIAYA_PENDAFTARAN_GURU, "Registrasi: Guru: " . Generic::getGuruNamebyID($guru_id), 1, 0, "Utama");
            }
            Generic::createLaporanKredit($guru->guru_tc_id, $guru->guru_tc_id, KEY::$KREDIT_REGISTRASI_GURU_TC, KEY::$BIAYA_PENDAFTARAN_GURU, "Registrasi: Guru: " . Generic::getGuruNamebyID($guru_id), 1, 0, "Utama");

            $reg->transaksi_status = 1;
            $reg->save(1);
            $json['status_code'] = 1;
            $json['status_message'] = "Payment Entry Success";
            echo json_encode($json);
            die();
        }
        $json['status_code'] = 0;
        $json['status_message'] = "Gagal";
        echo json_encode($json);
        die();
    }

    public function setStatusFirstRegisterGuru()
    {
        $guru_id = addslashes($_GET['guru_id']);
        $tr_id = addslashes($_GET['tr_id']);

        $objRegisterGuru = new RegisterGuru();
        $objRegisterGuru->getWhereOne("transaksi_guru_id=$guru_id AND transaksi_id= $tr_id");
        $objRegisterGuru->getWhereOne("tr_tr_id='$tr_id' AND tr_guru_id='$guru_id'");
        $objRegisterGuru->transaksi_date = leap_mysqldate();
        $objRegisterGuru->transaksi_status = 1;
        $update = $objRegisterGuru->save(1);
        if ($update) {
//            $help = new GuruWebHelper();
//            $help->pembukuan_trainer($tr_id, $tm_id);
            $guru = new SempoaGuruModel();
            $guru->getByID($guru_id);
            $guru->guru_first_register = 1;
            $guru->status = KEY::$STATUSGURUNONQUALIFIED;
            $guru->save(1);
            Generic::createLaporanDebet($guru->guru_tc_id, AccessRight::getMyOrgID(), KEY::$DEBET_REGISTRASI_GURU_TC, KEY::$PENDAFTARAN_GURU, "Registrasi: Guru: " . Generic::getGuruNamebyID($guru_id), 1, 0, "Utama");
            Generic::createLaporanKredit($objRegisterGuru->transaksi_tc_id, AccessRight::getMyOrgID(), KEY::$KREDIT_REGISTRASI_GURU_TC, KEY::$BIAYA_PENDAFTARAN_GURU, "Registrasi: Guru: " . Generic::getGuruNamebyID($guru_id), 1, 0, "Utama");

            $json['status_code'] = 1;
            $json['status_message'] = "Status di Update";
            echo json_encode($json);
            die();
        }
        $json['status_code'] = 0;
        $json['status_message'] = "Update Gagal!";
        echo json_encode($json);
        die();
    }

    public function read_guru_tc_page()
    {
        $myOrgID = (AccessRight::getMyOrgID());
        $t = time();
        $obj = new SempoaGuruModel();

        $arrStatusGuru = Generic::getAllStatusGuru();
        $arrLevel = Generic::getAllLevel();
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = 20;
        $begin = ($page - 1) * $limit;
        $status = isset($_GET['status']) ? addslashes($_GET['status']) : 1;
        $arrGuru = $obj->getWhere("guru_tc_id=$myOrgID AND status=$status ORDER BY nama_guru ASC  LIMIT $begin, $limit");
        $jumlahTotal = $obj->getJumlah("guru_tc_id=$myOrgID AND status=$status");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $index = (($page - 1) * 20) + 1;
        $return['classname'] = __FUNCTION__;
        $return['page'] = $page;
        $return['totalpage'] = $jumlahHalamanTotal;
        $return['perpage'] = $limit;
        $return['status'] = $status;
        ?>
        <div id="content_load_guru_<?= $t; ?>">
            <section class="content-header">
                <div class="box-tools pull-right">

                    <label for="exampleInputName2">Status:</label>
                    <select id="pilih_status_<?= $t; ?>">

                        <?
                        foreach ($arrStatusGuru as $key => $val) {
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
                    <button id="submit_status_guru_<?= $t; ?>">submit</button>
                    <script>
                        $('#submit_status_guru_<?= $t; ?>').click(function () {

                            var status = $('#pilih_status_<?= $t; ?>').val();
                            $('#content_load_guru_<?=$t;?>').load('<?= _SPPATH; ?>GuruWebHelper/read_guru_tc_page?status=' + status, function () {

                            }, 'json');
                        });

                    </script>
                </div>
            </section>
            <div class="clearfix"></div>
            <section class="content">
                <div>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Guru</th>
                            <th>Nama Guru</th>
                            <th>Status</th>
                            <th>Level Sekarang</th>
                            <th>Email</th>
                            <th>Profile</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        foreach ($arrGuru as $key => $valGuru) {
                            $k = $key + 1;
                            ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $valGuru->kode_guru; ?></td>
                                <td><?= $valGuru->nama_guru; ?></td>
                                <td><?= $arrStatusGuru[$valGuru->status]; ?></td>
                                <td><?= $arrLevel[$valGuru->id_level_training_guru]; ?></td>
                                <td><?= "<button onclick='window.location.href = \"mailto:" . $valGuru->email_guru . "\";'>Email</button>" ?></td>


                                <td><?
                                    echo "<button onclick=\"openLw('Profile_Guru','" . _SPPATH . "GuruWebHelper/guru_profile?guru_id=" . $valGuru->guru_id . "','fade');\">Profile</button>";
                                    ?></td>
                            </tr>
                            <?
                            $index++;
                        }
                        ?>
                        </tbody>
                        <tfoot>

                        </tfoot>

                    </table>
                    <?
                    $webClass = __CLASS__;
                    Generic::pagination($return, $webClass);

                    ?>
                </div>
            </section>
        </div>
        <?
    }

    public function read_guru_ibo_page()
    {
        $myOrgID = (AccessRight::getMyOrgID());
        $arrMyTC = Generic::getAllMyTC($myOrgID);
        $tcid = (isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC));
        $t = time();
        $obj = new SempoaGuruModel();

        $arrStatusGuru = Generic::getAllStatusGuru();
        $arrLevel = Generic::getAllLevel();
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = 20;
        $begin = ($page - 1) * $limit;
        $index = (($page - 1) * 20) + 1;
        $status = isset($_GET['status']) ? addslashes($_GET['status']) : 1;
        $arrGuru = $obj->getWhere("guru_tc_id=$tcid AND status=$status ORDER BY nama_guru ASC  LIMIT $begin, $limit");
        $jumlahTotal = $obj->getJumlah("guru_tc_id=$tcid AND status=$status");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);

        $return['classname'] = __FUNCTION__;
        $return['page'] = $page;
        $return['totalpage'] = $jumlahHalamanTotal;
        $return['perpage'] = $limit;
        $return['status'] = $status;
        $return['tc_id'] = $tcid;
        ?>
        <div id="content_load_guru_<?= $t; ?>">
            <section class="content-header">
                <div class="box-tools pull-right">

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
                        foreach ($arrStatusGuru as $key => $val) {
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
                    <button id="submit_status_guru_<?= $t; ?>">submit</button>
                    <script>
                        $('#submit_status_guru_<?= $t; ?>').click(function () {
                            var slc = $('#pilih_tc_<?= $t; ?>').val();
                            var status = $('#pilih_status_<?= $t; ?>').val();
                            $('#content_load_guru_<?=$t;?>').load('<?= _SPPATH; ?>GuruWebHelper/read_guru_ibo_page?tc_id=' + slc + '&status=' + status, function () {

                            }, 'json');
                        });

                    </script>
                </div>
            </section>
            <div class="clearfix"></div>
            <section class="content">
                <div>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Guru</th>
                            <th>Nama Guru</th>
                            <th>Status</th>
                            <th>Level Sekarang</th>
                            <th>Email</th>
                            <th>Profile</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        foreach ($arrGuru as $key => $valGuru) {
                            ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $valGuru->kode_guru; ?></td>
                                <td><?= $valGuru->nama_guru; ?></td>
                                <td><?= $arrStatusGuru[$valGuru->status]; ?></td>
                                <td><?= $arrLevel[$valGuru->id_level_training_guru]; ?></td>
                                <td><?= "<button onclick='window.location.href = \"mailto:" . $valGuru->email_guru . "\";'>Email</button>" ?></td>


                                <td><?
                                    echo "<button onclick=\"openLw('Profile_Guru','" . _SPPATH . "GuruWebHelper/guru_profile?guru_id=" . $valGuru->guru_id . "','fade');\">Profile</button>";
                                    ?></td>
                            </tr>
                            <?
                            $index++;
                        }
                        ?>
                        </tbody>
                        <tfoot>

                        </tfoot>

                    </table>
                    <?
                    $webClass = __CLASS__;
                    Generic::pagination($return, $webClass);

                    ?>
                </div>
            </section>
        </div>
        <?
    }

    public function read_guru_kpo_page()
    {
        $kpoID = AccessRight::getMyOrgID();
        $arrMyIBO = Generic::getAllMyIBO($kpoID);
        $iboID = (isset($_GET['ibo_id']) ? addslashes($_GET['ibo_id']) : key($arrMyIBO));

        $arrMyTC = Generic::getAllMyTC($iboID);
        $tcid = (isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC));
        $t = time();
        $obj = new SempoaGuruModel();

        $arrStatusGuru = Generic::getAllStatusGuru();
        $arrLevel = Generic::getAllLevel();
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = 20;
        $begin = ($page - 1) * $limit;
        $index = (($page - 1) * 20) + 1;
        $status = isset($_GET['status']) ? addslashes($_GET['status']) : 1;
        $arrGuru = $obj->getWhere("guru_tc_id=$tcid AND status=$status ORDER BY nama_guru ASC  LIMIT $begin, $limit");
        $jumlahTotal = $obj->getJumlah("guru_tc_id=$tcid AND status=$status");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);

        $return['classname'] = __FUNCTION__;
        $return['page'] = $page;
        $return['totalpage'] = $jumlahHalamanTotal;
        $return['perpage'] = $limit;
        $return['status'] = $status;
        $return['tc_id'] = $tcid;
        ?>
        <div id="content_load_guru_<?= $t; ?>">
            <section class="content-header">
                <div class="box-tools pull-right">

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
                            <option value="<?= $key; ?>" <?= $selected; ?>><?= $val; ?></option>
                            <?
                        }
                        ?>
                    </select>

                    <label for="exampleInputName2">Status:</label>
                    <select id="pilih_status_<?= $t; ?>">

                        <?
                        foreach ($arrStatusGuru as $key => $val) {
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
                    <button id="submit_status_guru_<?= $t; ?>">submit</button>
                    <script>
                        $('#submit_status_guru_<?= $t; ?>').click(function () {
                            var slc = $('#pilih_tc_<?= $t; ?>').val();
                            var status = $('#pilih_status_<?= $t; ?>').val();
                            $('#content_load_guru_<?=$t;?>').load('<?= _SPPATH; ?>GuruWebHelper/read_guru_kpo_page?tc_id=' + slc + '&status=' + status, function () {

                            }, 'json');
                        });

                    </script>
                </div>
            </section>
            <div class="clearfix"></div>
            <section class="content">
                <div>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Guru</th>
                            <th>Nama Guru</th>
                            <th>Status</th>
                            <th>Level Sekarang</th>
                            <th>Email</th>
                            <th>Profile</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        foreach ($arrGuru as $key => $valGuru) {
                            ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $valGuru->kode_guru; ?></td>
                                <td><?= $valGuru->nama_guru; ?></td>
                                <td><?= $arrStatusGuru[$valGuru->status]; ?></td>
                                <td><?= $arrLevel[$valGuru->id_level_training_guru]; ?></td>
                                <td><?= "<button onclick='window.location.href = \"mailto:" . $valGuru->email_guru . "\";'>Email</button>" ?></td>

                                <td><?
                                    echo "<button onclick=\"openLw('Profile_Guru','" . _SPPATH . "GuruWebHelper/guru_profile?guru_id=" . $valGuru->guru_id . "','fade');\">Profile</button>";
                                    ?></td>
                            </tr>
                            <?
                            $index++;
                        }
                        ?>
                        </tbody>
                        <tfoot>

                        </tfoot>

                    </table>
                    <?
                    $webClass = __CLASS__;
                    Generic::pagination($return, $webClass);

                    ?>
                </div>
            </section>
        </div>
        <?
    }
}
