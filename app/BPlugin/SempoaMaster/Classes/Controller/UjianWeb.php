<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UjianWeb
 *
 * @author efindiongso
 */
class UjianWeb extends WebService {

    public function lihat_peserta_lomba_ibo() {
        $objUjian = new UjianModel();
        $ibo_id = AccessRight::getMyOrgID();
        $today = date("d-m-Y", strtotime(now));
        $arrUjian = $objUjian->getWhere("ujian_ibo_id='$ibo_id' ORDER BY ujian_date DESC");
        $ujian_id = (isset($_GET['ujian_id']) ? addslashes($_GET['ujian_id']) : $arrUjian[0]->ujian_id);
        $t = time();
//        pr($_GET);
        ?>
        <section class="content-header">
            <h1>Peserta Ujian</h1>
            <div class="box-tools pull-right" >

                <label for="exampleInputName2">Ujian:</label>
                <select  id="pilih_perlombaan_<?= $t; ?>">

                    <?
                    foreach ($arrUjian as $key => $val) {
                        ?>
                        <option value="<?= $val->ujian_id; ?>"><?= date("d-M-Y", strtotime($val->ujian_date)) . ", " . Generic::getLevelNameByID($val->ujian_from_level) . "-" . Generic::getLevelNameByID($val->ujian_to_level); ?></option>
                        <?
                    }
                    ?>
                </select>

                <button  id="submit_pilih_perlombaan_<?= $t; ?>">Submit</button>
            </div>
            <script>
                $('#submit_pilih_perlombaan_<?= $t; ?>').click(function () {
                    var ujian_id = $('#pilih_perlombaan_<?= $t; ?>').val();
                    $('#content_perlombaan_<?= $t; ?>').load("<?= _SPPATH; ?>UjianWebHelper/loadPerlombaan?ujian_id=" + ujian_id + "&ibo_id=<?= $ibo_id; ?>", function () {
                    }, 'json');
                })
            </script>
        </section>
        <div class="clearfix"></div>
        <section class="content table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Murid</th>
                        <th>Ujian</th>
                        <th>Nilai</th>
                        <th>TC</th>
                    </tr>
                </thead>

                <tbody id ="content_perlombaan_<?= $t; ?>" >
                    <?
                    $nm = new MatrixNilaiModel();
                    $arrNilai = $nm->getWhere("mu_ujian_id='$ujian_id' AND mu_ibo_id='$ibo_id' AND mu_active_status=1 ORDER BY mu_nilai DESC,  mu_tc_id ASC");
                    foreach ($arrNilai as $key => $valNilai) {
                        ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td><?= Generic::getMuridNamebyID($valNilai->mu_murid_id); ?></td>
                            <td><?= $nm->getNamaUjian($valNilai->mu_ujian_id); ?></td>
                            <td id="nilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>"><?= $valNilai->mu_nilai; ?></td>
                            <td><?= Generic::getTCNamebyID($valNilai->mu_tc_id); ?></td>
                        </tr>
                    <script>
                        $('#nilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>').dblclick(function () {
                            var html = "<input  value=\"<?=$valNilai->mu_nilai;?>\" id='inputNilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>' type=\"number\" name=\"nilai\">";
                            $('#nilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>').html(html);

                            $('#inputNilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>').change(function () {
                                var current = $("#inputNilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>").val();

                                if (confirm("Nilai akan diinput?")) {
                                    //                                        alert(<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>);
                                    $.get("<?= _SPPATH; ?>UjianWebHelper/setnilai?id_murid=<?= $valNilai->mu_murid_id; ?>" + "&ujian_id=<?= $valNilai->mu_ujian_id; ?>&nilai=" + current, function (data) {
                                                        if (data.status_code) {
                                                            alert(data.status_message);
                                                            lwrefresh("lihat_peserta_lomba_ibo");
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
//  sdh tdk di pake
    public function read_jadwal_ujian_spt_tc() {
        $tc_id = AccessRight::getMyOrgID();
        $ibo_id = Generic::getMyParentID(AccessRight::getMyOrgID());
        $jdwlUjian = new UjianModel();
        $arrJdwlUjian = $jdwlUjian->getWhere("ujian_jenis=1 AND ujian_status=1 AND ujian_ibo_id = '$ibo_id' ORDER by ujian_date ASC");
        $arrLevel = Generic::getAllLevel();
        ?>
        <section class="content-header">
            <h1>Jadwal Ujian SPT</h1>
        </section>
        <section class="content">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal Ujian</th>
                            <th>Level Dari</th>
                            <th>Level Sampai</th>
                            <th>Murid</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach ($arrJdwlUjian as $ujian) {
                            ?>
                            <tr>
                                <td><?= date("d-m-Y", strtotime($ujian->ujian_date)); ?></td>
                                <td><?= $arrLevel[$ujian->ujian_from_level] ?></td>
                                <td><?= $arrLevel[$ujian->ujian_to_level] ?></td>
                                <td>
                                    <?
                                    $matrixUjian = new MatrixNilaiModel();
                                    $arrMatrixUjian = $matrixUjian->getWhere("mu_ujian_id='$ujian->ujian_id' AND mu_active_status=1 AND mu_tc_id='$tc_id' ");
                                    foreach ($arrMatrixUjian as $key => $matrix) {
                                        ?>
                                        <?= Generic::getMuridNamebyID($matrix->mu_murid_id) ?>
                                        <i class="glyphicon glyphicon-remove" onclick="remove_murid_from_ujian('<?= $matrix->mu_id; ?>');"></i><br>

                                        <?
                                    }
                                    ?>

                                </td>
                                <td>
                                    <button class="btn btn-default" onclick="add_murid_to_ujian('<?= $ujian->ujian_id; ?>');">Add Murid</button>

                                </td>
                            </tr>

                            <?
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <script>
            function add_murid_to_ujian(ujian_id) {
                $('#modal_add_murid_ujian .modal-body').load("<?= _SPPATH; ?>UjianWebHelper/load_murid?ujian_id=" + ujian_id + "&tc_id=<?= AccessRight::getMyOrgID(); ?>")
                $('#modal_add_murid_ujian').modal('show');
            }

            function remove_murid_from_ujian(mu_id) {
                if (confirm("yakin?"))
                    $.post("<?= _SPPATH; ?>UjianWebHelper/remove_murid_from_ujian", {mu_id: mu_id}, function (data) {
                        if (data.status_code) {
                            lwrefresh(selected_page);

                        } else {
                            alert(data.status_message);
                        }
                    }, 'json');
            }
        </script>
        <?
    }

    //  sdh tdk di pake
    public function read_jadwal_ujian_egt_tc() {
        $tc_id = AccessRight::getMyOrgID();
        $ibo_id = Generic::getMyParentID(AccessRight::getMyOrgID());
        $jdwlUjian = new UjianModel();
        $arrJdwlUjian = $jdwlUjian->getWhere("ujian_jenis=2 AND ujian_status=1 AND ujian_ibo_id = '$ibo_id' ORDER by ujian_date ASC");
        $arrLevel = Generic::getAllLevel();
        ?>
        <section class="content-header">
            <h1>Jadwal Ujian SPT</h1>
        </section>
        <section class="content">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal Ujian</th>
                            <th>Level Dari</th>
                            <th>Level Sampai</th>
                            <th>Murid</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach ($arrJdwlUjian as $ujian) {
                            ?>
                            <tr>
                                <td><?= date("d-m-Y", strtotime($ujian->ujian_date)); ?></td>
                                <td><?= $arrLevel[$ujian->ujian_from_level] ?></td>
                                <td><?= $arrLevel[$ujian->ujian_to_level] ?></td>
                                <td>
                                    <?
                                    $matrixUjian = new MatrixNilaiModel();
                                    $arrMatrixUjian = $matrixUjian->getWhere("mu_ujian_id='$ujian->ujian_id' AND mu_active_status=1 AND mu_tc_id='$tc_id' ");
                                    foreach ($arrMatrixUjian as $key => $matrix) {
                                        ?>
                                        <?= Generic::getMuridNamebyID($matrix->mu_murid_id) ?>
                                        <i class="glyphicon glyphicon-remove" onclick="remove_murid_from_ujian('<?= $matrix->mu_id; ?>');"></i><br>

                                        <?
                                    }
                                    ?>

                                </td>
                                <td>
                                    <button class="btn btn-default" onclick="add_murid_to_ujian('<?= $ujian->ujian_id; ?>');">Add Murid</button>

                                </td>
                            </tr>

                            <?
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <script>
            function add_murid_to_ujian(ujian_id) {
                $('#modal_add_murid_ujian .modal-body').load("<?= _SPPATH; ?>UjianWebHelper/load_murid?ujian_id=" + ujian_id + "&tc_id=<?= AccessRight::getMyOrgID(); ?>")
                $('#modal_add_murid_ujian').modal('show');
            }

            function remove_murid_from_ujian(mu_id) {
                if (confirm("yakin?"))
                    $.post("<?= _SPPATH; ?>UjianWebHelper/remove_murid_from_ujian", {mu_id: mu_id}, function (data) {
                        if (data.status_code) {
                            lwrefresh(selected_page);

                        } else {
                            alert(data.status_message);
                        }
                    }, 'json');
            }
        </script>
        <?
    }

    public function read_jadwal_ujian_lain_tc() {
        $tc_id = AccessRight::getMyOrgID();
        $ibo_id = Generic::getMyParentID(AccessRight::getMyOrgID());
        $jdwlUjian = new UjianModel();
        $arrJdwlUjian = $jdwlUjian->getWhere("ujian_status=1 AND ujian_ibo_id = '$ibo_id' ORDER by ujian_date ASC");
        $arrLevel = Generic::getAllLevel();
        ?>
        <section class="content-header">
            <h1>Jadwal Ujian</h1>
        </section>
        <section class="content">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal Ujian</th>
                            <th>Jenis Ujian</th>
                            <th>Level Dari</th>
                            <th>Level Sampai</th>
                            <th>Murid</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach ($arrJdwlUjian as $ujian) {
                            $today = date("Y-m-d H:i:s");
                            $date = $ujian->ujian_date;
                            if ($date >= $today) {
                                $isPast = false;
                            }
                            ?>
                            <tr>
                                <td><?= date("d-m-Y", strtotime($ujian->ujian_date)); ?></td>
                                <td><?= $ujian->ujian_jenis; ?></td>
                                <td><?= $arrLevel[$ujian->ujian_from_level] ?></td>
                                <td><?= $arrLevel[$ujian->ujian_to_level] ?></td>
                                <td>
                                    <?
                                    $matrixUjian = new MatrixNilaiModel();
                                    $arrMatrixUjian = $matrixUjian->getWhere("mu_ujian_id='$ujian->ujian_id' AND mu_active_status=1 AND mu_tc_id='$tc_id' ");
                                    foreach ($arrMatrixUjian as $key => $matrix) {
                                        ?>
                                        <?= Generic::getMuridNamebyID($matrix->mu_murid_id); ?>
                                        <?
                                        if ($isPast === false) {
                                            ?>
                                            <i class="glyphicon glyphicon-remove" onclick="remove_murid_from_ujian('<?= $matrix->mu_id; ?>');"></i><br>

                                            <?
                                        }
                                        else{
                                            echo "<br>";
                                        }
                                    }
                                    ?>

                                </td>
                                <td>
            <?
//                                    pr(Generic::isPast($date))
            if ($isPast === false) {
                ?>
                                        <button class="btn btn-default" onclick="add_murid_to_ujian('<?= $ujian->ujian_id; ?>');">Add Murid</button>

                <?
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
        <script>
            function add_murid_to_ujian(ujian_id) {
                $('#modal_add_murid_ujian .modal-body').load("<?= _SPPATH; ?>UjianWebHelper/load_murid_aktiv?ujian_id=" + ujian_id + "&tc_id=<?= AccessRight::getMyOrgID(); ?>")
                $('#modal_add_murid_ujian').modal('show');
            }

            function remove_murid_from_ujian(mu_id) {
                if (confirm("yakin?"))
                    $.post("<?= _SPPATH; ?>UjianWebHelper/remove_murid_from_ujian", {mu_id: mu_id}, function (data) {
                        if (data.status_code) {
                            lwrefresh(selected_page);

                        } else {
                            alert(data.status_message);
                        }
                    }, 'json');
            }
        </script>
        <?
    }

}
