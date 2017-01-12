<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/1/16
 * Time: 2:11 PM
 */
class KuponWebHelper extends WebService {

    function submit_kupon() {

        $jml_bundle = (int) addslashes($_POST['jml']);

        if (!is_int($jml_bundle) || $jml_bundle < 1) {
            $json['post'] = $_POST;
            $json['status_code'] = 0;
            $json['status_message'] = "Jumlah tidak boleh";
            echo json_encode($json);
            die();
        }

        $parent_id = Generic::getMyParentID(AccessRight::getMyOrgID());
        $req = new RequestModel();
        $req->req_pengirim_org_id = AccessRight::getMyOrgID();
        $req->req_penerima_org_id = $parent_id;
        $req->req_pengirim_user_id = Account::getMyID();
        $req->req_date = leap_mysqldate();
        $req->req_type = "kupon"; //kupon
        $req->req_status = 0;
        $req->req_jumlah = $jml_bundle;

        $succ = $req->save();

        if ($succ) {

            SempoaInboxModel::sendMsg($parent_id, AccessRight::getMyOrgID(), "Permintaan Kupon", "Ada permintaan Kupon <br> Tolong segera di respon");


            $json['status_code'] = 1;
            $json['status_message'] = "Request ID Anda $succ. \n\rPermintaan sudah diproses";
            $json['req_id'] = $succ;
            echo json_encode($json);
            die();
        } else {
            $json['status_code'] = 0;
            $json['status_message'] = "Save Failed";
            echo json_encode($json);
            die();
        }
    }

    function reject_req() {
        $req_id = addslashes($_POST['req_id']);

        $req = new RequestModel();
        $req->getByID($req_id);

        if ($req->req_penerima_org_id != AccessRight::getMyOrgID()) {
            $json['post'] = $_POST;
            $json['status_code'] = 0;
            $json['status_message'] = "Access Right Failed";
            echo json_encode($json);
            die();
        }

        $req->req_status = 2;
        $req->req_perubah_status_user_id = Account::getMyID();
        $req->req_tgl_ubahstatus = leap_mysqldate();
        $succ = $req->save(1);


        if ($succ) {

            SempoaInboxModel::sendMsg($req->req_pengirim_org_id, AccessRight::getMyOrgID(), "Permintaan Kupon Ditolak", "Ada perubahan biaya <br> Tolong sesuaikan harga anda");


            $json['status_code'] = 1;
            $json['status_message'] = "Request sudah dihapus";
            $json['req_id'] = $succ;
            echo json_encode($json);
            die();
        } else {
            $json['status_code'] = 0;
            $json['status_message'] = "Save Failed";
            echo json_encode($json);
            die();
        }
    }

    function accept_req() {

        $req_id = addslashes($_POST['req_id']);

        $req = new RequestModel();
        $req->getByID($req_id);

        if ($req->req_penerima_org_id != AccessRight::getMyOrgID()) {
            $json['post'] = $_POST;
            $json['status_code'] = 0;
            $json['status_message'] = "Access Right Failed";
            echo json_encode($json);
            die();
        }

        $arr_bundle = explode(",", addslashes($_POST['arr_bundle']));

        $arr_simpan = array();
        $success = 0;
        foreach ($arr_bundle as $bund) {
            $val = array();
            $val['end'] = addslashes($_POST['bundle_' . $bund . '_end']);
            $val['start'] = addslashes($_POST['bundle_' . $bund . '_start']);

            $arr_simpan[] = $val;

            $bundle = new KuponBundle();
            $bundle->bundle_start = $val['start'];
            $bundle->bundle_end = $val['end'];
            $bundle->bundle_org_id = $req->req_pengirim_org_id;
            $bundle->kpo_id = AccessRight::getMyOrgID();
            $bundle->bundle_req_id = $req_id;
            $bundle->bundle_size = $val['end'] - $val['start'] + 1;
            $bundle->ibo_id = $req->req_pengirim_org_id;
            $bundle_id = $bundle->save();

            if ($bundle_id) {
                $begin = $val['start'];
                for ($x = $begin; $x <= $val['end']; $x++) {

                    $satuan = new KuponSatuan();
                    $satuan->kupon_bundle_id = $bundle_id;
                    $satuan->kupon_id = $x;
                    $satuan->kupon_owner_id = $req->req_pengirim_org_id;
                    $satuan->kupon_pemakaian_date = leap_mysqldate();
                    if ($satuan->save())
                        $success++;
                    else {

                        //ambil semua bundle dari req_id ini
                        $arrBundle = $bundle->getWhere("bundle_req_id = '$req_id'");
                        foreach ($arrBundle as $bundd) {
                            $bid = $bundd->bundle_id;
                            $bundle->delete($bid);
                            global $db;
                            $q = "DELETE FROM {$satuan->table_name} WHERE kupon_bundle_id = '$bid'";
                            $db->query($q, 0);
                        }

                        $json['status_code'] = 0;
                        $json['status_message'] = "Kupon ID $x sudah terpakai";
                        echo json_encode($json);
                        die();
                    }
                }
            }
        }

        if ($success == (count($arr_bundle) * 25)) {

            $req->req_status = 1;
            $req->req_perubah_status_user_id = Account::getMyID();
            $req->req_tgl_ubahstatus = leap_mysqldate();
            $succ = $req->save(1);

            if ($succ) {

                SempoaInboxModel::sendMsg($req->req_pengirim_org_id, AccessRight::getMyOrgID(), "Permintaan Kupon Dikabulkan", "Ada perubahan biaya <br> Tolong sesuaikan harga anda");
                $org = new SempoaOrg();
                $org->getByID($req->req_pengirim_org_id);

                $jenisbm = new JenisBiayaModel();
                $jenisbm->getByID($req->req_pengirim_org_id . "_". KEY::$BIAYA_ROYALTI); //bahaya krn di hardcode .... //test coba2 dulu myorgid

                TransaksiModel::entry(KEY::$DEBET_ROYALTI_KPO, "Kupon sebanyak $success dikirim ke " . $org->nama, 0, $jenisbm->harga * $success, AccessRight::getMyOrgID());
                TransaksiModel::entry(KEY::$KREDIT_ROYALTI_IBO, "Kupon sebanyak $success dikirim ke " . $org->nama, $jenisbm->harga * $success, 0, $req->req_pengirim_org_id);

                // Alat bantu ngajar
                $jenisbm->getByID($req->req_pengirim_org_id . "_". KEY::$BIAYA_ALAT_BANTU_NGAJAR); //bahaya krn di hardcode .... //test coba2 dulu myorgid

                TransaksiModel::entry(KEY::$DEBET_ALAT_BANTU_MENGAJAR_KPO, "Alat bantu mengajar dikirim ke " . $org->nama . " sebanyak $success", 0, $jenisbm->harga * $success, AccessRight::getMyOrgID());
                TransaksiModel::entry(KEY::$KREDIT_ALAT_BANTU_MENGAJAR_IBO, "Alat bantu mengajar dikirim ke " . $org->nama . " sebanyak $success", $jenisbm->harga * $success, 0, $req->req_pengirim_org_id);


                $json['status_code'] = 1;
                $json['status_message'] = "Success";
                echo json_encode($json);
                die();
            }
        }

        $json['post'] = $_POST;
        $json['status_code'] = 0;
        $json['status_message'] = "Save Failed";
        echo json_encode($json);
        die();
    }

    function getMyBundles() {
        $org_id = AccessRight::getMyOrgID();
        $mybundle = new KuponBundle();
        $arrBundle = $mybundle->getWhere("bundle_org_id = '$org_id'");

//                                pr($arrBundle);


        foreach ($arrBundle as $bud) {
            ?>
            <input class="ads_Checkbox" value="<?= $bud->bundle_id; ?>" type="checkbox" name="bundle_list[]"><?= $bud->bundle_start; ?> - <?= $bud->bundle_end; ?><br>
            <?
        }
    }

    function accept_req_selector() {

        $req_id = addslashes($_GET['req_id']);

        if (!empty($_POST['bundle_list'])) {
// Loop to store and display values of individual checked checkbox.
            foreach ($_POST['bundle_list'] as $selected) {
                $json['post_bundle'][] = $selected;
            }
        }


        $req = new RequestModel();
        $req->getByID($req_id);

        if ($req->req_penerima_org_id != AccessRight::getMyOrgID()) {
            $json['post'] = $_POST;
            $json['status_code'] = 0;
            $json['status_message'] = "Access Right Failed";
            echo json_encode($json);
            die();
        }

        if (count($_POST['bundle_list']) != $req->req_jumlah) {
            $json['status_code'] = 0;
            $json['status_message'] = "Jumlah Mismatched";
            echo json_encode($json);
            die();
        }

        $success = 0;
        foreach ($json['post_bundle'] as $bid) {

            $kp = new KuponBundle();
            $kp->getByID($bid);
            $kp->bundle_org_id = $req->req_pengirim_org_id;
            $kp->tc_id = $req->req_pengirim_org_id;
            $succ = $kp->save(1);

            if ($succ) {
                $satuan = new KuponSatuan();
                global $db;
                $q = "UPDATE {$satuan->table_name} SET kupon_owner_id = '{$req->req_pengirim_org_id}'  WHERE kupon_bundle_id = '$bid'";
                if ($db->query($q, 0))
                    $success++;
            }
        }


        if ($success == (count($json['post_bundle']))) {

            $req->req_status = 1;
            $req->req_perubah_status_user_id = Account::getMyID();
            $req->req_tgl_ubahstatus = leap_mysqldate();
            $succ = $req->save(1);

            $success_satuan = $success * 25;

            if ($succ) {

                SempoaInboxModel::sendMsg($req->req_pengirim_org_id, AccessRight::getMyOrgID(), "Permintaan Kupon Dikabulkan", "Ada perubahan biaya <br> Tolong sesuaikan harga anda");
                $org = new SempoaOrg();
                $org->getByID($req->req_pengirim_org_id);

                $jenisbm = new JenisBiayaModel();
                $jenisbm->getByID($req->req_pengirim_org_id . "_" . KEY::$BIAYA_ROYALTI); //bahaya krn di hardcode ....

                TransaksiModel::entry(KEY::$DEBET_ROYALTI_IBO, "Kupon sebanyak $success_satuan dikirim ke " . $org->nama, 0, $jenisbm->harga * $success_satuan, AccessRight::getMyOrgID());
                TransaksiModel::entry(KEY::$KREDIT_ROYALTI_TC, "Kupon sebanyak $success_satuan dikirim ke " . $org->nama, $jenisbm->harga * $success_satuan, 0, $req->req_pengirim_org_id);

                // Alat Bantu  ngajar
                $jenisbm->getByID($req->req_pengirim_org_id . "_" . KEY::$BIAYA_ALAT_BANTU_NGAJAR);
                TransaksiModel::entry(KEY::$DEBET_ALAT_BANTU_MENGAJAR_IBO, "Alat bantu mengajar dikirim ke " . $org->nama . " sebanyak $success_satuan ", 0, $jenisbm->harga * $success_satuan, AccessRight::getMyOrgID());
                TransaksiModel::entry(KEY::$KREDIT_ALAT_BANTU_MENGAJAR_TC, "Alat bantu mengajar dikirim ke " . $org->nama . " sebanyak $success_satuan ", $jenisbm->harga * $success_satuan, 0, $req->req_pengirim_org_id);



                $json['status_code'] = 1;
                $json['status_message'] = "Success";
                echo json_encode($json);
                die();
            }
        }

        $json['post'] = $_POST;
        $json['status_code'] = 0;
        $json['status_message'] = "Save Failed";
        echo json_encode($json);
        die();
    }

}
