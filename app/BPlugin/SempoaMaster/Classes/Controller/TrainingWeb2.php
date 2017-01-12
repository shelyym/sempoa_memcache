<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrainingWeb2
 *
 * @author efindiongso
 */
class TrainingWeb2 extends WebService
{

    //put your code here

    public function read_jadwal_training_trainer()
    {
        $obj = new JadwalTrainingModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_jadwal_training_trainer");
        $crud->ar_edit = AccessRight::hasRight("update_jadwal_training_trainer");
        $crud->ar_delete = AccessRight::hasRight("delete_jadwal_training_trainer");
        $myOrgId = AccessRight::getMyOrgID();
        $crud->run_custom($obj, "TrainingWeb2", "read_jadwal_training_trainer", "jt_kpo_id='$myOrgId'");
    }

    public function create_jadwal_training_trainer()
    {

    }

    public function update_jadwal_training_trainer()
    {

    }

    public function delete_jadwal_training_trainer()
    {

    }

    public function read_pembayaran_training_ibo()
    {
        $myOrgID = AccessRight::getMyOrgID();
        $objInvoices = new TransaksiTrainingModel();
        $arrInv = $objInvoices->getWhere("tr_owner_id='$myOrgID' ORDER BY tr_id DESC");
        ?>
        <section class="content-header">
            <h1>
                Invoices Training Guru
            </h1>

        </section>
        <section class="content">
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped" style="background-color: #FFFFFF;">
                    <thead class='heading'>
                    <tr>
                        <th>Transaksi ID</th>
                        <th>TC</th>
                        <th>Guru</th>
                        <th>Status</th>
                        <th>Harga</th>
                        <th>Tanggal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $mt = new TrainingMatrixModel();
                    $arrStatus = Generic::getStatusTrainer();
                    //
                    foreach ($arrInv as $inv) {
                        if ($inv->tr_status == KEY::$STATUS_NEW)
                            $warna = KEY::$WARNA_BIRU;
                        elseif ($inv->tr_status == KEY::$STATUS_PAID)
                            $warna = KEY::$WARNA_HIJAU;
                        elseif ($inv->tr_status == KEY::$STATUS_DISCOUNT_100)
                            $warna = KEY::$WARNA_MERAH;
                        $mt->getWhereOne("tm_training_id='$inv->tr_tr_id' AND tm_guru_id='$inv->tr_guru_id'");
                        ?>
                        <tr style="background-color: <?= $warna; ?>">
                            <td id="<?= $inv->tr_id; ?>"><?= $inv->tr_id; ?></td>
                            <td><?= Generic::getTCNamebyID($inv->tr_request_id); ?></td>
                            <td>
                                <?
                                //                                    foreach ($arrMT as $hlp) {
                                echo Generic::getGuruNamebyID($mt->tm_guru_id) . ", " . Generic::getLevelNameByID($mt->tm_level);
                                //                                    }
                                ?>
                            </td>
                            <td id="status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>"><?= $arrStatus[$inv->tr_status]; ?></td>
                            <td><?= idr($inv->tr_harga_id); ?></td>
                            <td><?= $inv->tr_date; ?></td>
                        </tr>

                        <script>
                            $('#status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>').dblclick(function () {
                                var current = $("#status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>").html();
                                if (current == '<b>Unpaid</b>') {
                                    var html = "<select id='select_status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>'>" +
                                        "<option value='0'><b>Unpaid</b></option>" +
                                        "<option value='1'>Paid</option>" +
                                        "<option value='2'>Discount 100%</option>" +
                                        "</select>";

                                    $("#status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>").html(html);
                                    $('#select_status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>').change(function () {
                                        var guru_id = "<?= $inv->tr_guru_id; ?>";
                                        var tr_id = "<?= $inv->tr_tr_id; ?>";
                                        var tm_id = "<?= $inv->tr_id; ?>";
                                        var status = $('#select_status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>').val();
                                        $.get("<?= _SPPATH; ?>TrainingWebHelper/setStatusTraining?guru_id=" + guru_id + "&tr_id=" + tr_id + "&tm_id=" + tm_id + "&status=" +status, function (data) {

                                            lwrefresh(selected_page);
                                            alert(data.status_message);
                                        }, 'json');
                                    })
                                }

                            });
                        </script>
                        <?
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </section>

        <?
//        $arrInvoices = $objInvoices->getWhere("tr_guru_id='$id' ORDER BY tr_date DESC LIMIT $begin,$limit");
    }

    public function get_jadwal_training_trainer_satuan()
    {
        $myID = AccessRight::getMyOrgID();
        $myIBOId = Generic::getMyParentID(AccessRight::getMyOrgID());
        $training = new JadwalTrainingModel();
        $arrTraining = $training->getWhere("jt_kpo_id='$myIBOId' AND jt_status =1  ORDER BY jt_mulai_date ASC, jt_akhir_date ASC ");
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>
                        Level Mulai
                    </th>
                    <th>
                        Level Akhir
                    </th>
                    <th>
                        Mulai
                    </th>
                    <th>
                        Akhir
                    </th>

                    <th>
                        Trainer
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                <?
                $arrJenisTraining = Generic::getJenisTraining();

                foreach ($arrTraining as $key => $tr) {


                    $trainer = new TrainerModel();
                    $trainer->getByID($tr->jt_trainer_id);
//                                $lvl = new SempoaLevel();
//                                $lvl->getByID($guru->id_level_training_guru);
                    ?>
                    <tr>
                        <td>
                            <?= Generic::getLevelNameByID($tr->jt_level_from); ?>
                        </td>
                        <td>
                            <?= Generic::getLevelNameByID($tr->jt_level_to); ?>
                        </td>
                        <td>
                            <?
                            if ($tr->jt_mulai_date != "1970-01-01") {
                                echo $tr->jt_mulai_date;
                            }
                            ?>
                        </td>
                        <td>
                            <?
                            if ($tr->jt_akhir_date != "1970-01-01") {
                                echo $tr->jt_akhir_date;
                            }
                            ?>
                        </td>

                        <td>
                            <?
                            $tm = new TrainingMatrixModel();
                            $arrTM = $tm->getWhere("tm_training_id='$tr->jt_id' AND tm_status=1 AND tm_org_id='$myID' GROUP BY tm_guru_id");

                            //                                pr($arrTM);
                            $trainer = new TrainerModel();
                            global $db;
                            foreach ($arrTM as $valtr) {
                                $transaksi = new TransaksiTrainingModel();
                                $count = $transaksi->isGuruBayarDiscount($valtr->tm_training_id, $valtr->tm_guru_id);
                                $nama_trainer = Generic::getTrainerNamebyID($valtr->tm_guru_id);
                                echo $nama_trainer;

                                $transaksi->getWhereOne("tr_tr_id='$tr->jt_id'");


                                if ($count == 0) {
                                    ?>
                                    <i class="glyphicon glyphicon-remove"
                                       onclick="remove_trainer_from_training('<?= $tr->jt_id; ?>', '<?= $valtr->tm_guru_id; ?>');"></i>
                                    <br>

                                    <?

                                } else {
                                    echo "<br>";
                                }


                                if ($transaksi->tr_status == 0) {

                                }
                                ?>


                                <?
                                echo "<br>";
                            }
                            ?>
                        </td>
                        <td>
                            <button class="btn btn-default" onclick="add_trainer('<?= $tr->jt_id; ?>');">Add Trainer
                            </button>

                        </td>
                    </tr>
                    <?
                }
                ?>

                </tbody>
            </table>
        </div>
        <script>
            function add_trainer(jt_id) {
                $('#modal_add_trainer_training .modal-body').load("<?= _SPPATH; ?>TrainingWebHelper/load_trainer_ibo?training_id=" + jt_id + "&ibo_id=<?= AccessRight::getMyOrgID(); ?>");

                $('#modal_add_trainer_training').modal('show');
                //                alert(jt_id);
            }
            function remove_trainer_from_training(jt_id, id_trainer) {
                if (confirm("yakin?"))
                    $.post("<?= _SPPATH; ?>TrainingWebHelper/remove_trainer_from_training", {
                        jt_id: jt_id,
                        id_trainer: id_trainer
                    }, function (data) {
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

    public function read_pembayaran_training_kpo()
    {
        $myOrgID = AccessRight::getMyOrgID();
        $objInvoices = new TransaksiTrainingModel();
        $arrInv = $objInvoices->getWhere("tr_owner_id='$myOrgID'ORDER BY tr_id DESC");
        ?>
        <section class="content-header">
            <h1>
                Invoices Training Trainer
            </h1>

        </section>
        <section class="content">
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped" style="background-color: #FFFFFF;">
                    <thead class='heading'>
                    <tr>
                        <th>Transaksi ID</th>
                        <th>IBO</th>
                        <th>Trainer</th>
                        <th>Status</th>
                        <th>Harga</th>
                        <th>Tanggal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $mt = new TrainingMatrixModel();
                    $arrStatus = Generic::getStatusTrainer();
                    //
                    foreach ($arrInv as $inv) {
                        if ($inv->tr_status == KEY::$STATUS_NEW)
                            $warna = KEY::$WARNA_BIRU;
                        elseif ($inv->tr_status == KEY::$STATUS_PAID)
                            $warna = KEY::$WARNA_HIJAU;
                        elseif ($inv->tr_status == KEY::$STATUS_DISCOUNT_100)
                            $warna = KEY::$WARNA_MERAH;
                        $mt->getWhereOne("tm_training_id='$inv->tr_tr_id' AND tm_guru_id='$inv->tr_guru_id'");

                        $JT = new JadwalTrainingModel();
                        $JT->getByID($mt->tm_training_id);
                        ?>
                        <tr style="background-color: <?= $warna; ?>">
                            <td id="<?= $inv->tr_id; ?>"><?= $inv->tr_id; ?></td>
                            <td><?= Generic::getTCNamebyID($inv->tr_request_id); ?></td>
                            <td>
                                <?
                                if ($JT->jt_level_from != $JT->jt_level_to) {
                                    echo Generic::getTrainerNamebyID($mt->tm_guru_id) . ", " . Generic::getLevelNameByID($JT->jt_level_from) . " - " . Generic::getLevelNameByID($JT->jt_level_to);
                                } else {
                                    echo Generic::getTrainerNamebyID($mt->tm_guru_id) . ", " . Generic::getLevelNameByID($JT->jt_level_from);
                                }
                                ?>
                            </td>
                            <td id="status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>"><?= $arrStatus[$inv->tr_status]; ?></td>
                            <td><?= idr($inv->tr_harga_id); ?></td>
                            <td><?= $inv->tr_date; ?></td>
                        </tr>

                        <script>
                            $('#status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>').dblclick(function () {
                                var current = $("#status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>").html();
                                if (current == '<b>Unpaid</b>') {
                                    var html = "<select id='select_status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>'>" +
                                        "<option value='0'><b>Unpaid</b></option>" +
                                        "<option value='1'>Paid</option>" +
                                        "<option value='2'>Discount 100%</option>" +
                                        "</select>";

                                    $("#status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>").html(html);
                                    $('#select_status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>').change(function () {
                                        var guru_id = "<?= $inv->tr_guru_id; ?>";
                                        var tr_id = "<?= $inv->tr_tr_id; ?>";
                                        var tm_id = "<?= $inv->tr_id; ?>";
                                        var status = $('#select_status_<?= $inv->tr_tr_id . "_" . $inv->tr_guru_id; ?>').val();
                                        $.get("<?= _SPPATH; ?>TrainingWebHelper/setStatusTraining?guru_id=" + guru_id + "&tr_id=" + tr_id + "&tm_id=" + tm_id +"&status="+status, function (data) {

                                            lwrefresh(selected_page);
                                            alert(data.status_message);
                                        }, 'json');
                                    })
                                }

                            });
                        </script>
                        <?
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </section>

        <?
    }

}
