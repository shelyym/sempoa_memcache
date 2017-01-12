<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrainerWeb2
 *
 * @author efindiongso
 */
class TrainerWeb2 extends WebService {

    //put your code here
    /*
     * [0] => create_permintaan_training_guru
      [1] => read_permintaan_training_guru
      [2] => update_permintaan_training_guru
      [3] => delete_permintaan_training_guru
     */

    public function get_permintaan_training_guru_tc() {
        $myID = AccessRight::getMyOrgID();
        $training = new JadwalTrainingModel();
        $arrTraining = $training->getWhere("jt_ibo_id='$myID' AND jt_status =1  ORDER BY jt_mulai_date ASC, jt_akhir_date ASC ");
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>
                            Level
                        </th>
                        <th>
                            Keterangan
                        </th>
                        <th>
                            Mulai
                        </th>
                        <th>
                            Akhir
                        </th>
                        
                        <th>
                            Guru
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <?
                    $arrJenisTraining = Generic::getJenisTraining();

                    foreach ($arrTraining as $key => $tr) {
                        $trainer = new TrainerModel();
                        $trainer->getByID($tr->jt_trainer_id);
                        ?>
                        <tr>
                            <td>
                                <?= Generic::getLevelNameByID($tr->jt_level_from); ?>
                            </td>
                            <td>
                                <?= $tr->jt_description; ?>
                            </td>
                            <td>
                                <? if($tr->jt_mulai_date != "1970-01-01"){
                                    echo $tr->jt_mulai_date;
                                }

                                 ?>
                            </td>
                            <td>
                                <? if($tr->jt_akhir_date != "1970-01-01"){
                                    echo $tr->jt_akhir_date;
                                }?>
                            </td>
                            
                            <td>
                                <?
                                $tm = new TrainingMatrixModel();
                                $arrTM = $tm->getWhere("tm_training_id='$tr->jt_id' AND tm_status=1 ORDER BY tm_org_id ASC");
//                                pr($arrTM);
                                $guru = new SempoaGuruModel();
                                global $db;
                                foreach ($arrTM as $valtr) {
                                    $nama_guru = Generic::getGuruNamebyID($valtr->tm_guru_id);
                                    echo $nama_guru . "/(" . Generic::getTCNamebyID($valtr->tm_org_id) . ")";
                                    ?>

                                    <?
                                    echo "<br>";
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
        <script>
            function add_guru(jt_id) {
                $('#modal_add_guru_training .modal-body').load("<?= _SPPATH; ?>TrainingWebHelper/load_guru_tc?training_id=" + jt_id + "&tc_id=<?= AccessRight::getMyOrgID(); ?>");

                $('#modal_add_guru_training').modal('show');
                //                alert(jt_id);
            }
            function remove_guru_from_training(jt_id, guru_id) {
                if (confirm("yakin?"))
                    $.post("<?= _SPPATH; ?>TrainingWebHelper/remove_guru_from_training", {jt_id: jt_id, guru_id: guru_id}, function (data) {
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

    public function create_permintaan_training_guru() {
        $myID = AccessRight::getMyOrgID();
        $myIBOId = Generic::getMyParentID(AccessRight::getMyOrgID());
        $training = new JadwalTrainingModel();
        $arrTraining = $training->getWhere("jt_ibo_id='$myIBOId' AND jt_status =1  ORDER BY jt_mulai_date ASC, jt_akhir_date ASC ");
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>
                            Level
                        </th>
                        <th>
                            Keterangan
                        </th>
                        <th>
                            Mulai
                        </th>
                        <th>
                            Akhir
                        </th>

                        <th>
                            Guru
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
                                <?= $tr->jt_description; ?>
                            </td>
                            <td>
                                <? if($tr->jt_mulai_date != "1970-01-01"){
                                    echo $tr->jt_mulai_date;
                                } ?>
                            </td>
                            <td>
                                <?
                                if($tr->jt_akhir_date != "1970-01-01"){
                                    echo $tr->jt_akhir_date;
                                } ?>

                            </td>
    
                            <td>
                                <?
                                $tm = new TrainingMatrixModel();
                                $arrTM = $tm->getWhere("tm_training_id='$tr->jt_id' AND tm_status=1 AND tm_org_id='$myID'");
//                                pr($arrTM);
                                $guru = new SempoaGuruModel();
                                global $db;
                                foreach ($arrTM as $valtr) {
                                    $transaksi = new TransaksiTrainingModel();
                                    $count = $transaksi->isGuruBayarDiscount($valtr->tm_training_id, $valtr->tm_guru_id);
//                                    pr($count . "-" . $valtr->tm_training_id . "-" . $valtr->tm_guru_id);
                                    $nama_guru = Generic::getGuruNamebyID($valtr->tm_guru_id);
                                    echo $nama_guru ;
                                    if ($count == 0) {
                                        ?>
                                        <i class="glyphicon glyphicon-remove" onclick="remove_guru_from_training('<?= $tr->jt_id; ?>', '<?= $valtr->tm_guru_id; ?>');"></i><br>

                                        <?
                                        
                                    }
                                    echo  "<br>";
                                }
                                ?>
                            </td>
                            <td>
                                <?
                                $dateHariIni = new DateTime("today");
                                $dateMulai = new DateTime($tr->jt_mulai_date );
                                if($dateHariIni < $dateMulai){
                                    ?>
                                    <button class="btn btn-default" onclick="add_guru('<?= $tr->jt_id; ?>');">Add Guru</button>
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
        <script>
            function add_guru(jt_id) {
                $('#modal_add_guru_training .modal-body').load("<?= _SPPATH; ?>TrainingWebHelper/load_guru_tc?training_id=" + jt_id + "&tc_id=<?= AccessRight::getMyOrgID(); ?>");

                $('#modal_add_guru_training').modal('show');
                //                alert(jt_id);
            }
            function remove_guru_from_training(jt_id, guru_id) {
                if (confirm("yakin?"))
                    $.post("<?= _SPPATH; ?>TrainingWebHelper/remove_guru_from_training", {jt_id: jt_id, guru_id: guru_id}, function (data) {
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

    public function get_permintaan_training_trainer_ibo() {
        $myID = AccessRight::getMyOrgID();
        $training = new JadwalTrainingModel();
        $arrTraining = $training->getWhere("jt_kpo_id='$myID' AND jt_status =1  ORDER BY jt_mulai_date ASC, jt_akhir_date ASC ");
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>
                            Level dari
                        </th>
                        <th>
                            Level sampai
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

                    </tr>
                </thead>
                <tbody>
        <?
        $arrJenisTraining = Generic::getJenisTraining();

        foreach ($arrTraining as $key => $tr) {
            $trainer = new TrainerModel();
            $trainer->getByID($tr->jt_trainer_id);
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
                                $arrTM = $tm->getWhere("tm_training_id='$tr->jt_id' AND tm_status=1 ORDER BY tm_org_id ASC");
//                                pr($arrTM);
                                $guru = new SempoaGuruModel();
                                global $db;
                                $arrNama = array();
                                foreach ($arrTM as $valtr) {
                                    $nama_guru = Generic::getTrainerNamebyID($valtr->tm_guru_id);
                                    $arrNama[$nama_guru] = $nama_guru . "/(" . Generic::getTCNamebyID($valtr->tm_org_id) . ")" . "<br>";
//                                    echo $nama_guru . "/(" . Generic::getTCNamebyID($valtr->tm_org_id) . ")";
                                    ?>

                                    <?
//                                    echo "<br>";
                                }
                                foreach ($arrNama as $val) {
                                    echo $val;
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
        <?
    }

}
