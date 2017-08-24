<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/1/16
 * Time: 2:02 PM
 */
class KuponWeb extends WebService {
    /*
     * [KuponWeb] => Array
      (
      [0] => get_pemesanan_kupon_tc
      [1] => create_pemesanan_kupon_ibo
      [2] => read_pemesanan_kupon_ibo
      [3] => delete_pemesanan_kupon_ibo
      [4] => update_pemesanan_kupon_ibo
      )
     */

    function create_pemesanan_kupon_tc() {
        $this->create_pemesanan_kupon_ibo();
    }


    function create_pemesanan_kupon_ibo() {
        ?>
        <section class="content-header">

            <h1 style="text-align: center; margin-bottom: 20px;">Pemesanan Kupon</h1>
        </section>
        <div class="clearfix">

        </div>
        <section class="content">


            <div style="text-align: center;">
                <label for="exampleInputName2" style="text-align: center;">Masukan Qty Bundling yang mau dipesan @25pcs per bundling</label><br>
                <input type="number" id="jumlah_bundling" min="1" value="1"  ><br><br>
                <button id="submit_bundling" class="btn btn-lg btn-default" style="width: 20%;">SUBMIT
                </button>
            </div>
        </section>

        <script>
            $('#submit_bundling').click(function () {
                var slc = $('#jumlah_bundling').val();
                if (parseInt(slc) < 1 || slc == "") {
                    alert("Jumlah yang dimasukan tidak boleh");
                } else {
                    var jmlnya = parseInt(slc) * 25;

                    if (confirm("Anda yakin akan meminta " + slc + " bundle kupon (" + jmlnya + " pcs)"))
                        $.post("<?= _SPPATH; ?>KuponWebHelper/submit_kupon", {jml: slc}, function (data) {
                            console.log(data);
                            if (data.status_code) {
                                //success
                                alert(data.status_message);
                            } else {
                                alert(data.status_message);
                            }
                        }, 'json');
                }
            });
        </script>
        <?
    }
    function create_pemesanan_kupon_ibo_backup() {
        ?>
        Masukan Qty Bundling yang mau dipesan @25pcs per bundling
        <input type="number" id="jumlah_bundling" min="1" value="1"  >
        <button id="submit_bundling"  class="btn btn-default">Submit</button>

        <script>
            $('#submit_bundling').click(function () {
                var slc = $('#jumlah_bundling').val();
                if (parseInt(slc) < 1 || slc == "") {
                    alert("Jumlah yang dimasukan tidak boleh");
                } else {
                    var jmlnya = parseInt(slc) * 25;

                    if (confirm("Anda yakin akan meminta " + slc + " bundle kupon (" + jmlnya + " pcs)"))
                        $.post("<?= _SPPATH; ?>KuponWebHelper/submit_kupon", {jml: slc}, function (data) {
                            console.log(data);
                            if (data.status_code) {
                                //success
                                alert(data.status_message);
                            } else {
                                alert(data.status_message);
                            }
                        }, 'json');
                }
            });
        </script>
        <?
    }

    function get_pemesanan_kupon_tc() {
        $myorg_id = AccessRight::getMyOrgID();
        $req = new RequestModel();
        $arr = $req->getWhere("req_status = 0 AND req_type = 'kupon' AND req_penerima_org_id = '$myorg_id'");

        ?>
        <h1><?= count($arr); ?> Pemesanan in need of response</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>
                            REQ ID
                        </th>
                        <th>
                            Tgl Pemesanan
                        </th>
                        <th>
                            Nama TC
                        </th>
                        <th>
                            Qty (in Bundle)
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($arr as $r) {
                        ?>
                        <tr>
                            <td>
                                <?= $r->req_id; ?>
                            </td>
                            <td>
                                <?= indonesian_date($r->req_date); ?><br>
                                <?= ago(strtotime($r->req_date)); ?>
                            </td>
                            <td>
                                <b>
                                    <?
                                    $org = new SempoaOrg();
                                    $org->getByID($r->req_pengirim_org_id);
                                    echo $org->nama;
                                    ?></b>
                                <br><i>
                                    <?
                                    $acc = new SempoaAccount();
                                    $acc->getByID($r->req_pengirim_user_id);
                                    echo $acc->admin_nama_depan;
                                    ?></i>
                            </td>
                            <td>
                                <b><?= $r->req_jumlah; ?></b>
                                <div class="bundle_selector">
                                    <? ?>
                                </div>
                            </td>
                            <td>
                                <button   id="accept_req_<?= $r->req_id; ?>" class="btn btn-default">Accept</button>
                                <button id="reject_req_<?= $r->req_id; ?>" class="btn btn-default">Reject</button>
                            </td>


                        </tr>
                    <script>


                        $('#accept_req_<?= $r->req_id; ?>').click(function () {

                            req_id = '<?= $r->req_id; ?>';
                            jml_bundle_yang_dicari = '<?= $r->req_jumlah; ?>';
                            $.get("<?= _SPPATH; ?>KuponWebHelper/getMyBundles?req_id=<?= $r->req_id; ?>", function (data) {
                                        $('#bundle_form_container_selector').html(data);
                                        $('#modal_bundle_kupon_selector').modal("show");
                                    });

                                });
                                $('#reject_req_<?= $r->req_id; ?>').click(function () {
                                    $.post("<?= _SPPATH; ?>KuponWebHelper/reject_req", {req_id: '<?= $r->req_id; ?>'},
                                            function (data) {
                                                if (data.status_code) {
                                                    alert(data.status_message);
                                                    lwrefresh(selected_page);
                                                    //                                        lwclose(selected_page);
                                                } else {
                                                    alert(data.status_message);
                                                }
                                            }, 'json');
                                });
                    </script>
                <? }
                ?>
                </tbody>
            </table>
        </div>
        <?
    }

    function get_pemesanan_kupon_ibo() {

        $myorg_id = AccessRight::getMyOrgID();
        $req = new RequestModel();
        $arr = $req->getWhere("req_status = 0 AND req_type = 'kupon' AND req_penerima_org_id = '$myorg_id'");

        ?>
        <h1><?= count($arr); ?> Pemesanan in need of response</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>
                            REQ ID
                        </th>
                        <th>
                            Tgl Pemesanan
                        </th>
                        <th>
                            Peminta
                        </th>
                        <th>
                            Qty (in Bundle)
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($arr as $r) {
                        ?>
                        <tr>
                            <td>
                                <?= $r->req_id; ?>
                            </td>
                            <td>
                                <?= indonesian_date($r->req_date); ?><br>
                                <?= ago(strtotime($r->req_date)); ?>
                            </td>
                            <td>
                                <b>
                                    <?
                                    $org = new SempoaOrg();
                                    $org->getByID($r->req_pengirim_org_id);
                                    echo $org->nama;
                                    ?></b>
                                <br><i>
                                    <?
                                    $acc = new SempoaAccount();
                                    $acc->getByID($r->req_pengirim_user_id);
                                    echo $acc->admin_nama_depan;
                                    ?></i>
                            </td>
                            <td>
                                <b><?= $r->req_jumlah; ?></b>
                            </td>
                            <td>
                                <button data-toggle="modal" data-target="#modal_bundle_kupon" id="accept_req_<?= $r->req_id; ?>" class="btn btn-default">Accept</button>
                                <button id="reject_req_<?= $r->req_id; ?>" class="btn btn-default">Reject</button>
                            </td>


                        </tr>
                    <script>


                        $('#accept_req_<?= $r->req_id; ?>').click(function () {

                            req_id = '<?= $r->req_id; ?>';
                            jml_bundle_yang_dicari = '<?= $r->req_jumlah; ?>';
                            create_bundle();
                            //                                bundle_obj = [];
                            //                                jml_bundle = 0;
                            //                                reload_bundle();

                            //                                $.post("<? //=_SPPATH;       ?>//KuponWebHelper/accept_req",{req_id:'<? //=$r->req_id;       ?>//'},
                            //                                    function(data){
                            //                                        if(data.status_code){
                            //                                            alert(data.status_message);
                            //                                        }else{
                            //                                            alert(data.status_message);
                            //                                        }
                            //                                    },'json');
                        });
                        $('#reject_req_<?= $r->req_id; ?>').click(function () {
                            $.post("<?= _SPPATH; ?>KuponWebHelper/reject_req", {req_id: '<?= $r->req_id; ?>'},
                                    function (data) {
                                        if (data.status_code) {
                                            alert(data.status_message);
                                            lwrefresh(selected_page);
                                            //                                        lwclose(selected_page);
                                        } else {
                                            alert(data.status_message);
                                        }
                                    }, 'json');
                        });
                    </script>
                <? }
                ?>
                </tbody>
            </table>
        </div>
        <?
    }

    function read_history_pemesanan_kupon_ibo() {
        $myOrgID = AccessRight::getMyOrgID();
        $kuponRequest = new RequestModel();
        $arrKuponRequest = $kuponRequest->getWhere("req_penerima_org_id='$myOrgID'");
//        pr($arrKuponRequest);
        ?>
        <table class='table table-striped table-responsive'>
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Req. Id </th>
                    <th>Tanggal Pemesanan</th>
                    <th>Peminta</th>
                    <th>Nama Pengirim</th>
                    <th>Nama Penerima</th>
                    <th>Jumlah Bundle</th>
                    <th>Status</th>
                    <th>Tanggal perubahan status</th>
                </tr>
            </thead>
            <tbody>
                <?
                foreach ($arrKuponRequest as $key => $request) {
                    $acc = new SempoaAccount();
                    $acc->getByID($request->req_pengirim_user_id);
                    $acc2 = new SempoaAccount();
                    $acc2->getByID($request->req_perubah_status_user_id);
                    ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $request->req_id; ?></td>
                        <td><?= $request->req_date; ?></td>
                        <td><?= Generic::getOrgNamebyID($request->req_pengirim_org_id); ?></td>
                        <td><?= $acc2->admin_nama_depan; ?></td>
                        <td><?= $acc->admin_nama_depan; ?></td>
                        <td><?= $request->req_jumlah; ?></td>
                        <td><? if($request->req_status == 0) echo "New";
                               if($request->req_status == 1) echo "Accept";
                               if($request->req_status == 2) echo "Reject";?></td>
                        <td><?= $request->req_tgl_ubahstatus; ?></td>
                    </tr>
                    <?
                }
                ?>
            </tbody>
        </table>
        <?
    }

    function get_my_stok_kupon_tc() {
        $myOrgID = AccessRight::getMyOrgID();
        $kuponSatuan = new KuponSatuan();
        $arrKupon = $kuponSatuan->getWhere("kupon_owner_id='$myOrgID' AND kupon_status=0 ORDER by kupon_id ASC");
        ?>
        <table class="table table-striped table-responsive">
            <thead>
                <tr><b>
                <th>No.</th>
                <th>Bundle</th>
                <th >Kupon ID</th>   
            </b>
        </tr>
        </thead>
        <tbody>
        <h3>Total Kupon: <?= count($arrKupon); ?></h3>
        <?
        foreach ($arrKupon as $key => $kupon) {
            ?>

            <tr>
                <td ><?= $key + 1; ?></td>
                <td><?= $kupon->kupon_bundle_id; ?>
                    <!--<span class="caret"></span>-->
                </td>
                <td ><?= $kupon->kupon_id; ?></td>
            </tr>
            <?
        }
        ?>
        </tbody>
        </table>
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

    function read_pemesanan_kupon_tc_tmp() {
        $myOrgID = AccessRight::getMyOrgID();
        $kuponSatuan = new KuponSatuan();
        $arrKupon = $kuponSatuan->getWhere("kupon_owner_id='$myOrgID' AND kupon_status=1 ORDER BY kupon_bundle_id ASC");
//       pr($arrKupon);
        ?>
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>Bundle</th>
                    <th>Kupon ID</th>  
                    <th>Tanggal Pemakaian Kupon</th>  
                    <th>Pembeli</th>  
                </tr>
            </thead>
            <tbody>
            <h3>Total Kupon yang terjual: <?= count($arrKupon); ?></h3>
            <?
            foreach ($arrKupon as $kupon) {
                ?>

                <tr>
                    <td><?= $kupon->kupon_bundle_id; ?>

                    </td>
                    <td><?= $kupon->kupon_id; ?></td>
                    <td><?= $kupon->kupon_pemakaian_date; ?></td>
                    <td><?= 
//                    
                    Generic::getAdminNameByID($kupon->kupon_pemakaian_id); ?></td>
                </tr>
                <?
            }
            ?>
        </tbody>
        </table>
        <?
    }

    function get_my_stok_kupon_ibo() {
        $myOrgId = AccessRight::getMyOrgID();
        $myKuponBundle = new KuponBundle();
        $arrMyKuponBundle = $myKuponBundle->getWhere("bundle_org_id = '$myOrgId'");
        //transaksi__kupon_bundle
        ?>
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Request ID</th>
                    <th>Bundle Start</th>
                    <th>Bundle End</th>
                </tr>
            </thead>
            <tbody>
                <?
                foreach ($arrMyKuponBundle as $key => $bundle) {
                    ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $bundle->bundle_req_id; ?></td>
                        <td><?= $bundle->bundle_start; ?></td>
                        <td><?= $bundle->bundle_end; ?></td>
                    </tr>
                    <?
                }
                ?>
            </tbody>
        </table>
        <?
    }

    function read_pemesanan_kupon_ibo() {
//        Generic::getMyRoot();
        $myOrgID = AccessRight::getMyOrgID();
        $kuponRequest = new RequestModel();
        $arrKuponRequest = $kuponRequest->getWhere("req_pengirim_org_id='$myOrgID' AND req_status = 1");
//        pr($arrKuponRequest);
        ?>
        <table class='table table-striped table-responsive'>
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Req. Id </th>
                    <th>Tanggal Pemesanan</th>
                    <th>Nama Pengirim</th>
                    <th>Nama Penerima</th>
                    <th>Jumlah Bundle</th>
                    <th>Status</th>
                    <th>Tanggal perubahan status</th>
                </tr>
            </thead>
            <tbody>
                <?
                foreach ($arrKuponRequest as $key => $request) {
                     $acc = new SempoaAccount();
                    $acc->getByID($request->req_pengirim_user_id);
                    $acc2 = new SempoaAccount();
                    $acc2->getByID($request->req_perubah_status_user_id);
                    ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $request->req_id; ?></td>
                        <td><?= $request->req_date; ?></td>
                         <td><?= $acc2->admin_nama_depan; ?></td>
                        <td><?= $acc->admin_nama_depan; ?></td>
                        <td><?= $request->req_jumlah; ?></td>
                        <td><? if($request->req_status == 0) echo "New";
                            if($request->req_status == 1) echo "Accept";
                            if($request->req_status == 2) echo "Reject";?></td>
                        <td><?= $request->req_tgl_ubahstatus; ?></td>
                    </tr>
                    <?
                }
                ?>
            </tbody>
        </table>
        <?
    }

    function read_history_pemesanan_kupon_tc() {
        $myOrgID = AccessRight::getMyOrgID();
        $kuponRequest = new RequestModel();
        $arrKuponRequest = $kuponRequest->getWhere("req_penerima_org_id='$myOrgID' AND req_status = 1");
//        pr($arrKuponRequest);
        ?>
        <table class='table table-striped table-responsive'>
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Req. Id </th>
                    <th>Tanggal Pemesanan</th>
                    <th>Nama TC</th>
                    <th>Nama Pengirim</th>
                    <th>Nama Penerima</th>
                    <th>Jumlah Bundle</th>
                    <th>Status</th>
                    <th>Tanggal perubahan status</th>
                </tr>
            </thead>
            <tbody>
                <?
                foreach ($arrKuponRequest as $key => $request) {
                     $acc = new SempoaAccount();
                    $acc->getByID($request->req_pengirim_user_id);
                    $acc2 = new SempoaAccount();
                    $acc2->getByID($request->req_perubah_status_user_id);
                    ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $request->req_id; ?></td>
                        <td><?= $request->req_date; ?></td>
                        <td><?= Generic::getOrgNamebyID($request->req_pengirim_org_id); ?></td>
                        <td><?= $acc2->admin_nama_depan; ?></td>
                        <td><?= $acc->admin_nama_depan; ?></td>
                        <td><?= $request->req_jumlah; ?></td>
                        <td><? if($request->req_status == 0) echo "New";
                            if($request->req_status == 1) echo "Accept";
                            if($request->req_status == 2) echo "Reject";?></td>
                        <td><?= $request->req_tgl_ubahstatus; ?></td>
                    </tr>
                    <?
                }
                ?>
            </tbody>
        </table>
        <?
    }

      function read_pemesanan_kupon_tc() {
//        Generic::getMyRoot();
        $myOrgID = AccessRight::getMyOrgID();
        $kuponRequest = new RequestModel();
        $arrKuponRequest = $kuponRequest->getWhere("req_pengirim_org_id='$myOrgID' AND req_status = 1");
//        pr($arrKuponRequest);
        ?>
        <table class='table table-striped table-responsive'>
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Req. Id </th>
                    <th>Tanggal Pemesanan</th>
                    
                    <th>Nama Pengirim</th>
                    <th>Nama Penerima</th>
                    <th>Jumlah Bundle</th>
                    <th>Tanggal perubahan status</th>
                </tr>
            </thead>
            <tbody>
                <?
                foreach ($arrKuponRequest as $key => $request) {
                     $acc = new SempoaAccount();
                    $acc->getByID($request->req_pengirim_user_id);
                    $acc2 = new SempoaAccount();
                    $acc2->getByID($request->req_perubah_status_user_id);
                    ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $request->req_id; ?></td>
                        <td><?= $request->req_date; ?></td>
                         <td><?= $acc2->admin_nama_depan; ?></td>
                        <td><?= $acc->admin_nama_depan; ?></td>
                        <td><?= $request->req_jumlah; ?></td>
                        <td><?= $request->req_tgl_ubahstatus; ?></td>
                    </tr>
                    <?
                }
                ?>
            </tbody>
        </table>
        <?
    }
}
