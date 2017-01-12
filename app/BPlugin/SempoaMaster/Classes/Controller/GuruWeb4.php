<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GuruWeb4
 *
 * @author efindiongso
 */
class GuruWeb4 extends WebService {

//                            [0] => read_jenis_status_guru
//                            [1] => update_jenis_status_guru
//                            [2] => delete_jenis_status_guru
//                            [3] => create_jenis_status_guru
// KPO
    public function read_jenis_status_guru() {
        $obj = new GuruWeb4Model();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_jenis_status_guru");
        $crud->ar_edit = AccessRight::hasRight("update_jenis_status_guru");
        $crud->ar_delete = AccessRight::hasRight("delete_jenis_status_guru");
        $crud->run_custom($obj, "GuruWeb4", "read_jenis_status_guru");
    }

    public function create_jenis_status_guru() {
        
    }

    public function update_jenis_status_guru() {
        
    }

    public function delete_jenis_status_guru() {
        
    }

    // IBO
//       [0] => create_status_guru_ibo
//                            [1] => read_status_guru_ibo
//                            [2] => create_level_guru_ibo
//                            [3] => read_level_guru_ibo
//                            [4] => update_level_guru_ibo
//                            [5] => update_status_guru_ibo
//                            [6] => delete_level_guru_ibo
//                            [7] => delete_status_guru_ibo
    public function create_status_guru_ibo() {
        
    }

    public function read_status_guru_ibo() {
        $myOrgID = AccessRight::getMyOrgID();
        $myParentID = Generic::getMyParentID($myOrgID);
        $obj = new GuruWeb4Model();
        $crud = new CrudCustomSempoa();

        $crud->ar_add = AccessRight::hasRight("create_status_guru_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_status_guru_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_status_guru_ibo");
        $crud->run_custom($obj, "GuruWeb4", "read_status_guru_ibo", " kpo_id = '$myParentID'  ");
    }

    public function read_status_guru_ibo_tmp() {

        $t = time();
        $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : Generic::getFirstTCID(AccessRight::getMyOrgID());
        $whoami = AccessRight::getMyOrgType();
        if ($whoami != "ibo") {
            die("You are not the IBO!");
        }

        $arrAllTC = Generic::getAllMyTC(AccessRight::getMyOrgID());
        $arrGuru = Generic::getAllGuruByTcID($tc_id);
//        pr($arrGuru);
        // Cari guru by TC id
        ?>
        <div  class="col-md-12">
            <div class="col-sm-12">
                <h1>Lihat Guru</h1>
            </div>


            <div  class="form-group">
                <div class='col-sm-12'>
                    <select id = "guruAllTC_<?= $t; ?>" class="form-control">
                        <?
                        foreach ($arrAllTC as $key => $val) {
//                            if ($key == $_GET['id_restaurant']) {
//                                echo "<option selected='selected' value='" . $key . "'>" . $val . "</option>";
//                            } else {

                            echo "<option value='" . $key . "'>" . $val . "</option>";
//                            }
                        }
                        ?>
                    </select>

                </div>
            </div>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover crud-table" style="background-color: white;">
                    <tbody><tr>
                            <th id="sort_guru_<?= $t; ?>" class="clickable">guru_id</th>
                            <th id="sort_kode_guru_<?= $t; ?>" class="clickable">kode_guru</th>
                            <th id="sort_kode_guru_<?= $t; ?>" class="clickable">Entry Date</th>
                            <th id="sort_kode_guru_<?= $t; ?>" class="clickable">nama_guru</th>

                        </tr>
                    </tbody>

                    <?
                    foreach ($arrGuru as $val) {
                        ?>
                        <tr>
                            <td id="guru_id_<?= $val->guru_id; ?>" class="clickable"><?= $val->guru_id; ?> </td>
                            <td id="guru_id_<?= $val->guru_id; ?>" class="clickable"><?= $val->kode_guru; ?> </td>
                            <td id="guru_id_<?= $val->guru_id; ?>" class="clickable"><?= $val->tanggal_masuk; ?> </td>
                            <td id="guru_id_<?= $val->guru_id; ?>" class="clickable"><?= $val->nama_guru; ?> </td>


                        </tr>
                        <?
                    }
                    ?>

                </table>

            </div>

        </div>
        <script type="text/javascript">
            $('#guruAllTC_<?= $t; ?>').change(function () {

                var tc_id = $('#guruAllTC_<?= $t; ?>').val();
                //                console.log("id_restaurant: " + id_restaurant);
                //
                openLw("read_status_guru_ibo", "<?= _SPPATH; ?>GuruWeb4/read_status_guru_ibo?tc_id=" + tc_id, "fade");
            });
        </script>
        <?
//        echo $tc_id;
    }

// IBO
    public function get_jenis_status_guru_ibo() {
        $obj = new GuruWeb4Model();
        $crud = new CrudCustom();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;
        $crud->run_custom($obj, "GuruWeb4", "get_jenis_status_guru_ibo");
    }

    public function update_status_guru_ibo() {
        
    }

    public function delete_status_guru_ibo() {
        
    }

    // TC

    public function get_jenis_status_guru_tc() {

        $obj = new GuruWeb4Model();
        $crud = new CrudCustom();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;
        $crud->run_custom($obj, "GuruWeb4", "get_jenis_status_guru_tc");
    }

    public function create_level_guru_ibo() {
        
    }

    public function read_level_guru_ibo() {
        $jd = new JadwalTrainingModel();
        $jd->printColumlistAsAttributes();
    }

    public function update_level_guru_ibo() {
        
    }

    public function delete_level_guru_ibo() {
        
    }

    public function read_guru_kpo() {

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
        $status = isset($_GET['status']) ? addslashes($_GET['status']) : 1;
        $arrGuru = $obj->getWhere("guru_tc_id=$tcid AND status=$status ORDER BY nama_guru ASC  LIMIT $begin, $limit");
        $jumlahTotal = $obj->getJumlah("guru_tc_id=$tcid AND status=$status");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $index = (($page-1)* 20) +1;
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
                        $('#submit_status_guru_<?= $t; ?>').click(function () {
                            var slc = $('#pilih_tc_<?= $t; ?>').val();
                            var status = $('#pilih_status_<?= $t; ?>').val();
                            $('#content_load_guru_<?=$t;?>').load('<?= _SPPATH; ?>GuruWebHelper/read_guru_kpo_page?tc_id=' + slc +'&status=' + status, function () {

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
                                <td><?=  "<button onclick='window.location.href = \"mailto:" . $valGuru->email_guru . "\";'>Email</button>" ?></td>

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

    public function read_guru_kpo_hlp() {
        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new SempoaGuruModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_guru_kpo");
        $crud->ar_delete = AccessRight::hasRight("delete_guru_kpo");
        $crud->ar_edit = AccessRight::hasRight("update_guru_kpo");
        $crud->run_custom($obj, "GuruWeb4", "read_guru_kpo_hlp", "  guru_kpo_id = '$myOrgID'");
    }
    public function update_guru_kpo() {
        
    }

    public function create_guru_kpo() {
        
    }

    public function delete_guru_kpo() {
        
    }

}
