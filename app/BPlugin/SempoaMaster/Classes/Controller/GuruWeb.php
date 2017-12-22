<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/2/16
 * Time: 9:53 AM
 */
class GuruWeb extends WebService
{
    /*
     * [0] =>
      [0] => read_jenis_level_guru
      [1] => create_jenis_level_guru
      [2] => update_jenis_level_guru
      [3] => delete_jenis_level_guru
     */

    function update_jenis_level_guru()
    {

    }

    function delete_jenis_level_guru()
    {

    }

    function create_jenis_level_guru()
    {
        $_GET['cmd'] = 'edit';
        $this->read_jenis_level_guru();
    }

    function read_jenis_level_guru()
    {
        $obj = new SempoaLevel();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_jenis_level_guru");
        $crud->ar_delete = AccessRight::hasRight("delete_jenis_level_guru");
        $crud->ar_edit = AccessRight::hasRight("update_jenis_level_guru");
        $crud->run_custom($obj, "GuruWeb", "read_jenis_level_guru");
    }

//read_jenis_level_lama
//create_jenis_level_lama
//update_jenis_level_lama
//delete_jenis_level_lama

    function create_jenis_level_lama()
    {
        $_GET['cmd'] = 'edit';
        $this->read_jenis_level_lama();
    }

    function read_jenis_level_lama()
    {
        $obj = new SempoaLevelLama();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_jenis_level_lama");
        $crud->ar_delete = AccessRight::hasRight("delete_jenis_level_lama");
        $crud->ar_edit = AccessRight::hasRight("update_jenis_level_lama");
        $crud->run_custom($obj, "GuruWeb", "read_jenis_level_lama");
    }


    function update_jenis_level_lama()
    {

    }

    function delete_jenis_level_lama()
    {

    }

    public function read_guru_ibo()
    {


        if ($_GET['status_guru'] != "") {
            $gw = new GuruWebHelper();
            $gw->guru_crud_per_tc();
            die();
        }


        $myOrgID = (AccessRight::getMyOrgID());
        $arrMyTC = Generic::getAllMyTC($myOrgID);
//        $arrMyTC[''] = "";

        $tcid = $_SESSION['selected_guru_tc_id'];

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

            <button class="btn btn-default" id="submit_status_guru_<?= $t; ?>">submit</button>
            <script>
                $('#submit_status_guru_<?= $t; ?>').click(function () {
                    var slc = $('#pilih_tc_<?= $t; ?>').val();
                    var status = $('#pilih_status_<?= $t; ?>').val();
                    openLw("guru_tc_ibo", "<?= _SPPATH; ?>GuruWebHelper/guru_crud_per_tc?tc_id=" + slc + "&now=" + $.now(), "fade");

                    //$('#content_load_guru_<?=$t;?>').load('<?= _SPPATH; ?>GuruWebHelper/guru_crud_per_tc?tc_id=' + slc +'&status=' + status, function () }, 'json');
                });

            </script>
        </div>


        <?

        die();


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
        die();
        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new SempoaGuruModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_guru_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_guru_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_guru_ibo");
        $crud->run_custom($obj, "GuruWeb", "read_guru_ibo", "  guru_ibo_id = '$myOrgID'");


        die();

    }

    public function read_guru_ibo_hlp()
    {
        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new SempoaGuruModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_guru_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_guru_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_guru_ibo");
        $crud->run_custom($obj, "GuruWeb", "read_guru_ibo_hlp", "  guru_ibo_id = '$myOrgID'");
    }

    public function create_guru_ibo()
    {
        $_GET['cmd'] = 'edit';
        $_GET['new'] = 'new';
        $this->read_guru_ibo_hlp();
    }

    public function update_guru_ibo()
    {

    }

    public function delete_guru_ibo()
    {

    }

    public function get_level_guru_ibo()
    {
        $obj = new SempoaLevel();
        $crud = new CrudCustom();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;
        $crud->run_custom($obj, "GuruWeb", "get_level_guru_ibo");
    }

    public function get_level_guru_tc()
    {
        $obj = new SempoaLevel();
        $crud = new CrudCustom();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;
        $crud->run_custom($obj, "GuruWeb", "get_level_guru_tc");
    }

    public function read_pembayaran_regis_guru()
    {
        $myOrgID = AccessRight::getMyOrgID();
        $objRegisterGuru = new RegisterGuru();
        $arrInv = $objRegisterGuru->getWhere("transaksi_ibo_id='$myOrgID' ORDER BY transaksi_id DESC");
//        pr($arrInv);
        $arrStatus = Generic::getStatus();
        ?>
        <section class="content-header">
            <h1>
                Invoices Registrasi Guru
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
                    foreach ($arrInv as $key => $val) {
                        if ($val->transaksi_status == KEY::$STATUS_NEW)
                            $warna = KEY::$WARNA_BIRU;
                        elseif ($val->transaksi_status == KEY::$STATUS_PAID)
                            $warna = KEY::$WARNA_HIJAU;
                        ?>
                        <tr style="background-color: <?= $warna; ?>">
                            <td><?= $val->transaksi_id; ?></td>
                            <td><?= Generic::getTCNamebyID($val->transaksi_tc_id); ?></td>
                            <td><?= Generic::getGuruNamebyID($val->transaksi_guru_id); ?></td>
                            <td id="status_<?= $val->transaksi_id . "_" . $val->transaksi_guru_id; ?>"><?= $arrStatus[$val->transaksi_status]; ?></td>
                            <td><?= idr($val->transaksi_jumlah); ?></td>
                            <td><?= $val->transaksi_date; ?></td>
                        </tr>
                        <script>
                            $('#status_<?= $val->transaksi_id . "_" . $val->transaksi_guru_id; ?>').dblclick(function () {
                                var current = $("#status_<?= $val->transaksi_id . "_" . $val->transaksi_guru_id; ?>").html();
                                if (current == '<b>Unpaid</b>') {
                                    var html = "<select id='select_status_<?= $val->transaksi_id . "_" . $val->transaksi_guru_id; ?>'>" +
                                        "<option value='0'><b>Unpaid</b></option>" +
                                        "<option value='1'>Paid</option>" +
                                        "</select>";

                                    $("#status_<?= $val->transaksi_id . "_" . $val->transaksi_guru_id; ?>").html(html);
                                    $('#select_status_<?= $val->transaksi_id . "_" . $val->transaksi_guru_id; ?>').change(function () {
                                        var guru_id = "<?= $val->transaksi_guru_id; ?>";
                                        var tr_id = "<?= $val->transaksi_id; ?>";
                                        $.get("<?= _SPPATH; ?>GuruWebHelper/setStatusFirstRegisterGuru?guru_id=" + guru_id + "&tr_id=" + tr_id, function (data) {

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

    public function export_all_guru(){
        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new SempoaGuruModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_guru_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_guru_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_guru_ibo");
        $crud->run_custom($obj, "GuruWeb", "export_all_guru", "  guru_ibo_id = '$myOrgID'");
    }
}
