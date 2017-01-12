<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GuruWeb2
 *
 * @author efindiongso
 */
class GuruWeb2 extends WebService {

    // AK

    public function get_guru_ak() {
        $objGuru = new SempoaGuruModel();
        $objGuru->getOrderBy("guru_tc_id ASC");
        $crud = new CrudCustom();
        $crud->run_custom($objGuru, "GuruWeb2", "get_guru_ak");
    }

    // TC

    public function read_guru_tc(){


        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new SempoaGuruModel();

        $obj->removeAutoCrudClick = array("email_guru","profile");
        $obj->read_filter_array = array("guru_tc_id" => $myOrgID);
        $obj->hideColoums = array("guru_tc_id","guru_ak_id", "guru_kpo_id","guru_ibo_id");
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_guru_tc");
        $crud->ar_edit = AccessRight::hasRight("update_guru_tc");
        $crud->ar_delete = AccessRight::hasRight("delete_guru_tc");
        $crud->filter_extra = "status_guru";

        if($_GET['status_guru'] != ""){
            $_SESSION['filter_status_guru'] = $_GET['status_guru'];
        }




        if(isset($_SESSION['filter_status_guru']) && $_SESSION['filter_status_guru']!="88"){
            $obj->read_filter_array["status"] = $_SESSION['filter_status_guru'];
        }



        $crud->run_custom($obj, "GuruWeb2", "read_guru_tc");

        die();



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
        $index = (($page-1)* 20) +1;
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
                        $k =0;
//                        pr($arrGuru);
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

    public function read_guru_tc_hlp(){
        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new SempoaGuruModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_guru_tc");
        $crud->ar_delete = AccessRight::hasRight("delete_guru_tc");
        $crud->ar_edit = AccessRight::hasRight("update_guru_tc");
        $crud->run_custom($obj, "GuruWeb2", "read_guru_tc_hlp", " guru_tc_id = '$myOrgID'");
    }
    public function read_guru_tc_tmp() {

        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new SempoaGuruModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_guru_tc");
        $crud->ar_delete = AccessRight::hasRight("delete_guru_tc");
        $crud->ar_edit = AccessRight::hasRight("update_guru_tc");
        $crud->run_custom($obj, "GuruWeb2", "read_guru_tc", " guru_tc_id = '$myOrgID'");
    }

    public function create_guru_tc() {
        $_GET['cmd'] = 'edit';
        $this->read_guru_tc_hlp();
    }

    public function update_guru_tc() {
        
    }

    public function delete_guru_tc() {
        
    }

    public function create_jadwal_mengajar_guru() {
        
    }

    public function read_jadwal_mengajar_guru() {
        $myOrgID = AccessRight::getMyOrgID();
        $arrAllGuru = Generic::getAllGuruQualifiedByTC($myOrgID);
        $t = time();
        ?>
        <section class="content-header" >

            <div class="pull-left" style="font-size: 13px;">
                Guru : <select id="guru_<?= $t; ?>">
                    <?
                    foreach ($arrAllGuru as $key => $guru) {
                        ?>
                        <option value="<?= $key; ?>"> <?= $guru; ?></option>
                        <?
                    }
                    ?>
                </select>
                <button id="submit_guru_<?= $t; ?>">submit</button>
            </div>
            <div class="clearfix"></div>
            <script>
                $('#submit_guru_<?= $t; ?>').click(function () {
                    var guru = $('#guru_<?= $t; ?>').val();
                    $('#container_jw_guru').load("<?= _SPPATH; ?>GuruWebHelper/getjwgurubyid?id_guru=" + guru, function () {
                    }, 'json');
                });
            </script>
        </section>

        <?
        GuruWebHelper::tableJMGuru();
    }

    public function update_jadwal_mengajar_guru() {
        
    }

    public function delete_jadwal_mengajar_guru() {
        
    }

// End TC
// 
// IBO
    public function get_jadwal_mengajar_guru_ibo() {
        $myOrgID = AccessRight::getMyOrgID();
        $arrMyTC = Generic::getAllMyTC($myOrgID);
        $arrAllGuru = Generic::getAllGuruQualifiedByTC(key($arrMyTC));
        $t = time();
        ?>
        <section class="content-header" >

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

                Guru : <select id="guru_<?= $t; ?>">
                    <?
                    foreach ($arrAllGuru as $key => $guru) {
                        ?>
                        <option value="<?= $key; ?>"> <?= $guru; ?></option>
                        <?
                    }
                    ?>
                </select>
                <button id="submit_guru_<?= $t; ?>">submit</button>
            </div>
            <div class="clearfix"></div>
            <script>

                $('#tc_<?= $t; ?>').change(function () {
                    var slc = $('#tc_<?= $t; ?>').val();
                    getGuru(slc);
                });

                function getGuru(slc) {
                    $.ajax({
                        type: "POST",
                        url: "<?= _SPPATH; ?>GuruWebhelper/getgurubyTC?",
                        data: 'tc_id=' + slc,
                        success: function (data) {
                            console.log(data);
                            $("#guru_<?= $t; ?>").html(data);
                        }
                    });
                }
                $('#submit_guru_<?= $t; ?>').click(function () {
                    var guru = $('#guru_<?= $t; ?>').val();
                    $('#container_jw_guru').load("<?= _SPPATH; ?>GuruWebHelper/getjwgurubyid?id_guru=" + guru, function () {
                    }, 'json');
                });
            </script>
        </section>

        <?
        GuruWebHelper::tableJMGuru();
    }

// KPO

    public function get_guru_kpo() {
        $kpoID = AccessRight::getMyOrgID();
        $arrMyIBO = Generic::getAllMyIBO($kpoID);
        $iboID = (isset($_GET['ibo_id']) ? addslashes($_GET['ibo_id']) : key($arrMyIBO));
        $arrMyTC = Generic::getAllMyTC($iboID);
        $tcid = (isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC));
        $t = time();
        ?>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
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
            </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="exampleInputName2">Pilih TC:</label>
                <select id="pilih_tc_<?= $t; ?>">

                    <?
                    foreach ($arrMyTC as $key => $val) {
                        ?>
                        <option value="<?= $key; ?>"><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>
            </div>
        </div>



        <div class="col-md-3 col-sm-3 col-xs-12">
            <button class="btn btn-default" id="submit_pilih_tc_<?= $t; ?>">Submit</button>
        </div>

        <div class="clearfix"></div>
        <div id = 'container_tc_<?= $tcid; ?>' class="section container table responsive">

        </div>

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
                $('#container_tc_<?= $tcid; ?>').load("<?= _SPPATH; ?>GuruWebHelper/viewGuruTC?tc_id=" + slc, function () {
                }, 'json');
            });

        </script>

        <?
        die();
        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new SempoaGuruModel();
        $crud = new CrudCustomSempoa();
        $crud->run_custom($obj, "GuruWeb2", "get_guru_kpo", " guru_kpo_id = '$myOrgID'");
    }

    public function get_jadwal_mengajar_guru_kpo() {
        $arrMyIBO = Generic::getAllMyIBO(AccessRight::getMyOrgID());
        $arrMyTC = Generic::getAllMyTC(key($arrMyIBO));
        $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC);
        $ibo_id = isset($_GET['ibo_id']) ? addslashes($_GET['ibo_id']) : key($arrMyIBO);
        $t = time();

        $arrAllGuru = Generic::getAllGuruQualifiedByTC(key($arrMyTC));
        $t = time();
        ?>
        <section class="content-header" >

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

                Guru : <select id="guru_<?= $t; ?>">
                    <?
                    foreach ($arrAllGuru as $key => $guru) {
                        ?>
                        <option value="<?= $key; ?>"> <?= $guru; ?></option>
                        <?
                    }
                    ?>
                </select>
                <button id="submit_guru_<?= $t; ?>">submit</button>
            </div>
            <div class="clearfix"></div>
            <script>

                $('#ibo_<?= $t; ?>').change(function () {
                    var slc = $('#ibo_<?= $t; ?>').val();
                    var tc = $('#tc_<?= $t; ?>').val();
                    getTC(slc);
                    getGuru(tc);
                });

                $('#tc_<?= $t; ?>').change(function () {
                    var slc = $('#tc_<?= $t; ?>').val();
                    getGuru(slc);
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

                function getGuru(slc1) {
                    $.ajax({
                        type: "POST",
                        url: "<?= _SPPATH; ?>GuruWebhelper/getgurubyTC?",
                        data: 'tc_id=' + slc1,
                        success: function (data) {
                            console.log(data);
                            $("#guru_<?= $t; ?>").html(data);
                        }
                    });
                }
                $('#submit_guru_<?= $t; ?>').click(function () {
                    var guru = $('#guru_<?= $t; ?>').val();
                    $('#container_jw_guru').load("<?= _SPPATH; ?>GuruWebHelper/getjwgurubyid?id_guru=" + guru, function () {
                    }, 'json');
                });
            </script>
        </section>

        <?
        GuruWebHelper::tableJMGuru();
    }

}
