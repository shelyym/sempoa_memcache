<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrainingWebHelper
 *
 * @author efindiongso
 */
class TrainingWebHelper extends WebService {

    //put your code here

    function trainer_profile() {
        $id = addslashes($_GET['id_trainer']);
        $trainer = new TrainerModel();
        $trainer->getByID($id);
//        public $default_read_coloms = "id_trainer,kode_trainer,tanggal_masuk,nama_trainer,nama_panggilan,jenis_kelamin,alamat,tempat_lahir,agama,tanggal_lahir,nomor_hp,pendidikan_terakhir,email,status,id_level_trainer,gambar,tr_ak_id,tr_kpo_id,tr_ibo_id";
        ?>


        <section class="content-header" >
            <span id="edit_<?= $id; ?>" class="pull-right  glyphicon glyphicon-pencil" onclick="openLw('TrainerWebView', '<?= _SPPATH ?>TrainerWeb/read_trainer_ibo?cmd=edit&id=<?= $id; ?>&parent_page=' + window.selected_page + '&loadagain=' + $.now(), 'fade');" ></span>

            <h1>

                <?= $trainer->nama_trainer; ?>
            </h1>

        </section>

        <section class="content" style="padding-left: 0px;">


            <div class="row2">
                <!-- left column -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="text-center">
                        <img src="<?= _BPATH . _PHOTOURL . $trainer->gambar; ?>" onerror="imgError(this);" class="img-responsive">
                        <br>
                    </div>
                </div>

                <!-- edit form column -->
                <div class="col-md-9 col-sm-6 col-xs-12">


                    <table class="table table-striped table-responsive">
                        <tr>
                            <td>
                                Level :
                            </td>
                            <td>
                                <?= Generic::getLevelNameByID($trainer->id_level_trainer); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                IBO :
                            </td>
                            <td>
                                <?= Generic::getTCNamebyID($trainer->tr_ibo_id); ?>
                            </td>
                        </tr>

                        </tr>
                    </table>
                </div>
            </div>
        </section>
        <?
    }

    function load_guru_tc() {
        $tc_id = addslashes($_GET['tc_id']);
        $training_id = addslashes($_GET['training_id']);

        $tm = new TrainingMatrixModel();
        $arrGuruTM = $tm->getWhere("tm_training_id='$training_id' and tm_status=1");
        foreach ($arrGuruTM as $val) {
            $guruTM[] = $val->tm_guru_id;
        }
        $guru = new SempoaGuruModel();
        $arrGuru = $guru->getWhere("guru_tc_id='$tc_id' AND guru_first_register=1 AND (status= 1 OR status =0)");
        $t = time();
        ?>
        <select class="form-control" id="guru_select_<?= $t; ?>">
            <?
            foreach ($arrGuru as $value) {
                if (!(in_array($value->guru_id, $guruTM))) {
                    ?>
                    <option value="<?= $value->guru_id; ?>"><?= $value->nama_guru; ?></option>
                    <?
                }
            }
            ?>
        </select>
        <script>
            training_id = '<?= $training_id; ?>';
            org_id = '<?= $tc_id; ?>';
            id_guru = $('#guru_select_<?= $t; ?>').val();
            $('#guru_select_<?= $t; ?>').change(function () {
                var slc = $('#guru_select_<?= $t; ?>').val();
                id_guru = slc;
            });
        </script>
        <?
    }

    function add_guru_to_training() {
        $id_guru = addslashes($_POST['id_guru']);
        $training_id = addslashes($_POST['training_id']);
        $org_id = addslashes($_POST['org_id']);
        if ($id_guru == 0) {
            $json['status_code'] = 0;
            $json['status_message'] = "Save Failed";
            echo json_encode($json);
            die();
        }
        $guru = new SempoaGuruModel();
        $guru->getByID($id_guru);
        $tm = new TrainingMatrixModel();
        $jt = new JadwalTrainingModel();
        $jt->getByID($training_id);

//        $arrTM = $tm
        $arrSearch = $tm->getWhere("tm_guru_id='$id_guru' AND tm_training_id='$training_id'");
        if (count($arrSearch) == 0) {
            $tm->tm_guru_id = $id_guru;
            $tm->tm_training_id = $training_id;
            $tm->tm_status = 1;
            $tm->tm_org_id = $org_id;
            $jt = new JadwalTrainingModel();
            $jt->getByID($training_id);
            $tm->tm_level = $jt->jt_level_from;
            if ($tm->save()) {
//                $trainingMaster = new BiayaTrainingModel();
//                $training_level = Generic::getTrainingLevel($training_id);
//                $trainingMaster->getWhereOne("by_level='$training_level'");
                $training_invoice = new TransaksiTrainingModel();
                $training_invoice->tr_tr_id = $training_id;
                $training_invoice->tr_guru_id = $id_guru;
                $training_invoice->tr_owner_id = Generic::getMyParentID(AccessRight::getMyOrgID());
                $training_invoice->tr_request_id = AccessRight::getMyOrgID();
                $training_invoice->tr_harga_id = $jt->jt_harga;
                $training_invoice->tr_date = leap_mysqldate();
                $training_invoice->save();
                $json['status_code'] = 1;
                $json['status_message'] = "Ok";
                echo json_encode($json);
                die();
            }
        } else {
            $arrSearch[0]->tm_status = 1;
            $arrSearch[0]->save(1);
//            $trainingMaster = new BiayaTrainingModel();
//            $training_level = Generic::getTrainingLevel($training_id);
//            $trainingMaster->getWhereOne("by_level='$training_level'");
            $training_invoice = new TransaksiTrainingModel();
            $training_invoice->tr_tr_id = $training_id;
            $training_invoice->tr_guru_id = $id_guru;
            $training_invoice->tr_owner_id = Generic::getMyParentID(AccessRight::getMyOrgID());
            $training_invoice->tr_request_id = AccessRight::getMyOrgID();
            $training_invoice->tr_harga_id = $jt->jt_harga;
            $training_invoice->tr_date = leap_mysqldate();
            $training_invoice->save();
            $json['status_code'] = 1;
            $json['status_message'] = "Ok";
            echo json_encode($json);
            die();
        }

        $json['status_code'] = 0;
        $json['status_message'] = "Save Failed";
        echo json_encode($json);
        die();
    }

    function remove_guru_from_training() {
        $jt_id = addslashes($_POST['jt_id']);
        $guru_id = addslashes($_POST['guru_id']);

        $tm = new TrainingMatrixModel();
        $arrTM = $tm->getWhere("tm_training_id='$jt_id' AND tm_guru_id='$guru_id'");
        if (count($arrTM) > 0) {
            $arrTM[0]->tm_status = 0;
            $arrTM[0]->save(1);
            $training_invoice = new TransaksiTrainingModel();
            $training_invoice->getWhereOne("tr_tr_id='$jt_id' AND tr_guru_id='$guru_id'");
//            if (count($arrTraining) > 0) {
            $tr_id = $training_invoice->tr_id;
            global $db;
            $q = "DELETE FROM {$training_invoice->table_name} WHERE tr_id='$tr_id'";

            //echo $q;
            $a = $db->query($q, 0);
//            }
//
//            
            $json['status_code'] = 1;
            $json['status_message'] = "Ok";
            echo json_encode($json);
            die();
        }
        $json['status_code'] = 0;
        $json['status_message'] = "Save Failed";
        echo json_encode($json);
        die();
    }

    function setStatusTraining() {

        $guru_id = (int) addslashes($_GET['guru_id']);
        $tr_id = addslashes($_GET['tr_id']);
        $tm_id = addslashes($_GET['tm_id']);
        $status = addslashes($_GET['status']);

        $objInvoices = new TransaksiTrainingModel();
        $objInvoices->getWhereOne("tr_tr_id='$tr_id' AND tr_guru_id='$guru_id'");
        $objInvoices->tr_date = leap_mysqldate();
        $objInvoices->tr_status = $status;
        if($status == KEY::$STATUS_DISCOUNT_100){
            $objInvoices->tr_harga_id = 0;
        }
        $update = $objInvoices->save(1);
        if ($update) {
            $help = new GuruWebHelper();
            $help->pembukuan_trainer($objInvoices->tr_id, $tm_id, $guru_id, $status);

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

    public function load_trainer_ibo() {
        $ibo_id = addslashes($_GET['ibo_id']);
        $training_id = addslashes($_GET['training_id']);

        $tm = new TrainingMatrixModel();
        $arrGuruTM = $tm->getWhere("tm_training_id='$training_id' and tm_status=1");
        foreach ($arrGuruTM as $val) {
            $guruTM[] = $val->tm_guru_id;
        }
        $trainer = new TrainerModel();
        $arrTrainer = $trainer->getWhere("tr_ibo_id='$ibo_id'");
        $t = time();
        ?>
        <select class="form-control" id="trainer_select_<?= $t; ?>">
            <?
            foreach ($arrTrainer as $value) {
                if (!(in_array($value->id_trainer, $guruTM))) {
                    ?>
                    <option value="<?= $value->id_trainer; ?>"><?= $value->nama_trainer; ?></option>
                    <?
                }
            }
            ?>
        </select>
        <script>
            training_id = '<?= $training_id; ?>';
            org_id = '<?= $ibo_id; ?>';
            id_trainer = $('#trainer_select_<?= $t; ?>').val();
            $('#trainer_select_<?= $t; ?>').change(function () {
                var slc = $('#trainer_select_<?= $t; ?>').val();
                id_trainer = slc;
            });
        </script>
        <?
    }

    function add_trainer_to_training() {
        $id_trainer = addslashes($_POST['id_trainer']);
        $training_id = addslashes($_POST['training_id']);
        $org_id = addslashes($_POST['org_id']);
        if ($id_trainer == 0) {
            $json['status_code'] = 0;
            $json['status_message'] = "Save Failed";
            echo json_encode($json);
            die();
        }
        $trainer = new TrainerModel();
        $trainer->getByID($id_trainer);
        $tm = new TrainingMatrixModel();
        $jt = new JadwalTrainingModel();
        $jt->getByID($training_id);

//        $arrTM = $tm
        $arrSearch = $tm->getWhere("tm_guru_id='$id_trainer' AND tm_training_id='$training_id'");
        if (count($arrSearch) == 0) {
            $div = $jt->jt_harga / ($jt->jt_level_to - $jt->jt_level_from + 1);
            for ($i = $jt->jt_level_from; $i <= $jt->jt_level_to; $i++) {
                $tm = new TrainingMatrixModel();
                $tm->tm_guru_id = $id_trainer;
                $tm->tm_training_id = $training_id;
                $tm->tm_status = 1;
                $tm->tm_org_id = $org_id;
                $jt = new JadwalTrainingModel();
                $jt->getByID($training_id);
                $tm->tm_level = $i;
                if ($tm->save()) {
//                    $training_invoice = new TransaksiTrainingModel();
//                    $training_invoice->tr_tr_id = $training_id;
//                    $training_invoice->tr_guru_id = $id_trainer;
//                    $training_invoice->tr_owner_id = Generic::getMyParentID(AccessRight::getMyOrgID());
//                    $training_invoice->tr_request_id = AccessRight::getMyOrgID();
//                    $training_invoice->tr_harga_id = $div;
//                    $training_invoice->tr_date = leap_mysqldate();
//                    $training_invoice->save();
                }
            }


            $training_invoice = new TransaksiTrainingModel();
            $training_invoice->tr_tr_id = $training_id;
            $training_invoice->tr_guru_id = $id_trainer;
            $training_invoice->tr_owner_id = Generic::getMyParentID(AccessRight::getMyOrgID());
            $training_invoice->tr_request_id = AccessRight::getMyOrgID();
            $training_invoice->tr_harga_id = $jt->jt_harga;
            $training_invoice->tr_date = leap_mysqldate();
            $training_invoice->save();


            $json['status_code'] = 1;
            $json['status_message'] = "Ok";
            echo json_encode($json);
            die();
        } else {
            $arrSearch[0]->tm_status = 1;
            $arrSearch[0]->save(1);
            $training_invoice = new TransaksiTrainingModel();
            $training_invoice->tr_tr_id = $training_id;
            $training_invoice->tr_guru_id = $id_trainer;
            $training_invoice->tr_owner_id = Generic::getMyParentID(AccessRight::getMyOrgID());
            $training_invoice->tr_request_id = AccessRight::getMyOrgID();
            $training_invoice->tr_harga_id = $jt->jt_harga;
            $training_invoice->tr_date = leap_mysqldate();
            $training_invoice->save();
            $json['status_code'] = 1;
            $json['status_message'] = "Ok";
            echo json_encode($json);
            die();
        }

        $json['status_code'] = 0;
        $json['status_message'] = "Save Failed1";
        echo json_encode($json);
        die();
    }

    function remove_trainer_from_training() {
        $jt_id = addslashes($_POST['jt_id']);
        $id_trainer = addslashes($_POST['id_trainer']);


        $tm = new TrainingMatrixModel();
        $arrTM = $tm->getWhere("tm_training_id='$jt_id' AND tm_guru_id='$id_trainer'");
        if (count($arrTM) > 0) {
            foreach ($arrTM as $valTr) {
                $valTr->tm_status = 0;
                $valTr->save(1);
            }

            $training_invoice = new TransaksiTrainingModel();
            $training_invoice->getWhereOne("tr_tr_id='$jt_id' AND tr_guru_id='$id_trainer'");
//            if (count($arrTraining) > 0) {
            $tr_id = $training_invoice->tr_id;
            global $db;
            $q = "DELETE FROM {$training_invoice->table_name} WHERE tr_id='$tr_id'";

            //echo $q;
            $a = $db->query($q, 0);
//            }
//
//            
            $json['status_code'] = 1;
            $json['status_message'] = "Ok";
            echo json_encode($json);
            die();
        }
        $json['status_code'] = 0;
        $json['status_message'] = "Save Failed";
        echo json_encode($json);
        die();


        $tm = new TrainingMatrixModel();
        $arrTM = $tm->getWhere("tm_training_id='$jt_id' AND tm_guru_id='$id_trainer'");
        if (count($arrTM) > 0) {
            foreach ($arrTM as $val) {
                $val->tm_status = 0;
                $val->save(1);
//                $training_invoice = new TransaksiTrainingModel();
//                $training_invoice->getWhereOne("tr_tr_id='$jt_id' AND tr_guru_id='$id_trainer'");
////            if (count($arrTraining) > 0) {
//                $tr_id = $training_invoice->tr_id;
//                global $db;
//                $q = "DELETE FROM {$training_invoice->table_name} WHERE tr_id='$tr_id'";
//                $a = $db->query($q, 0);
            }


            $json['status_code'] = 1;
            $json['status_message'] = "Ok";
            echo json_encode($json);
            die();
        }
        $json['status_code'] = 0;
        $json['status_message'] = "Save Failed";
        echo json_encode($json);
        die();
    }

    function setKeteranganTraining() {


        $guru_id = (int) addslashes($_GET['guru_id']);
        $tr_id = addslashes($_GET['tr_id']);
        $tm_id = addslashes($_GET['tm_id']);
        $status = addslashes($_GET['status']);

        $objTraining = new TrainingMatrixModel();
        $objTraining->getWhereOne("tm_id=$tm_id AND tm_training_id=$tr_id AND tm_guru_id=$guru_id");
        $objTraining->tm_keterangan = $status;

        $update = $objTraining->save(1);
        if ($update) {
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
}
